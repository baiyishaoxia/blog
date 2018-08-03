<?php

namespace App\Http\Model\Admin\MobileApi;

use Illuminate\Database\Eloquent\Model;

class MobileOrderItem extends Model
{
    protected $table = 'mobile_order_item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
