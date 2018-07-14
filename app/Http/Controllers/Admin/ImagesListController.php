<?php

namespace App\Http\Controllers\Admin;

use App\Common\Tree;
use App\Http\Model\Background\ImagesClass;
use App\Http\Model\Background\ImagesContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ImagesListController extends Controller
{
    //region   显示        tang
    public function index()
    {
        $tree = ImagesClass::orderBy('Sort','asc')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['Name'] = '<span class="folder-open"></span>'.$value['Name'];
        }
        $data = Tree::getCateTree($tree,'<span class="folder-line"></span>');
        return view('admin.images_list.list',compact('data'));
    }
    //endregion

    //region   新增        tang
    public function getCreate($Pid='')
    {
        return view('admin.images_list.create',compact('Pid'));
    }
    public function postCreate(Request $request)
    {
        $input = Input::except('_token','file');
        $rules = [
            'Name' =>'required',
        ];
        $message = [
            'Name.required'=>'分类名称不能为空',
        ];
        $validator = \Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['Time'] = Carbon::now();
            $re = ImagesClass::create($input);
            if($re){
                return redirect(\URL::action('Admin\ImagesListController@index'))->withSuccess('创建成功');
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
        return view('admin.images_list.edit',compact('id'));
    }
    public function postEdit()
    {
        $input = Input::except('_token','file');
        if($input['Pid']!= $input['Id']) {
            $input['Pid'] = $input['Pid'];
        }else{
            return back()->withInput()->withErrors("父级不可以是本身");
        }
        if(ImagesClass::where('Pid',$input['Id'])->count()>0 && $input['Pid']!=null){
            return back()->withInput()->withErrors("该父级有子级,请先删除子级后修改");
        }
        $rules = [
            'Name' =>'required',
        ];
        $message = [
            'Name.required'=>'分类名称不能为空',
        ];
        $validator = \Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['Time'] = Carbon::now();
            $re = ImagesClass::where('Id',$input['Id'])->update($input);
            if($re){
                return redirect(\URL::action('Admin\ImagesListController@index'))->withSuccess('修改成功');
            }else{
                return back()->withInput()->withErrors('数据异常,修改失败');
            }
        }else{
            return back()->withInput()->withErrors($validator);
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request)
    {
        $input = $request->all();
        try{
            if (ImagesContent::whereIn('ImgClass_Id',$input['id'])->count()>0){
                return redirect(\URL::action('Admin\ImagesListController@index'))->withSuccess("分类下存在内容，请删除完后再进行此操作");
            }
            if(ImagesClass::whereIn('Pid',$input['id'])->count()>0){
                return back()->withInput()->withErrors("该父级有子级,请先删除子级后删除");
            }else{
                $re = ImagesClass::whereIn('Id',$input['id'])->delete();
                if($re){
                    return back()->withErrors("删除成功");
                }else{
                    return back()->withErrors("数据异常,删除失败");
                }
            }
        }catch (\Exception $e){
            //AdminErrorLog::log($e);
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   保存        tang
    public function postSave(Request $request){
        $input=$request->all();
        foreach ($input['data'] as $id => $data){
            $category_data = ImagesClass::find($id);
            $category_data -> Sort =$data['sort'];
            $category_data -> save();
        }
        return redirect(\URL::action('Admin\ImagesListController@index'))->withSuccess("保存排序成功");
    }
    //endregion

}
