<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //关联表
    protected $table='admin';
    //主键
    protected $primaryKey='user_id';
    //关闭创建更新时间
    public $timestamps=false;
}
