<?php

namespace App\Http\Model\Admin\MobileApi;

use Illuminate\Database\Eloquent\Model;

class MobileEmail extends Model
{
    protected $table = 'mobile_email';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
