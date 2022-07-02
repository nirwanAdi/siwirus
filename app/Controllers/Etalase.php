<?php

namespace App\Controllers;

use App\Models\BarangPreOrderModel;
use App\Models\MetodePembayaranModel;
use App\Models\TransaksiModel;

class Etalase extends BaseController
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
        $data = [
            'title' => 'Etalase',
            'barangPreorder' => $this->barangPreorderModel->getPreorder()
        ];
        return view('etalase/index', $data,);
    }

    public function beli($id)
    {
        $data = [
            'title' => 'Pembelian Barang',
            'validation' => \Config\Services::validation(),
            'barangPreorder' => $this->barangPreorderModel->getPreorder($id),
            'metodePembayaran' => $this->metodePembayaranModel->getMetodePembayaran()
        ];
        return view('etalase/beli', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'jumlah' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Jumlah barang harus diisi.',
                ]
            ],
            'nomor_hp' => [
                'rules' => "required|is_natural",
                'errors' => [
                    'required' => 'Nomor Hp harus diisi.',
                    'is_natural' => 'Nomor Hp tidak valid'
                ]
            ],
            'kelas' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Kelas harus diisi.',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput();
        }
        $this->transaksiModel->save([
            'id_pembeli' => user_id(),
            'id_barang' => $this->request->getVar('idBarang'),
            'id_metode_pembayaran' => $this->request->getVar('metode_pembayaran'),
            'jumlah' => $this->request->getVar('jumlah'),
            'total_harga' => $this->request->getVar('total_harga'),
            'nomor_hp' => $this->request->getVar('nomor_hp'),
            'kelas' => $this->request->getVar('kelas')
        ]);
        return redirect()->to('/etalase/index');
    }
    public function transaksi()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('transaksi_preorder');
        $this->builder->select('transaksi_preorder.id as transaksiid,id_pembeli,id_barang,id_metode_pembayaran,transaksi_preorder.jumlah as transaksi_jumlah,total_harga,transaksi_preorder.status as statustransaksi,gambar_bukti_pembayaran,nama_barang,harga,gambar_barang,nama_bank,no_rekening,username');
        $this->builder->join('barang_preorder', 'barang_preorder.id = transaksi_preorder.id_barang');
        $this->builder->join('metode_pembayaran', 'metode_pembayaran.id = transaksi_preorder.id_metode_pembayaran');
        $this->builder->join('users', 'users.id = transaksi_preorder.id_pembeli');
        $query = $this->builder->get();
        $data = [
            'title' => 'Transaksi',
            'validation' => \Config\Services::validation(),
            'transaksi_preorder' => $query->getResult()
        ];
        return view('etalase/transaksi', $data);
    }

    public function detail_transaksi($id)
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('transaksi_preorder');
        $this->builder->select('transaksi_preorder.id as transaksiid,id_pembeli,id_barang,id_metode_pembayaran,transaksi_preorder.jumlah as transaksi_jumlah,total_harga,transaksi_preorder.status as statustransaksi,gambar_bukti_pembayaran,nama_barang,harga,gambar_barang,nama_bank,no_rekening,nama_pemilik,username');
        $this->builder->join('barang_preorder', 'barang_preorder.id = transaksi_preorder.id_barang');
        $this->builder->join('metode_pembayaran', 'metode_pembayaran.id = transaksi_preorder.id_metode_pembayaran');
        $this->builder->join('users', 'users.id = transaksi_preorder.id_pembeli');
        $this->builder->where('transaksi_preorder.id', $id);
        $query = $this->builder->get();
        $data = [
            'title' => 'Transaksi Pre Order',
            'validation' => \Config\Services::validation(),
            'transaksi_preorder' => $query->getRow()
        ];
        return view('etalase/detail', $data,);
    }

    public function upload_bukti_pembayaran($id)
    {
        if (!$this->validate([
            'gambar_bukti_pembayaran' => [
                'rules' => 'uploaded[gambar_bukti_pembayaran]|is_image[gambar_bukti_pembayaran]|mime_in[gambar_bukti_pembayaran,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harap masukkan keterangan jika pembayaran dilakukan untuk banyak pemesanan, jika hanya satu maka tulisakn "-"'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput();
        }
        /* Ambil Gambar */

        $fileGambarBuktiPembayaran = $this->request->getFile('gambar_bukti_pembayaran');

        /* Generate nama file*/
        $namaGambar = $fileGambarBuktiPembayaran->getRandomName();

        /* Pindahkan ke folder */

        $fileGambarBuktiPembayaran->move('img/pre_order/bukti_pembayaran', $namaGambar);

        $this->transaksiModel->save([
            'id' => $id,
            'gambar_bukti_pembayaran' => $namaGambar,
            'status' => 1,
            'keterangan' => $this->request->getVar('keterangan')
        ]);
        return redirect()->to('/etalase/transaksi');
    }

    public function lanjutkan_pemesanan($id)
    {
        $this->transaksiModel->save([
            'id' => $id,
            'status' => 0
        ]);
        return redirect()->back();
    }

    public function delete($id)
    {
        /* cari gambar berdasarkan id */
        $transaksiPreorder = $this->transaksiModel->find($id);

        // hapus gambar
        unlink('img/pre_order/bukti_pembayaran/' . $transaksiPreorder['gambar_bukti_pembayaran']);

        $this->transaksiModel->delete($id);
        return redirect()->to('/etalase/transaksi');
    }
    public function hapus($id)
    {

        $this->transaksiModel->delete($id);
        return redirect()->to('/etalase/transaksi');
    }
}
