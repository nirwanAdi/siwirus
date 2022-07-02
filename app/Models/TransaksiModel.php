<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi_preorder';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_pembeli', 'id_barang', 'id_metode_pembayaran', 'jumlah', 'harga', 'total_harga', 'status', 'gambar_bukti_pembayaran', 'kelas', 'nomor_hp', 'keterangan'];

    public function getMetodePembayaran($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
