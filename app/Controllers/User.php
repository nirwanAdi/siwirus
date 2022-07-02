<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\PengurusModel;
use Exception;

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
        $data['absensi'] = $this->absensiPengurusModel->where('user_id', session('logged_in'))
                                ->like('waktu_datang', date('Y-m-d'))
                                ->get()->getResultArray()[0] ?? [];
        $data['title'] = 'User Profile';
        return view('user/index', $data, ['config' => config('auth')]);
    }

    public function absen($type="datang", $daftarKegiatan="") {
        $absen = $this->absensiPengurusModel->where('user_id', session('logged_in'))
                            ->like('waktu_datang', date('Y-m-d'))
                            ->get()->getResultArray();
        
        if ($type == "datang") {
            try {
                if (empty($absen)) {
                    $this->absensiPengurusModel->insert([
                        'waktu_datang' => date('Y-m-d H:i:s'),
                        'waktu_pulang' => NULL,
                        'user_id' => session('logged_in'),
                        'kegiatan' => '',
                        'status' => 0,
                    ]);

                    return "berhasil";
                } else {
                    return "gagal";
                }
            } catch (Exception $e) {
                return "gagal";
            }
        } else {
            try {
                if (!empty($absen) && empty($absen->waktu_pulang)) {
                    $this->absensiPengurusModel->where('user_id', session('logged_in'))
                        ->like('waktu_datang', date('Y-m-d'))
                        ->set([
                            'waktu_pulang' => date('Y-m-d H:i:s'),
                            'kegiatan' => $daftarKegiatan,
                            'status' => 1,
                        ])->update();
                    
                    try {
                        $model = new PengurusModel();
                        $poin = (int)$model->where('id_user', session('logged_in'))
                                        ->get()->getResultArray()[0]['poin'] ?? 0;
                        $model->where('id_user', session('logged_in'))
                            ->set(['poin' => $poin+1])
                            ->update();
                    } catch (Exception $e) {
                        
                    }

                    return "berhasil";
                } else {
                    return "gagal";
                }
            } catch (Exception $e) {
                return "gagal";
            }
        }
    }
}
