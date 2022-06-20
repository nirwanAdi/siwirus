<?php

namespace App\Controllers;

use App\Models\BarangPreOrderModel;

class PreOrder extends BaseController
{

    protected $barangPreorderModel;

    public function __construct()
    {
        $this->barangPreorderModel = new BarangPreOrderModel();
    }

    public function create()
    {   
        session();
        $data= ['title' => 'Tambah Data Barang',
                'validation'=>\Config\Services::validation()
        ];
        return view('preorder/create',$data,);
    }
    public function save(){

        // Validasi
        if(!$this->validate([
            'nama_barang'=>[
                'rules'=>'required|is_unique[barang_preorder.nama_barang]',
                'errors'=>[
                    'required'=> 'Nama barang harus diisi.',
                    'is_unique'=> 'Nama barang sudah ada.'
                ]
            ],
            'harga'=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Harga harus diisi.',
                    'numeric'=>'Isiian harus berupa angka.'
                ]
            ],
            'gambar_barang'=>[
                'rules'=>'uploaded[gambar_barang]|is_image[gambar_barang]|mime_in[gambar_barang,image/png,image/jpg,image/jpeg]',
                'errors'=>[
                    'uploaded'=>'Gambar harus diupload',
                    'is_image'=>'File yang dipilih bukan gambar',
                    'mime_in'=>'File yang dipilih bukan gambar'
                ]
            ],
        ])){
            $validation =\Config\Services::validation();
            return redirect()->to('/preorder/create')->withInput();
        }

        /* Ambil Gambar */

        $fileGambarBarang = $this->request->getFile('gambar_barang');
        
        /* Generate nama file*/
        $namaGambar = $fileGambarBarang->getRandomName();

        /* Pindahkan ke folder */

        $fileGambarBarang->move('img/pre_order/barang',$namaGambar);



        $this->barangPreorderModel->save([
            'nama_barang'=>$this->request->getVar('nama_barang'),
            'harga'=>$this->request->getVar('harga'),
            'gambar_barang'=>$namaGambar
        ]);

        return redirect()->to('/preorder/index');
    }

    public function index()
    {   
        $data = [
            'title'=>'List Barang Pre Order',
            'barangPreorder'=>$this->barangPreorderModel->getPreorder(),
    ];
        return view('preorder/index',$data,);
    }

    public function detail($id)
    {
        $data = [
            'title'=>'Detail Barang',
            'barangPreorder'=> $this->barangPreorderModel->getPreorder($id)
        ];
/*         if (empty($data['barangPerorder'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang Tidak Tersedia');
        } */
        return view('preorder/detail',$data);
    }

    public function delete($id){
        /* cari gambar berdasarkan id */
        $barangPreorder = $this->barangPreorderModel->find($id);

        // hapus gambar
        unlink('img/pre_order/barang/' . $barangPreorder['gambar_barang']);

        $this->barangPreorderModel->delete($id);
        return redirect()->to('preorder/index');
    }

    public function edit($id){
        session();
        $data= ['title' => 'Edit Data Barang',
                'validation'=>\Config\Services::validation(),
                'barangPreorder'=>$this->barangPreorderModel->getPreorder($id)
        ];
        return view('preorder/edit',$data,);
    }

    public function update($id){

        // $barangLama = $this->barangPreorderModel->getPreorder($this->request->getVar('id'));
        // if($barangLama['nama_barang']==$this->request->getVar('nama_barang')){
        //     $rule_nama_barang = 'required';
        // }
        // else{
        //     $rule_nama_barang = 'required|is_unique[barang_preorder.nama_barang]';
        // }
        if(!$this->validate([
            'nama_barang'=>[
                'rules'=>"required|is_unique[barang_preorder.nama_barang,id,$id]",
                'errors'=>[
                    'required'=> 'Nama barang harus diisi.',
                    'is_unique'=> 'Nama barang sudah ada.'
                ]
            ],
            'harga'=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Harga harus diisi.',
                    'numeric'=>'Isiian harus berupa angka.'
                ]
            ],
            'gambar_barang'=>[
                'rules'=>'is_image[gambar_barang]|mime_in[gambar_barang,image/png,image/jpg,image/jpeg]',
                'errors'=>[
                    'is_image'=>'File yang dipilih bukan gambar',
                    'mime_in'=>'File yang dipilih bukan gambar'
                ]
            ],
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $fileGambarBarang = $this->request->getFile('gambar_barang');

        if($fileGambarBarang->getError()==4){
            $namaGambar = $this->request->getVar('gambarLama');
        }else{
            $namaGambar = $fileGambarBarang->getRandomName();
            $fileGambarBarang->move('img/pre_order/barang',$namaGambar);
            unlink('img/pre_order/barang/'. $this->request->getVar('gambarLama'));
        }

        $this->barangPreorderModel->save([
            'id'=> $id,
            'nama_barang'=>$this->request->getVar('nama_barang'),
            'harga'=>$this->request->getVar('harga'),
            'gambar_barang'=>$namaGambar
        ]);

        return redirect()->to('/preorder/index');
    }

}
