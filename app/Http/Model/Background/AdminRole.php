<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'admin_role';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    //protected $fillable = [''];
    /**
     * 不能被批量赋值的属性,如果你想要让所有属性都是可批量赋值的，可以将 $guarded 属性设置为空数组
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 角色列表
     * @return mixed
     * @author Ruiec.Simba
     */
    public static function roleList(){
        return self::pluck('role_name','id');
    }
}
