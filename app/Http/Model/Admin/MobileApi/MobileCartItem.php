<?php

namespace App\Http\Model\Admin\MobileApi;

use Illuminate\Database\Eloquent\Model;

class MobileCartItem extends Model
{
    protected $table = 'mobile_cart_item';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
}
