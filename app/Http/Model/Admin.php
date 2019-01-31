<?php

namespace App\Http\Model;

use App\Http\Model\Background\AdminNavigationNode;
use App\Http\Model\Background\AdminRoleNodeRoute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //关联表
    protected $table='admin';
    //主键
    protected $primaryKey='id';
    //关闭创建更新时间
    public $timestamps=true;
    //受保护的字段
    protected $guarded = [];

    //获取管理员角色
    public function role()
    {
        return $this->belongsTo('App\Http\Model\Background\AdminRole','admin_role_id','id');
    }

    /**
     * 定义修改器,对密码进行解密
     * @param $value
     * @return string
     */
    public function getPasswordAttribute($value)
    {
        return \Crypt::decrypt($value);
    }

    /**
     * 定义修改器,对密码进行加密
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Crypt::encrypt($value);
    }

    //region   根据用户的ID值返回管理员的相关数据，加有缓存机智        tang
    public static function info($id=''){
        $id=($id=='')?\Session::get('admin_id'):$id;
        $minutes=Carbon::now()->addMinute(10);
        $value = \Cache::remember('admin:'.$id,$minutes, function() use($id){
            return Admin::find($id);
        });
        return $value;
    }
    //endregion


    /**
     * 权限节点判别,超级管理员拥有所有权限，系统管理员根据分配的权限进行判别
     * @return bool
     */
    public static function adminAuth(){
        $admin_info=self::info();
        if($admin_info->role->is_super){
            //超级管理员
            return true;
        }else{
            //系统管理员
            $now_route=str_replace('App\\Http\\Controllers\\','',\Route::currentRouteAction());
            //判断权限
            $route_id=AdminNavigationNode::where('route_action',$now_route)->get();
            //判断权限方法是否存在
            if(count($route_id) == 0){
               return false;
            }
            //地址栏路由
            $now_url    ='/'.\Request::path();
            foreach ($route_id as $key => $val){
                if($val->parameter==null){
                    $route_id=$val;
                    break;
                }else{
                    $this_url   =\URL::action($now_route,json_decode($val->parameter,true),false);
                    if($this_url==$now_url){
                        $route_id=$val;
                    }
                    if(strstr($now_url,$this_url)){
                        $route_id=$val;
                        break;
                    }
                }
            }
            if (!isset($route_id->id)){
                return false;
            }
            $r1=AdminRoleNodeRoute::where("admin_navigation_node_id",$route_id->id)->first();
            if($r1!=null){
                return true;
            }else{
                return false;
            }
        }
    }

}
