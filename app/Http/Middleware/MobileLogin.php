<?php

namespace App\Http\Middleware;

use Closure;

class MobileLogin
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
        //上一页的地址
        //$http_referer = $_SERVER['HTTP_REFERER'];
        //$http_referer = \URL::action('Admin\MobileApi\CartController@getCart');
        $member = $request->session()->get('member','');
        if(!$member){
            //urlencode此函数便于将字符串编码并将其用于 URL 的请求部分，同时它还便于将变量传递给下一页
            //return redirect(\URL::action('Admin\MobileApi\MemberController@login').'?return_url='.urlencode($http_referer));
            return redirect(\URL::action('Admin\MobileApi\MemberController@login'));
        }
        return $next($request);
    }
}
