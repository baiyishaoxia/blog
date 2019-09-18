<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = [];
    protected $table = 'user';

    public static function info($user_id = '')
    {
        if ($user_id == '') {
            $user_id = \Session::get('userid');
        }
        $cache_time = \Carbon\Carbon::now()->addMinutes(10);
        $config=\Cache::remember("user:info:".$user_id,$cache_time,function ()use($user_id){
            return self::where('id',$user_id)->lockForUpdate()->first();
        });
        return $config;
    }
}
