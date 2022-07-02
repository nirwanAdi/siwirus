<?php

namespace App\Controllers;

use App\Models\BarangPreOrderModel;
use App\Models\MetodePembayaranModel;
use App\Models\TransaksiModel;

class TransaksiPreOrder extends BaseController
{
    protected $barangPreorderModel;
    protected $metodePembayaranModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->barangPreorderModel = new BarangPreorderModel();
        $this->metodePembayaranModel = new MetodePembayaranModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('transaksi_preorder');
        $this->builder->select('transaksi_preorder.id as transaksiid,id_pembeli,id_barang,id_metode_pembayaran,transaksi_preorder.jumlah as transaksi_jumlah,total_harga,transaksi_preorder.status as statustransaksi,nama_barang,harga,gambar_barang,nama_bank,no_rekening,username');
        $this->builder->join('barang_preorder', 'barang_preorder.id = transaksi_preorder.id_barang');
        $this->builder->join('metode_pembayaran', 'metode_pembayaran.id = transaksi_preorder.id_metode_pembayaran');
        $this->builder->join('users', 'users.id = transaksi_preorder.id_pembeli');
        $this->builder->orderBy('statustransaksi', 'ASC');
        $query = $this->builder->get();
        $data = [
            'title' => 'Transaksi Pre Order',
            'transaksi_preorder' => $query->getResult()
        ];
        return view('preorder/transaksi-pre-order/index', $data,);
    }

    public function detail($id)
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('transaksi_preorder');
        $this->builder->select('transaksi_preorder.id as transaksiid,id_pembeli,id_barang,id_metode_pembayaran,transaksi_preorder.jumlah as transaksi_jumlah,total_harga,transaksi_preorder.status as statustransaksi,gambar_bukti_pembayaran,nama_barang,harga,gambar_barang,nama_bank,no_rekening,username,keterangan,kelas,nomor_hp,nama_pemilik');
        $this->builder->join('barang_preorder', 'barang_preorder.id = transaksi_preorder.id_barang');
        $this->builder->join('metode_pembayaran', 'metode_pembayaran.id = transaksi_preorder.id_metode_pembayaran');
        $this->builder->join('users', 'users.id = transaksi_preorder.id_pembeli');
        $this->builder->where('transaksi_preorder.id', $id);
        $query = $this->builder->get();
        $data = [
            'title' => 'Transaksi Pre Order',
            'transaksi_preorder' => $query->getRow()
        ];
        return view('preorder/transaksi-pre-order/detail', $data,);
    }

    public function konfirmasi($id)
    {
        $this->transaksiModel->save([
            'id' => $id,
            'status' => 2
        ]);
        $transaksi = $this->transaksiModel->where('id', $id)->get()->getResultArray()[0];
        $barang = $this->barangPreorderModel->where('id', $transaksi['id_barang'])->get()->getResultArray()[0];
        $this->barangPreorderModel->update($barang['id'], ['jumlah' => ((int)$barang['jumlah'] + (int)$transaksi['jumlah'])]);
        return redirect()->back();
    }
    public function tolak($id)
    {
        $this->transaksiModel->save([
            'id' => $id,
            'status' => 3
        ]);
        return redirect()->back();
    }
    public function delete($id)
    {
        /* cari gambar berdasarkan id */
        $transaksiPreorder = $this->transaksiModel->find($id);

        // ngecek gambar
        if (!empty($transaksiPreorder['gambar_bukti_pembayaran'])) {
            // hapus gambar
            unlink('img/pre_order/bukti_pembayaran/' . $transaksiPreorder['gambar_bukti_pembayaran']);
        }

        $this->transaksiModel->delete($id);
        return redirect()->back();
    }
}
