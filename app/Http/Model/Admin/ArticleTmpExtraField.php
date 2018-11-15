<?php

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class ArticleTmpExtraField extends Model
{
    protected $table = 'article_tmp_extra_field';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];

    //region   获取字段        tang
    public static function getArticleTmpExtraField($tmp_id){
        $list = self::orderBy('id','asc')->where('article_tmp_id',$tmp_id)->get();
        return $list;
    }
    //endregion
}
