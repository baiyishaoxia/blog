<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Background\ImagesClass;
use App\Http\Model\Background\ImagesContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImagesContentController extends Controller
{
    public function index(Request $request)
    {
        $data = ImagesContent::orderBy('Id','desc');

        if($request->get('ImgClass_Id')){
            $img_class_ids = $request->get('ImgClass_Id');
//            $data = $data->whereIn('ImgClass_Id', ImagesClass::where('Id',$request->get('ImgClass_Id'))->pluck('Id')->toArray())
//                ->orWhereIn('ImgClass_Id',ImagesClass::where('Pid',$request->get('ImgClass_Id'))->pluck('Id')->toArray());
            $data = $data->whereIn('ImgClass_Id', function ($query) use($img_class_ids) {
                    return $query->from('images_class')->where('Id',$img_class_ids)->select('Id');
                 })
                ->orWhereIn('ImgClass_Id',function ($query) use($img_class_ids) {
                    return $query->from('images_class')->where('Pid', $img_class_ids)->select('Id');
                 });
        }
        if($request->get('keywords')){
            $data = $data->where('Title', 'like','%'.$request->get('keywords').'%');
        }
        $data = $data->paginate(48);
        return view('admin.images_content.list',compact('data'));
    }

    //region   新增        tang
    public function getCreate()
    {
        return view('admin.images_content.create');
    }
    public function postCreate(Request $request)
    {
        $input=$request->all();
        if(!isset($input['photo'])){
            return back()->withInput()->withErrors('请上传需要的图片');
        }
        $imgs = array();
        foreach ($input['photo'] as $key => $data){
            $imgs[] = $data['path'];
        }
        \DB::beginTransaction();
        $count = 0;
        foreach ($imgs as $key => $val){
            $img = new ImagesContent();
            $img->ImgClass_Id = $input['ImgClass_Id'];
            $img->Icon = $val;
            $img->save();
            $count++;
        }
        if($count == count($imgs)){
            \DB::commit();
            return redirect(\URL::action('Admin\ImagesListController@index'))->withSuccess('新增成功');
        }else{
            \DB::rollBack();
            return back()->withInput()->withErrors('数据异常,新增失败');
        }
    }
    //endregion

    //region   批量删除        tang
    public function postDel(Request $request)
    {
        $re = ImagesContent::destroy($request->get('id'));
        if($re){
            return redirect(\URL::action('Admin\ImagesListController@index'))->withSuccess('删除成功');
        }else{
            return back()->withInput()->withErrors('数据异常,删除失败');
        }
    }
    //endregion

    //region   单个删除        tang
    public function del(Request $request)
    {
        $re = ImagesContent::where('Id',$request->get('id'))->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'  =>'恭喜,删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'  =>'抱歉,删除失败,请稍后重试!',
            ];
        }
        return $data;
    }
    //endregion
}
