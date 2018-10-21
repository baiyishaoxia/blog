<?php

namespace App\Http\Model\Background;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmailKey extends Model
{
    protected $table = 'email_key';
    protected $guarded = [];
    public $timestamps = true;

    //region   读取key        tang
    public static function read($name){
        $minutes=Carbon::now()->addMinute(10);
        $value = \Cache::remember('email:'.$name,$minutes, function() use($name){
            return self::where('name',$name)->value('key');
        });
        return $value;
    }
    //endregion
}
