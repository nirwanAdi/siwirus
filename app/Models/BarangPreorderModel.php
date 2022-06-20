<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangPreOrderModel extends Model
{
    protected $table = 'barang_preorder';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_barang','harga','gambar_barang'];

    public function getPreorder($id=false){
        if($id==false){
            return $this->findAll();
        }

        return $this->where(['id'=>$id])->first();
    }
}