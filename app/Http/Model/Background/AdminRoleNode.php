<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class AdminRoleNode extends Model
{
    protected $table = 'admin_role_node';
    protected $primaryKey='id';
    public $timestamps=true;
    protected $guarded = [];
}
