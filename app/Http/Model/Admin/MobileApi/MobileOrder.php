<?php

namespace App\Http\Model\Admin\MobileApi;

use Illuminate\Database\Eloquent\Model;

class MobileOrder extends Model
{
    protected $table = 'mobile_order';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
}
