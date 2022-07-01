<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table      = 'absensi_pengurus';
    protected $primaryKey = 'id_absensi';

    protected $allowedFields = ['waktu_datang', 'waktu_pulang', 'user_id', 'kegiatan', 'status'];
}
