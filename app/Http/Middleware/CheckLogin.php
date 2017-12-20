<?php

namespace App\Http\Middleware;


use Closure;


class CheckLogin
{
    public function handle($request,Closure $next)
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            $http_referer = $_SERVER['HTTP_REFERER'];
        }
       $member = $request->session()->get('member','');
        if ($member == ''){
            return redirect('login?return_url='.urlencode($http_referer));
        }
        return $next($request);
    }
}