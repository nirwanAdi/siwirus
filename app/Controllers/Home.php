<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('auth/login', ['config' => config('auth')]);
    }
    public function register()
    {
        return view('auth/register');
    }
    public function user()
    {
        if (in_groups('admin')) {
            return view('admin/index');
        } else {
            return view('user/index');
        }
    }
}
