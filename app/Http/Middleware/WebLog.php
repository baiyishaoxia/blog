<?php

namespace App\Http\Middleware;

use Closure;

class WebLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(array_key_exists('HTTP_X_REAL_IP',$_SERVER)){
            $ip= $_SERVER['HTTP_X_REAL_IP'] ;
        }else{
            $ip=$request->getClientIp();
        }
        $log=[
            'host'      =>$request->getHost(),
            'url'       =>$request->path(),
            'type'      =>$request->method(),
            'request'   =>json_encode($request->all()),
            'ip'        =>$ip,
        ];
        $dir = iconv("UTF-8", "GBK", "./storage/logs/".date('Ymd')."/");
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        $myfile = fopen($dir.date("YmdH").".log", "a");
        fwrite($myfile, json_encode($log));
        fclose($myfile);
        return $next($request);
    }
}
