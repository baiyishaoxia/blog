<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
   protected $table = 'links';
   protected $primaryKey = 'link_id';
   public $timestamps = false;
   protected $guarded = [];

    //回收站
    public static function getLinksRecyList()
    {
       return self::where('link_isdel',1)->paginate(10);
    }
    //还原
    public static function restore($link_id)
    {
        $link = Links::find($link_id);
        $link->link_isdel = 0;
        return $link->update();
    }
    //真正删除
    public static function del($link_id)
    {
        $re = self::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'  =>'恭喜,彻底删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'  =>'抱歉,彻底删除失败,请稍后重试!',
            ];
        }
        return $data;
    }
    //批量逻辑删除
    public static function delLogicAll($link_id)
    {
        return self::whereIn('link_id',$link_id)->update(['link_isdel'=>1]);
    }
    //批量还原
    public static function restoreAll($link_id)
    {
        return self::whereIn('link_id',$link_id)->update(['link_isdel'=>0]);
    }
}
