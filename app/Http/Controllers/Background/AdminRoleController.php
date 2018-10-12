<?php

namespace App\Http\Controllers\Background;

use App\Common\Tree;
use App\Http\Model\Admin;
use App\Http\Model\Background\AdminNavigation;
use App\Http\Model\Background\AdminNavigationNode;
use App\Http\Model\Background\AdminRole;
use App\Http\Model\Background\AdminRoleNode;
use App\Http\Model\Background\AdminRoleNodeRoute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
    //region   列表        tang
    public function getList(){
        $data=AdminRole::all();
        return view('background.admin_role.list',compact('data'));
    }
    //endregion

    //region   创建        tang
    public function getCreate(){
        $tree=AdminNavigation::orderBy('sort')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['title']='<span class="folder-open"></span>'.$value['title'];
            $tree[$key]['child']=AdminNavigationNode::where('admin_navigation_id','=',$value['id'])->orderBy('sort')->get()->toArray();
        }
        $tree=Tree::unlimitedForLevel($tree,'<span class="folder-line"></span>');
        return view('background.admin_role.create',compact('tree'));
    }
    public function postCreate(Request $request){
        try
        {
            $input=$request->all();
            $input['is_sys']=isset($input['is_sys'])?true:false;
            #如果是超级管理员
            if($input['role_type']=='0'){
                if(AdminRole::create(['role_name'=>$input['role_name'],'is_super'=>true,'is_sys'=>$input['is_sys']])){
                    return redirect(\URL::action('Background\AdminRoleController@getList'))->withErrors("添加成功");
                }else{
                    return back()->withInput()->withErrors("添加失败");
                }
            }else{
                if(isset($input['route'])==false){
                    return back()->withInput()->withErrors("请至少勾选一个权限");
                }
                #如果是普通管理员
                $res = \DB::transaction(function () use($input){
                    #添加到AdminRole
                    $res1=AdminRole::create([
                        'role_name'=>$input['role_name'],
                        'is_super'=>false,
                        'is_sys'=>$input['is_sys']
                    ]);
                    #添加AdminRoleNode
                    $navigation_node=array_unique(AdminNavigationNode::whereIn('id',$input['route'])->pluck('admin_navigation_id')->toArray());
                    $navigation_node=AdminNavigationNode::getNavigation($navigation_node,$res1->id);
                    $res2=AdminRoleNode::insert($navigation_node);
                    #添加AdminRoleNodeRoute
                    foreach ($input['route'] as $key => $val){
                        $admin_role_route_node[$key]['admin_role_id']=$res1->id;
                        $admin_role_route_node[$key]['admin_navigation_node_id']=$val;
                    }
                    $res3=AdminRoleNodeRoute::insert($admin_role_route_node);
                    return $res1 && $res2 && $res3;
                });
                if($res){
                    return redirect(\URL::action('Background\AdminRoleController@getList'))->withErrors("添加成功");
                }else{
                    return back()->withInput()->withErrors("添加失败");
                }
            }
        }catch (\Exception $e)
        {
            //AdminErrorLog::log($e);
            return back()->withInput()->withErrors("操作异常");
        }
    }
    //endregion

    //region   修改        tang
    public function getEdit($id){
        #所有的权限节点
        $tree=AdminNavigation::orderBy('sort')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['title']='<span class="folder-open"></span>'.$value['title'];
            $tree[$key]['child']=AdminNavigationNode::where('admin_navigation_id','=',$value['id'])->orderBy('sort')->get()->toArray();
        }
        $tree=Tree::unlimitedForLevel($tree,'<span class="folder-line"></span>');
        //角色数据
        $data=AdminRole::find($id);
        //路由权限节点数据
        $route_data=AdminRoleNodeRoute::where('admin_role_id',$id)->pluck('admin_navigation_node_id')->toJson();
        return view('background.admin_role.edit',compact('tree','data','route_data'));
    }
    public function postEdit(Request $request){
        try
        {
            $input=$request->all();
            $input['is_sys']=isset($input['is_sys'])?true:false;
            #如果是超级管理员
            if($input['role_type']=='0'){
                $admin_role=AdminRole::find($input['id']);
                $admin_role->role_name=$input['role_name'];
                $admin_role->is_super   =true;
                $admin_role->is_sys     =$input['is_sys'];
                if($admin_role->save()){
                    return redirect(\URL::action('Background\AdminRoleController@getList'))->withErrors("修改成功");
                }else{
                    return back()->withInput()->withErrors("修改失败");
                }
            }else{
                if(isset($input['route'])==false){
                    return back()->withInput()->withErrors("请至少勾选一个权限");
                }
                #如果是普通管理员
                if(\DB::transaction(function () use($input){
                    #修改AdminRole
                    $admin_role=AdminRole::find($input['id']);
                    $admin_role->role_name  =$input['role_name'];
                    $admin_role->is_super   =false;
                    $admin_role->is_sys     =$input['is_sys'];
                    $res1=$admin_role->save();
                    #刪除AdminRoleNode并添加AdminRoleNode
                    if(AdminRoleNode::where('admin_role_id',$admin_role->id)->count()>0){
                        $del1=AdminRoleNode::where('admin_role_id',$admin_role->id)->delete();
                    }else{
                        $del1=true;
                    }
                    $navigation_node=array_unique(AdminNavigationNode::whereIn('id',$input['route'])->pluck('admin_navigation_id')->toArray());
                    $navigation_node=AdminNavigationNode::getNavigation($navigation_node,$admin_role->id);
                    $res2=AdminRoleNode::insert($navigation_node);
                    #添加AdminRoleNodeRoute
                    if(AdminRoleNodeRoute::where('admin_role_id',$admin_role->id)->count()>0){
                        $del2=AdminRoleNodeRoute::where('admin_role_id',$admin_role->id)->delete();
                    }else{
                        $del2=true;
                    }
                    foreach ($input['route'] as $key => $val){
                        $admin_role_route_node[$key]['admin_role_id']=$admin_role->id;
                        $admin_role_route_node[$key]['admin_navigation_node_id']=$val;
                    }
                    $res3=AdminRoleNodeRoute::insert($admin_role_route_node);
                    return $res1 && $res2 && $res3 && $del1 && $del2;
                })){
                    return redirect(\URL::action('Background\AdminRoleController@getList'))->withErrors("添加成功");
                }else{
                    return back()->withInput()->withErrors("添加失败");
                }
            }
        }catch (\Exception $e)
        {
            //AdminErrorLog::log($e);
            return back()->withInput()->withErrors("操作异常");
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        $input=$request->all();
        if(Admin::whereIn('admin_role_id',$input['id'])->count()>0){
            return back()->withErrors("该角色下存在管理员");
        }
        if(\DB::transaction(function () use($input){
            #删除AdminRoleNode
            $res1=AdminRoleNode::whereIn("admin_role_id",$input['id'])->delete();
            #删除AdminRoleNodeRoute
            $res2=AdminRoleNodeRoute::whereIn("admin_role_id",$input['id'])->delete();
            #删除AdminRole
            $res3=AdminRole::destroy($input['id']);
            return $res1 && $res2 && $res3;
        })){
            return redirect(\URL::action('Background\AdminRoleController@getList'))->withErrors("删除成功");
        }else{
            return back()->withErrors("删除失败");
        }
    }
    //endregion
}
