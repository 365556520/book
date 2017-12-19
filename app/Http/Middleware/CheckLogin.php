<?php

namespace App\Http\Middleware;


use Closure;


class CheckLogin
{
    public function handle($request,Closure $next)
    {
       $member = $request->session()->get('member','');
        if ($member == ''){
            return redirect('login');
        }
        return $next($request);
    }
}