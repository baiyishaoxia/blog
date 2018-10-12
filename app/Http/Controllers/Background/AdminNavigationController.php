<?php

namespace App\Http\Controllers\Background;

use App\Common\ArrayTools;
use App\Common\Tree;
use App\Http\Model\Background\AdminNavigation;
use App\Http\Model\Background\AdminNavigationNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminNavigationController extends Controller
{
    //region   列表        tang
    public function getList(){
        $tree=AdminNavigation::orderBy('sort')->get()->toArray();
        foreach ($tree as $key => $value){
            $tree[$key]['title']='<span class="folder-open"></span>'.$value['title'];
            $tree[$key]['child']=implode('，',AdminNavigationNode::where('admin_navigation_id',$value['id'])->orderBy('sort')->pluck('title')->toArray());
        }
        $tree=Tree::unlimitedForLevel($tree,'<span class="folder-line"></span>');
        return view('background.admin_navigation.list',compact('tree'));
    }
    //endregion

    //region   新增        tang
    public function getCreate($id=''){
        $tree=AdminNavigation::orderBy('sort','asc')->orderBy('id','asc')->get();
        $tree=Tree::unlimitedForLevel($tree->toArray(),'|--');
        $tree=Tree::array2ToArray1($tree,'id','title');
        $tree['']="无父级导航";
        $data['parent_id']=$id;
        return view('background.admin_navigation.create',compact('data','tree'));
    }
    public function postCreate(Request $request){
        $input=$request->all();
        $input['is_show']=isset($input['is_show'])?true:false;
        $input['is_sys']=isset($input['is_sys'])?true:false;
        if(\DB::transaction(function () use($input){
            if(isset($input['node'])) {
                $node = $input['node'];
                unset($input['node']);
            }
            unset($input['file']);
            $admin      =   AdminNavigation::create($input);
            if(isset($node)){
                $node=ArrayTools::arrayAddElement($node,'admin_navigation_id',$admin->id);
                $res=AdminNavigationNode::insert($node);
            }
            return $admin && isset($res)?:true;
        })){
            return redirect(\URL::action('Background\AdminNavigationController@getList'))->withErrors("添加成功");
        }else{
            return back()->withErrors("添加失败");
        }
    }
    //endregion

    //region   修改        tang
    public function getEdit($id){
        $data=AdminNavigation::find($id);
        $tree=AdminNavigation::where('id','<>',$data->id)->orderBy('sort')->get();
        $tree=Tree::unlimitedForLevel($tree->toArray(),'|--');
        $tree=Tree::array2ToArray1($tree,'id','title');
        $tree['']="无父级导航";
        $action_route=AdminNavigationNode::where("admin_navigation_id",$data->id)->orderBy('sort')->get()->toArray();
        return view('background.admin_navigation.edit',compact('tree','data','action_route'));
    }
    public function postEdit(Request $request){
        $input=$request->all();
        if(\DB::transaction(function () use($input){
            #更新AdminNavigation
            $admin_navigation=AdminNavigation::find($input['id']);
            $admin_navigation->parent_id    =$input['parent_id'];
            $admin_navigation->sort         =$input['sort'];
            $admin_navigation->is_show      =isset($input['is_show'])?true:false;
            $admin_navigation->is_sys       =isset($input['is_sys'])?true:false;
            $admin_navigation->title        =$input['title'];
            $admin_navigation->ico          =$input['ico'];
            $res1=$admin_navigation->save();
            #更新AdminNavigationNode
            $res2=true;
            if(isset($input['node'])) {
                foreach ($input['node'] as $key => $val){
                    if(isset($val['id'])){
                        $admin_navigation_node              =AdminNavigationNode::find($val['id']);
                        $admin_navigation_node->title       =$val['title'];
                        $admin_navigation_node->route_action=$val['route_action'];
                        $admin_navigation_node->parameter   =$val['parameter'];
                        $admin_navigation_node->sort        =$val['sort'];
                        $res2=$admin_navigation_node->save();
                    }else{
                        $val['admin_navigation_id']=$admin_navigation->id;
                        $res2=AdminNavigationNode::create($val);
                    }

                }
            }
            return $res1 && $res2;
        })){
            return redirect(\URL::action('Background\AdminNavigationController@getList'))->withErrors("修改成功");
        }else{
            return back()->withErrors("修改失败");
        }
    }
    //endregion

    //region   保存        tang
    public function postSave(Request $request){
        $input=$request->all();
        foreach ($input['data'] as $id => $data){
            $admin_navigation = AdminNavigation::find($id);
            $admin_navigation -> sort =$data['sort'];
            $admin_navigation -> save();
        }
        return back()->withSuccess("保存排序成功");
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        $input=$request->all();
        if(\DB::transaction(function () use($input){
            #删除AdminNavigationNode
            if (AdminNavigationNode::whereIn("admin_navigation_id",$input['id'])->count()>0) {
                $res1 = AdminNavigationNode::whereIn("admin_navigation_id", $input['id'])->delete();
            }
            else{
                $res1=true;
            }
            #删除AdminNavigation
            $res2=AdminNavigation::destroy($input['id']);
            return $res1 && $res2;
        })){
            return redirect(\URL::action('Background\AdminNavigationController@getList'))->withErrors("删除成功");
        }else{
            return back()->withErrors("删除失败");
        }
    }
    //endregion
}
