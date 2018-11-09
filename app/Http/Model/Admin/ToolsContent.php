<?php

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsContent extends Model
{
    use SoftDeletes;
    protected $table = 'tools_content';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at']; //开启软删除


    //region   关联所属分类表        tang
    public function category()
    {
        return $this->belongsTo('App\Http\Model\Admin\ToolsList', 'list_id','id');
    }
    //endregion

    //region   关联内容附件表        tang
    public function attach()
    {
        return $this->hasMany('App\Http\Model\Admin\ToolsContentAttache','content_id');
    }
    //endregion
}
