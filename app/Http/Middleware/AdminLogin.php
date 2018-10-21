<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Background\IpBlacklistsController;
use App\Http\Model\Admin;
use App\Http\Model\Background\AdminLog;
use Closure;

class AdminLogin
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
        //是否限制ip
        IpBlacklistsController::getIpAuth($request);
        //是否登录
        if (!\Session::has('admin_id')) {
           return redirect(\URL::action('Admin\LoginController@login'));
        }
        //是否锁定
        if(Admin::info()->is_lock){
            return redirect(\URL::action('Admin\LoginController@getLogin'))->withErrors("账户被锁定");
        }
        //权限验证
        if(Admin::adminAuth()==false){
            abort(500);
            return back()->withErrors("您没有权限访问");
        }
        //生成日志
        AdminLog::log();
        return $next($request);
    }
}
