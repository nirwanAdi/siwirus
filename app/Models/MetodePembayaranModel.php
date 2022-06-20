<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodePembayaranModel extends Model
{
    protected $table = 'metode_pembayaran';
/*     protected $useTimestamps = true; */
    protected $allowedFields = ['nama_bank','no_rekening'];

    public function getMetodePembayaran($id=false){
        if($id==false){
            return $this->findAll();
        }

        return $this->where(['id'=>$id])->first();
    }
}