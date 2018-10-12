<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class AdminNavigation extends Model
{
    protected $table = 'admin_navigation';
    protected $primaryKey='id';
    public $timestamps=true;
    protected $guarded = [];
}
