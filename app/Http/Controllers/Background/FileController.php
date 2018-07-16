<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\File;
use App\Http\Model\Background\FileKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    //region   显示        tang
    public function getList(Request $request){
        $data = File::orderby('id', 'desc');
        if($request->has('keywords')){
            $data = $data->where($request->get('field'), $request->get('keywords'));
        }
        $data = $data->paginate(15);
        return view('background.file.list', compact('data'));
    }
    //endregion

    //region   新增        tang
    public function getCreate(){
        return view('background.file.create');
    }
    public function postCreate(Request $request){
        try
        {
            $data = $request->all();
            $data['is_enable'] = isset($data['is_enable'])?true:false;
            if(File::create($data)){
                return redirect(\URL::action('Background\FileController@getList'))->withErrors('添加成功');
            }else{
                return back()->withInput()->withErrors('添加失败');
            }
        }catch (\Exception $e)
        {
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id){
        $data = File::find($id);
        return view('background.file.edit', compact('data'));
    }
    public function postEdit(Request $request){
        $data = File::find($request->get('id'));
        $data->name = $request->get('name');
        $data->key = $request->get('key');
        $data->is_enable = $request->has('is_enable')?true:false;
        if($data->save()){
            return redirect(\URL::action('Background\FileController@getList'))->withErrors('修改成功');
        }else{
            return back()->withInput()->withErrors('修改失败');
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        try
        {
            \DB::beginTransaction();
            $key_Ret = true;
            $ret = File::whereIn('id', $request->get('id'))->delete();
            if(FileKey::whereIn('file_id', $request->get('id'))->count() > 0){
                $key_Ret = FileKey::whereIn('file_id', $request->get('id'))->delete();
            }
            if($ret && $key_Ret){
                \DB::commit();
                return redirect(\URL::action('Background\FileController@getList'))->withErrors('删除成功');
            }else{
                \DB::rollBack();
                return back()->withInput()->withErrors('删除失败');
            }
        }catch (\Exception $e){
            return back()->withErrors("操作异常");
        }
    }
    //endregion
}
