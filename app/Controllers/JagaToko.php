<?php

namespace App\Controllers;

class JagaToko extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Jadwal Jaga Toko'];
        return view('jagatoko/index', $data);
    }
}
