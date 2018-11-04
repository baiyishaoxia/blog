<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function getList(){
        $data=Admin::where('email','<>',Admin::info()->email)->get();
        return view('background.admin.list',compact('data'));
    }

    //region   创建        tang
    public function getCreate(){
        return view('background.admin.create');
    }
    public function postCreate(Request $request){
        try
        {
            $input=$request->only("admin_role_id","is_lock","email","password","username","mobile","password_confirmation");
            unset($input['password_confirmation']);
            $res = Admin::create($input);
            if($res ){
                return redirect(\URL::action('Background\AdminController@getList'))->withErrors("添加成功");
            }else{
                return back()->withErrors("添加失敗");
            }
        }catch (\Exception $e)
        {
            //AdminErrorLog::log($e);
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id){
        $data=Admin::find($id);
        return view('background.admin.edit',compact('data'));
    }
    public function postEdit(Request $request){
        try
        {
            $admin=Admin::where('id',$request->get('id'))->first();
            $admin->admin_role_id   =$request->get('admin_role_id');
            $admin->is_lock         =$request->has('is_lock')?true:false;
            $admin->email           =$request->get('email');
            $admin->username            =$request->get('name');
            $admin->mobile          =$request->get('mobile');
            if($request->get('password')){
                $admin->password    =$request->get('password');
            }
            if($admin->save()){
                return redirect(\URL::action('Background\AdminController@getList'))->withErrors("修改成功");
            }else{
                return back()->withErrors("修改失敗");
            }
        }catch (\Exception $exception)
        {
            //AdminErrorLog::log($exception);
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        $input=$request->all();
        if(Admin::whereIn('id',$input['id'])->where('id','<>','1')->delete()){
            return redirect(\URL::action('Background\AdminController@getList'))->withErrors("删除成功");
        }else{
            return back()->withErrors("删除失败");
        }
    }
    //endregion

    //region   授权        tang
    public function getAuthorizedLogin($admin_id, $super_id)
    {
       //$admin_id   要授权登录的管理员的ID（Crypt::decrypt加密）
       //$super_id   当前管理员的ID(Crypt::decrypt加密)
        return redirect(\URL::action('Admin\LoginController@getAuthorizedLogin',['super_id'=>$super_id,'admin_id'=>$admin_id]));
    }
    //endregion
}
