<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemBerController extends Controller
{
    public function login(Request $request)
    {  $return_url = $request->input('return_url','');
        return view('login')->with('return_url',urldecode($return_url));
    }

    public function register()
    {
        return view('register');
    }
}