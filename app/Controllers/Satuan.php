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

    public function index(){

        $noHalaman = $this->request->getVar('page_satuan') ? $this->request->getVar('page_satuan') : 1;
        $data = [
            'title'=>'Satuan Produk Toko',
            'satuanModel'=>$this->satuanModel->paginate('2','satuan'),
            'pager'=>$this->satuanModel->pager,
            'nohalaman'=>$noHalaman,
            'validation'=>\Config\Services::validation(),
        ];
        return view('toko/satuan/index',$data);
    }

    public function save(){
        if(!$this->validate([
            'satnama'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=> 'Nama satuan harus diisi.',
                ]
            ]
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $this->satuanModel->save([
            'satnama'=>$this->request->getVar('satnama'),
        ]);

        return redirect()->to('/satuan/index');
    }

    public function delete($satid){
        $this->satuanModel->delete($satid);
        return redirect()->to('/satuan/index');
    }

    public function update($satid){
        if(!$this->validate([
            'satnama'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=> 'Nama satuan harus diisi.',
                ]
            ]
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $this->satuanModel->save([
            'satid'=>$this->request->getVar('satid'),
            'satnama'=>$this->request->getVar('satnama'),
        ]);

        return redirect()->to('/satuan/index');
    }
}