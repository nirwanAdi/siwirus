<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $data['title'] = 'User Profile';
        return view('user/index',$data,[ 'config' => config('auth') ]);
    }

}
