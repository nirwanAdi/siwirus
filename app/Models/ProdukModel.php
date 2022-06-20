<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table      = 'barang_toko';
    protected $primaryKey = 'kodeproduk';

    protected $allowedFields = ['kodeproduk','namaproduk','produk_satid','produk_katid','stok_tersedia','harga_beli','harga_jual','gambar_produk'];
}