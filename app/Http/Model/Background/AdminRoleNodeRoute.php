<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class AdminRoleNodeRoute extends Model
{
    protected $table = 'admin_role_node_routes';
    protected $primaryKey='id';
    public $timestamps=true;
    protected $guarded = [];
}
