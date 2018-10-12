<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\ToolsContent;
use App\Http\Model\Admin\ToolsContentAttache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolsContentController extends Controller
{
    //region   列表        tang
    public function getIndex(Request $request)
    {
        $data = ToolsContent::orderBy('sort','asc')->orderBy('id','desc');
        if($request->get('field')=='red'){
            $data = $data->where('is_red', 1);
        }elseif ($request->get('field')=='top'){
            $data = $data->where('is_top', 1);
        }elseif ($request->get('field')=='hot'){
            $data = $data->where('is_hot', 1);
        }elseif ($request->get('field')=='slide'){
            $data = $data->where('is_slide', 1);
        }
        if($request->get('list_id') != null){
            $list_id = $request->get('list_id');
            $data = $data->whereIn('list_id', function ($query) use($list_id) {
                return $query->from('tools_content')->where('list_id',$list_id)->select('id');
            })->orWhereIn('list_id',function ($query) use($list_id) {
                return $query->from('tools_list')->where('id', $list_id)->select('id');
            });
        }
        if($request->get('field')=='title'){
            if($request->has('keywords')){
                $data = $data->where($request->get('field'), 'like','%'.$request->get('keywords').'%');
            }
        }
        $data = $data->paginate(15);
        $type=  'soft';
        return view('admin.tools_content.list',compact('data','type'));
    }
    //endregion

    //region   创建        tang
    public function getCreate()
    {
        return view('admin.tools_content.create');
    }
    public function postCreate(Request $request)
    {
        if(!isset($request->list_id)){
            return back()->withInput()->withErrors('请选择所属分类');
        }
        //入库
        $data['list_id'] = $request->list_id;
        $data['call_index'] = $request->call_index;
        $data['title'] = $request->call_index;
        $data['link'] = $request->link;
        $data['img'] = $request->img;
        $data['file_url'] = $request->file_url;
        $data['sort'] = $request->sort;
        $data['intro'] = $request->intro;
        $data['abstract'] = $request->abstract;
        $data['content'] = $request->get('content');
        $data['is_top'] = $request->has('is_top')?$request->is_top:0;
        $data['is_red'] = $request->has('is_red')?$request->is_red:0;
        $data['is_hot'] = $request->has('is_hot')?$request->is_hot:0;
        $data['is_slide'] = $request->has('is_slide')?$request->is_slide:0;
        $data['seo_title'] = $request->seo_title;
        $data['seo_keywords'] = $request->seo_keywords;
        $data['seo_description'] = $request->seo_description;
        \DB::beginTransaction();
        $res1 = ToolsContent::create($data);
        $content_id = \DB::getPdo()->lastInsertId();
        if(!isset($request->attach)){
            $attachs = ['0'=>'1'];
            $count = 1;
            $res2 = true;
        }else{
            //存储附件
            $attachs = $request->attach;
            $count = 0;
            foreach ($attachs as $key => $val){
                $attach = new ToolsContentAttache();
                $attach->content_id = $content_id;
                $attach->filename = $val['filename'];
                $attach->filepath = $val['filepath'];
                $attach->filesize = $val['filesize'];
                $attach->point    = $val['point'];
                $res2 = $attach->save();
                $count ++ ;
            }
        }
        if(($count == count($attachs)) && $res1 && $res2){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withSuccess('创建成功');
        }else{
            \DB::rollBack();
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id)
    {
//        if(!count(ToolsContentAttache::where('content_id',$id)->get())){
//            $data =  ToolsContent::find($id);
//        }else{
//            $data = ToolsContent::join('tools_content_attache','tools_content_attache.content_id','=','tools_content.id')->where('tools_content.id',$id)->first();
//        }
        $data =  ToolsContent::find($id);
        return view('admin.tools_content.edit',compact('data'));
    }
    public function postEdit(Request $request)
    {
         $content = ToolsContent::find($request->id);
         $content->list_id = $request->get('list_id');
         $content->call_index = $request->get('call_index');
         $content->title = $request->get('title');
         $content->link = $request->get('link');
         $content->img = $request->get('img');
         $content->file_url = $request->get('file_url');
         $content->sort = $request->get('sort');
         $content->intro = $request->get('intro');
         $content->click = $request->get('click');
         $content->abstract = $request->get('abstract');
         $content->content = $request->get('content');
         $content->is_top   =$request->has('is_top')?1:0;
         $content->is_red   =$request->has('is_red')?1:0;
         $content->is_hot   =$request->has('is_hot')?1:0;
         $content->is_slide =$request->has('is_slide')?1:0;
         $content->seo_title = $request->get('seo_title');
         $content->seo_keywords = $request->get('seo_keywords');
         $content->seo_description = $request->get('seo_description');
         $res1 = $content->save();
         //修改附件
         if(count($content->attach->toArray())>0){
             $content->attach()->delete();
         }
         if ($request->has('attach')) {
            $attach=$request->get('attach');
            foreach ($attach as $key => $value){
                $attach[$key]=new ToolsContentAttache($value);
            }
            $res2 = $content->attach()->saveMany($attach);
         }else{
            $res2=true;
         }
         if($res1 && $res2){
             \DB::commit();
             return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withErrors('修改成功!');
         }else{
             \DB::rollBack();
             return back()->withErrors('修改失败!');
         }
    }
    //endregion

    //region   下载        tang
    public function getDownLoad($id){
        $down = ToolsContentAttache::where('content_id', $id)->first();
        $filepath = $down['filepath'];
        $file_name = $down['filename'];
        $reg = ' ';
        $file_name = str_replace($reg, ' ', $file_name);
        $filepath = 'storage/'.$filepath;
        $filename=realpath($filepath); //绝对路径的文件名
        $file_name = mb_convert_encoding($file_name,'GBK','utf-8');
        Header( "Content-type:  application/octet-stream ");
        Header( "Accept-Ranges:  bytes ");
        Header( "Accept-Length: " .filesize($filename));
        header( "Content-Disposition:  attachment;  filename= {$file_name}");
        readfile($filename);
    }
    //endregion

    //region   属性        tang
    public function getTop(Request $request)
    {
        $content=ToolsContent::find($request->id);
        $content->is_top=$content->is_top?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withErrors("设置成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("设置失败");
        }
    }
    public function getRed(Request $request)
    {
        $content=ToolsContent::find($request->id);
        $content->is_red=$content->is_red?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withErrors("设置成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("设置失败");
        }
    }
    public function getHot(Request $request)
    {
        $content=ToolsContent::find($request->id);
        $content->is_hot=$content->is_hot?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withErrors("设置成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("设置失败");
        }
    }
    public function getSlide(Request $request)
    {
        $content=ToolsContent::find($request->id);
        $content->is_slide=$content->is_slide?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withErrors("设置成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("设置失败");
        }
    }
    //endregion

    //region   全部保存        tang
    public function postSave(Request $request){
        $input=$request->all();
        if(isset($input['data'])){
            foreach ($input['data'] as $id => $data){
                $category_data = ToolsContent::find($id);
                $category_data -> sort =$data['sort'];
                $category_data -> save();
            }
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withSuccess("保存排序成功");
        }else{
            return back()->withErrors("没有数据,无需保存!");
        }
    }
    //endregion

    //region   软删除        tang
    public function postSoftDel(Request $request){
        try {
            $input = $request->all();
            ToolsContent::destroy($input['id']);
            return redirect(\URL::action('Admin\ToolsContentController@getIndex'))->withSuccess("删除成功");
        }catch (\Exception $e){
            \Log::info($e);
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   进入回收站        tang
    public function getRecycleList(Request $request){
        $data = ToolsContent::onlyTrashed()->orderby('id', 'desc');
        if($request->get('field')=='red'){
            $data = $data->where('is_red', true);
        }elseif ($request->get('field')=='top'){
            $data = $data->where('is_top', true);
        }elseif ($request->get('field')=='hot'){
            $data = $data->where('is_hot', true);
        }elseif ($request->get('field')=='slide'){
            $data = $data->where('is_slide', true);
        }
        if($request->get('list_id') != null){
            $list_id = $request->get('list_id');
            $data = $data->whereIn('list_id', function ($query) use($list_id) {
                return $query->from('tools_content')->where('list_id',$list_id)->select('id');
            })->orWhereIn('list_id',function ($query) use($list_id) {
                return $query->from('tools_list')->where('id', $list_id)->select('id');
            });
        }
        if($request->get('field')=='title'){
            if($request->has('keywords')){
                $data = $data->where($request->get('field'), 'like','%'.$request->get('keywords').'%');
            }
        }
        $data = $data->paginate(15);
        $type=  'del';
        return view('admin.tools_content.list',compact('data','type'));
    }
    //endregion

    //region   还原        tang
    public function postRestore(Request $request){
        $ids = $request->get('id');
        if($ids){
            ToolsContent::withTrashed()->whereIn('id',$ids)->restore();
            return redirect(\URL::action('Admin\ToolsController@getRecycleList'))->withErrors('还原成功');
        }else{
            return back()->withErrors('还原失败,请选择需要还原的数据');
        }
    }
    //endregion

    //region   彻底删除数据        tang
    public function postDel(Request $request){
        ToolsContentAttache::whereIn("content_id",$request->get('id'))->delete();
        ToolsContent::whereIn('id',$request->get('id'))->forceDelete();
        return redirect(\URL::action('Admin\ToolsContentController@getRecycleList'))->withSuccess("删除成功");
    }
    //endregion

}
