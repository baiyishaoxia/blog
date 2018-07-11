<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, CanResetPassword;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = true;
    // 这个参数是关于软删除的，如果你有软删除需要，那么你可以加上
    // use SoftDeletes;
}


