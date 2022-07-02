<?php

namespace App\Controllers;

use App\Models\MetodePembayaranModel;

class MetodePembayaran extends BaseController
{
    protected $metodePembayaranModel;

    public function __construct()
    {
        $this->metodePembayaranModel = new MetodePembayaranModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Metode Pembayaran',
            'metodePembayaran' => $this->metodePembayaranModel->getMetodePembayaran(),
        ];
        return view('preorder/metode-pembayaran/index', $data,);
    }
    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Data Metode Pembayaran',
            'validation' => \Config\Services::validation()
        ];
        return view('preorder/metode-pembayaran/create', $data);
    }
    public function save()
    {

        // Validasi
        if (!$this->validate([
            'nama_bank' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama bank harus diisi.',
                ]
            ],
            'no_rekening' => [
                'rules' => 'required|is_natural|is_unique[metode_pembayaran.no_rekening]',
                'errors' => [
                    'required' => 'Nomor Rekening harus diisi.',
                    'is_natural' => 'Isiian harus berupa angka.',
                    'is_unique' => 'Nomor rekening sudah terdaftar'
                ]
            ],
            'nama_pemilik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pemilik rekenig harus diisi.',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $this->metodePembayaranModel->save([
            'nama_bank' => $this->request->getVar('nama_bank'),
            'no_rekening' => $this->request->getVar('no_rekening'),
            'nama_pemilik' => $this->request->getVar('nama_pemilik')
        ]);

        return redirect()->to('/preorder/metode-pembayaran/index');
    }

    public function delete($id)
    {
        $this->metodePembayaranModel->delete($id);
        return redirect()->to('/preorder/metode-pembayaran/index');
    }

    public function edit($id)
    {
        session();
        $data = [
            'title' => 'Edit Data Metode Pembayaran',
            'validation' => \Config\Services::validation(),
            'metodePembayaran' => $this->metodePembayaranModel->getMetodePembayaran($id)
        ];
        return view('preorder/metode-pembayaran/edit', $data,);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_bank' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Nama barang harus diisi.',
                ]
            ],
            'no_rekening' => [
                'rules' => "required|is_natural|is_unique[metode_pembayaran.no_rekening,id,$id]",
                'errors' => [
                    'required' => 'Nomor Rekening harus diisi.',
                    'is_natural' => 'Isiian harus berupa angka.',
                    'is_unique' => 'Nomor rekening sudah terdaftar'
                ]
            ],
            'nama_pemilik' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Nomor Rekening harus diisi.',

                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput();
        }
        $this->metodePembayaranModel->save([
            'id' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'no_rekening' => $this->request->getVar('no_rekening'),
            'nama_pemilik' => $this->request->getVar('nama_pemilik')
        ]);
        return redirect()->to('/preorder/metode-pembayaran/index');
    }
}
