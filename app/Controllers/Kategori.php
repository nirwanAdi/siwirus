<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategori;
    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    public function index(){
        $tombol_cari = $this->request->getPost('tombol_kategori');
        if(isset($tombol_cari)){
            $cari = $this->request->getPost('cari_kategori');
            session()->set('cari_kategori',$cari);
            redirect()->to('/kategori/index');
        }
        else{
            $cari = session()->get('cari_kategori');
        }

        $dataKategori = $cari ? $this->kategori->cariData($cari) : $this->kategori;
        $noHalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        $data = [
            'title'=>'Kategori Produk Toko',
            'kategori'=>$dataKategori->paginate('2','kategori'),
            'pager'=>$this->kategori->pager,
            'nohalaman'=>$noHalaman,
            'validation'=>\Config\Services::validation(),
        ];
        return view('toko/kategori/data',$data);
    }

    public function save(){
        if(!$this->validate([
            'katnama'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=> 'Nama kategori harus diisi.',
                ]
            ]
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $this->kategori->save([
            'katnama'=>$this->request->getVar('katnama'),
        ]);

        return redirect()->to('/kategori/index');
    }

    public function delete($katid){
        $this->kategori->delete($katid);
        return redirect()->to('/kategori/index');
    }

    public function update($katid){
        if(!$this->validate([
            'katnama'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=> 'Nama kategori harus diisi.',
                ]
            ]
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $this->kategori->save([
            'katid'=>$this->request->getVar('katid'),
            'katnama'=>$this->request->getVar('katnama'),
        ]);

        return redirect()->to('/kategori/index');
    }
}