<?php

namespace App\Http\Controllers\Admin;

use App\Common\Tree;
use App\Http\Model\Admin\ToolsList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class ToolsController extends Controller
{
    //region   工具类        tang
    public function getIndex(Request $request)
    {
        $data = ToolsList::orderBy('sort','asc')->orderBy('id','desc');
        if($request->get('field')=='red'){
            $data = $data->where('is_red', true);
        }elseif ($request->get('field')=='top'){
            $data = $data->where('is_top', true);
        }elseif ($request->get('field')=='hot'){
            $data = $data->where('is_hot', true);
        }elseif ($request->get('field')=='slide'){
            $data = $data->where('is_slide', true);
        }
        if($request->get('id')){
            $id = $request->get('id');
            $data = $data->whereIn('id', function ($query) use($id) {
                return $query->from('tools_list')->where('id',$id)->select('id');
            })->orWhereIn('id',function ($query) use($id) {
                return $query->from('tools_list')->where('parent_id', $id)->select('id');
            });
        }
        if($request->get('keywords')){
            $data = $data->where('text', 'like','%'.$request->get('keywords').'%');
        }
        $tree = $data->get()->toArray();
        //$tree =ToolsList::orderBy('sort','asc')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['text'] = '<span class="folder-open"></span>'.$value['text'];
        }
        $data = Tree::getCateTrees($tree,'text','parent_id','id','<span class="folder-line"></span>');
        $type = 'soft';
        return view('admin.tools.list',compact('data','type'));
    }
    //endregion


    //region  创建        tang
    public function getCreate($parent_id='')
    {
        return view('admin.tools.create',compact('parent_id'));
    }
    public function postCreate()
    {
        //dd(Input::all());
        $input = Input::except('_token','file');
        $rules = [
            'text' =>'required',
        ];
        $message = [
            'text.required'=>'标题不能为空',
        ];
        $validator = \Validator::make($input,$rules,$message);
        if($validator->passes()){
            //批量上传
            if(isset($input['photo'])){
                $img = array();
                foreach ($input['photo'] as $key => $val){
                    $img[]=$val['path'];
                }
                $input['imgs']  = json_encode($img);
                unset($input['photo']);
            }
            if(isset($input['Version'])){
                $input['file_version'] = $input['Version'];
                $input['file_system'] = $input['System'];
                $input['file_path'] = $input['Path'];
                $input['file_log'] = $input['Log'];
                unset($input['Version']);unset($input['System']);
                unset($input['Path']);unset($input['Log']);
                //文件标识
                $input['files'] = true;
            }
            $re = ToolsList::create($input);
            if($re){
                return redirect(\URL::action('Admin\ToolsController@getIndex'))->withSuccess('创建成功');
            }else{
                return back()->withInput()->withErrors('数据异常,新增失败');
            }
        }else{
            return back()->withInput()->withErrors($validator);
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id)
    {
        $img = ToolsList::where('id',$id)->value('Imgs');
        $imgs = [];
        if(is_string($img)){
            $imgs = \Qiniu\json_decode($img);
        }
        return view('admin.tools.edit',compact('id','imgs'));
    }
    public function postEdit()
    {
        $input = Input::except('_token', 'file');
        //dd($input);
        if ($input['parent_id'] != $input['id']) {
            $input['parent_id'] = $input['parent_id'];
        } else {
            return back()->withInput()->withErrors("父级不可以是本身");
        }
        if (ToolsList::where('parent_id', $input['id'])->count() > 0 && $input['parent_id'] != null) {
            return back()->withInput()->withErrors("该父级有子级,请先删除子级后修改");
        }
        $rules = [
            'text' => 'required',
        ];
        $message = [
            'text.required' => '分类名称不能为空',
        ];
        $validator = \Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            //批量上传
            if(isset($input['photo'])){
                $img = array();
                foreach ($input['photo'] as $key => $val){
                    $img[]=$val['path'];
                }
                $input['imgs']  = json_encode($img);
                unset($input['photo']);
            }
            //文件上传
            if(isset($input['Version'])){
                $input['file_version'] = $input['Version'];
                $input['file_system'] = $input['System'];
                $input['file_path'] = $input['Path'];
                $input['file_log'] = $input['Log'];
                unset($input['Version']);unset($input['System']);
                unset($input['Path']);unset($input['Log']);
                //文件标识
                $input['files'] = true;
            }
            $re = ToolsList::where('id', $input['id'])->update($input);
            if ($re) {
                return redirect(\URL::action('Admin\ToolsController@getIndex'))->withSuccess('修改成功');
            } else {
                return back()->withInput()->withErrors('数据异常,修改失败');
            }
        } else {
            return back()->withInput()->withErrors($validator);
        }
    }
    //endregion

    //region   保存        tang
    public function postSave(Request $request){
        $input=$request->all();
        foreach ($input['data'] as $id => $data){
            $category_data = ToolsList::find($id);
            $category_data -> sort =$data['sort'];
            $category_data -> save();
        }
        return redirect(URL::action('Admin\ToolsController@getIndex'))->withSuccess("保存排序成功");
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request)
    {
        $input = $request->all();
        try{
            if(ToolsList::whereIn('parent_id',$input['id'])->count()>0){
                return back()->withInput()->withErrors("该父级有子级,请先删除子级后删除");
            }
            //$re = ToolsList::whereIn('id',$input['id'])->delete();                  //未开启软删除可直接使用删除
            $re = ToolsList::whereIn('id',$request->get('id'))->forceDelete(); //此写法为开启了软删除
            if($re){
                return back()->withErrors("删除成功");
            }else{
                return back()->withErrors("数据异常,删除失败");
            }
        }catch (\Exception $e){
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region      选项[置顶/推荐/热门/幻灯片]        tang
    public function getTop($id){
        $content=ToolsList::find($id);
        $content->is_top=$content->is_top?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsController@getIndex'))->withErrors("修改成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("添加失败");
        }
    }
    public function getRed($id){
        $content=ToolsList::find($id);
        $content->is_red=$content->is_red?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsController@getIndex'))->withErrors("修改成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("添加失败");
        }
    }
    public function getHot($id){
        $content=ToolsList::find($id);
        $content->is_hot=$content->is_hot?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsController@getIndex'))->withErrors("修改成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("添加失败");
        }
    }
    public function getSlide($id){
        $content=ToolsList::find($id);
        $content->is_slide=$content->is_slide?false:true;
        if($content->save()){
            \DB::commit();
            return redirect(\URL::action('Admin\ToolsController@getIndex'))->withErrors("修改成功");
        }else{
            \DB::rollBack();
            return back()->withErrors("添加失败");
        }
    }
    //endregion

    //region   移动到回收站        tang
    public function postSoftDel(Request $request)
    {
        try {
            $input = $request->all();
            ToolsList::destroy($input['id']);
            return redirect(\URL::action('Admin\ToolsController@getIndex'))->withSuccess("软删除成功");
        }catch (\Exception $e){
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   回收站列表        tang
    public function getRecycleList()
    {
        $tree =ToolsList::onlyTrashed()->orderBy('id', 'desc')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['text'] = '<span class="folder-open"></span>'.$value['text'];
        }
        $data = Tree::getCateTrees($tree,'text','parent_id','id','<span class="folder-line"></span>');
        $type=  'del';
        return view('admin.tools.list',compact('data','type'));
    }
    //endregion

    //region   回收站内数据彻底删除        tang
    public function postRecycleDel(Request $request)
    {
        ToolsList::whereIn('id',$request->get('id'))->forceDelete();
        ToolsList::whereIn('parent_id',$request->get('id'))->update(['parent_id'=>null]);
        return redirect(\URL::action('Admin\ToolsController@getRecycleList'))->withSuccess("删除成功");
    }
    //endregion

    //region   回收站内数据还原        tang
    public function postRestore(Request $request)
    {
        $ids = $request->get('id');
        if($ids){
            ToolsList::withTrashed()->whereIn('id',$ids)->restore();
            return redirect(\URL::action('Admin\ToolsController@getRecycleList'))->withErrors('还原成功');
        }else{
            return back()->withErrors('还原失败,请选择需要还原的数据');
        }
    }
    //endregion
}
