<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class User extends BaseController
{
    protected $absensiPengurusModel;

    public function __construct()
    {
        $this->absensiPengurusModel = new AbsensiModel();
        $this->db      = \Config\Database::connect();
    }

    public function index()
    {
        $this->tblAbsensi = $this->db->table('absensi_pengurus');
        $data['title'] = 'User Profile';
        return view('user/index', $data, ['config' => config('auth')]);
    }
}
