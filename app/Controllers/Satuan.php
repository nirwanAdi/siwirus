<?php

namespace App\Controllers;

use App\Models\SatuanModel;

class Satuan extends BaseController
{
    protected $satuanModel;
    public function __construct()
    {
        $this->satuanModel = new SatuanModel();
    }

    public function index()
    {

        $tombolCari = $this->request->getPost('tombolsatuan');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('carisatuan');
            session()->set('carisatuan', $cari);
            redirect()->to('/satuan/index');
        } else {
            $cari = session()->get('carisatuan');
        }

        $dataSatuan = $cari ? $this->satuanModel->cariData($cari) : $this->satuanModel;

        $noHalaman = $this->request->getVar('page_satuan') ? $this->request->getVar('page_satuan') : 1;
        $data = [
            'title' => 'Satuan Produk Toko',
            'datasatuan' => $this->satuanModel->paginate(3, 'satuan'),
            'pager' => $this->satuanModel->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('toko/satuan/index', $data);
    }

    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('toko/satuan/modalformtambah')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $namasatuan = $this->request->getVar('namasatuan');

            $this->satuanModel->save([
                'satnama' => $namasatuan
            ]);

            $msg = [
                'sukses' => 'Kategori berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $idSatuan = $this->request->getVar('idsatuan');

            $this->satuanModel->delete($idSatuan);

            $msg = [
                'sukses' => 'Kategori berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }

    function formEdit()
    {
        if ($this->request->isAJAX()) {
            $idSatuan =  $this->request->getVar('idsatuan');

            $ambildatasatuan = $this->satuanModel->find($idSatuan);
            $data = [
                'idsatuan' => $idSatuan,
                'namasatuan' => $ambildatasatuan['satnama']
            ];

            $msg = [
                'data' => view('toko/satuan/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }

    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idSatuan = $this->request->getVar('idsatuan');
            $namaSatuan = $this->request->getVar('namasatuan');

            $this->satuanModel->save([
                'satid' => $idSatuan,
                'satnama' => $namaSatuan
            ]);

            $msg = [
                'sukses' =>  'Data satuan berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }
}
