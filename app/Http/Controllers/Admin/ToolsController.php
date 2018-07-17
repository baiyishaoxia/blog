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
    public function getIndex()
    {
        $tree =ToolsList::orderBy('sort','asc')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['text'] = '<span class="folder-open"></span>'.$value['text'];
        }
        $data = Tree::getCateTrees($tree,'text','parent_id','id','<span class="folder-line"></span>');
        return view('admin.tools.list',compact('data'));
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
            $re = ToolsList::whereIn('id',$input['id'])->delete();
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
}
