<?php

namespace App\Http\Model\Admin\MobileApi;

use Illuminate\Database\Eloquent\Model;

class MobileMember extends Model
{
    protected $table = 'mobile_member';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
}
