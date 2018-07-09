<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $table='article';
    protected $primaryKey='art_id';
    public $timestamps = true;
    protected $guarded=[]; //保护字段

    protected $dates = ['deleted_at'];



    //region   获取分类信息        tang
    public function category(){
        return $this->belongsTo(Category::class, 'cate_id');
    }
    //endregion
}
