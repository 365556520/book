<?php

namespace App\Http\Middleware;


use Closure;


class CheckLogin
{
    public function handle($request,Closure $next)
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            //接来上一个连接存在就赋值
            $http_referer = $_SERVER['HTTP_REFERER'];
        }
       $member = $request->session()->get('member','');
        if ($member == ''){
            //urlencode给地址加密
            return redirect('login?return_url='.urlencode($http_referer));
        }
        return $next($request);
    }
}