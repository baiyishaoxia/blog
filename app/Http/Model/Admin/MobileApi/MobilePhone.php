<?php

namespace App\Http\Model\Admin\MobileApi;

use Illuminate\Database\Eloquent\Model;

class MobilePhone extends Model
{
    protected $table = 'mobile_phone';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
