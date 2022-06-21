<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }
    public function index()
    {
        $tombolCari = $this->request->getPost('tombolkategori');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('carikategori');
            session()->set('carikategori', $cari);
            redirect()->to('/kategori/index');
        } else {
            $cari = session()->get('carikategori');
        }

        $dataKategori = $cari ? $this->kategori->cariData($cari) : $this->kategori;

        $noHalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        $data = [
            'title'=> 'Kategori Produk Toko',
            'datakategori' => $this->kategori->paginate(3,'kategori'),
            'pager' => $this->kategori->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('toko/kategori/data', $data);
    }
    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('toko/kategori/modalformtambah')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $namakategori = $this->request->getVar('namakategori');

            $this->kategori->save([
                'katnama' => $namakategori
            ]);

            $msg = [
                'sukses' => 'Kategori berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }

    function hapus(){
        if ($this->request->isAJAX()) {
            $idKategori = $this->request->getVar('idkategori');

            $this->kategori->delete($idKategori);

            $msg = [
                'sukses' => 'Kategori berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }

    function formEdit()
    {
        if ($this->request->isAJAX()) {
            $idKategori =  $this->request->getVar('idkategori');

            $ambildatakategori = $this->kategori->find($idKategori);
            $data = [
                'idkategori' => $idKategori,
                'namakategori' => $ambildatakategori['katnama']
            ];

            $msg = [
                'data' => view('toko/kategori/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }

    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idKategori = $this->request->getVar('idkategori');
            $namaKategori = $this->request->getVar('namakategori');

            $this->kategori->update($idKategori, [
                'katnama' => $namaKategori
            ]);

            $msg = [
                'sukses' =>  'Data kategori berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }
}