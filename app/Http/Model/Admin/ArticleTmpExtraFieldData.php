<?php

namespace App\Http\Model\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ArticleTmpExtraFieldData extends Model
{
    protected $table = 'article_tmp_extra_field_data';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];

    //关联用户表
    public function tmp_and_user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    //关联字段表
    public function tmp_and_field()
    {
        return $this->belongsTo(ArticleTmpExtraField::class,'article_tmp_extra_field_id','id');
    }
    //关联活动表
    public function tmp_and_article()
    {
        return $this->belongsTo(ArticleTmp::class,'article_tmp_id','id');
    }

    //region   参与活动填写信息        tang
    public static function UserToActivity($data,$user_id,$model)
    {
        $fields = [];
        if(isset($data['extra_field'])){
            //查询之前提交的字段数据
            $ids = self::where('article_tmp_id',$model->id)->where('user_id',$user_id)->pluck('id')->toArray();
            if(count($ids) > 0){
                //删除所有字段数据
                $res = self::whereIn('id',$ids)->delete();
                if(!$res){
                    \DB::rollBack();
                    return array('status' => 0, 'info' => '删除所有字段数据失败');
                }
            }
            foreach ($data['extra_field'] as $key=>$val){
                $fields[$key]['user_id'] = $user_id;
                $fields[$key]['article_tmp_id'] = $model->id;
                $fields[$key]['article_tmp_extra_field_id'] = $val['id'];
                if(isset($val['value'])){
                    if(is_array($val['value'])){
                        //判断值是否是数组,是数组则表示是多选
                        $fields[$key]['value'] = json_encode($val['value']);
                    }else{
                        $fields[$key]['value'] = $val['value'];
                    }
                }else{
                    $fields[$key]['value'] = "";
                }
            }
        }
        return $fields;
    }
    //endregion
}
