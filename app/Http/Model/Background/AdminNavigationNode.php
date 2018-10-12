<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class AdminNavigationNode extends Model
{
    protected $table = 'admin_navigation_node';
    protected $primaryKey='id';
    public $timestamps=true;
    protected $guarded = [];

    //region   递归查询上级的ID，权限分配使用         tang
    protected static $navigation=[];
    public static function getNavigation($data=[],$role_id){
        self::$navigation=[];
        foreach ($data as $key => $val){
            self::getParentId($val);
        }
        self::$navigation=array_unique(self::$navigation);//去重
        foreach (self::$navigation as $key => $val){
            self::$navigation[$key]=array();
            self::$navigation[$key]['admin_role_id']=$role_id;
            self::$navigation[$key]['admin_navigation_id']=$val;
        }
        return self::$navigation;
    }
    public static function getParentId($id){
        $this_node=AdminNavigation::find($id);
        if($this_node){
            self::$navigation[]=$this_node->toArray()['id'];
            self::getParentId($this_node['parent_id']);
        }else{
            return;
        }
    }
    //endregion
}
