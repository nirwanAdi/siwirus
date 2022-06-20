<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;

class Produk extends BaseController
{
    protected $produkModel;
    protected $satuanModel;
    protected $kategoriModel;
    
    public function __construct()
    {
        $this->produkModel= new ProdukModel();
        $this->satuanModel = new SatuanModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index(){
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('barang_toko');
        $this->builder->select('kodeproduk,namaproduk,produk_satid,produk_katid,stok_tersedia,harga_beli,harga_jual,gambar_produk,satnama,katnama');
        $this->builder->join('satuan', 'satuan.satid = barang_toko.produk_satid');
        $this->builder->join('kategori', 'kategori.katid = barang_toko.produk_katid');
        $query = $this->builder->get();
        $data = [
            'title'=>'Management Produk',
            'barang_toko'=>$query->getResult()
    ];
        return view('toko/produk/index',$data,);
    }
    public function create(){
        $data = [
            'title'=>'Tambah Data Produk',
            'validation'=>\Config\Services::validation(),
            'kategori'=>$this->kategoriModel->findAll(),
            'satuan'=>$this->satuanModel->findAll()
        ];
        return view('toko/produk/create',$data);
    }

    public function save(){
        if(!$this->validate([
            'kodeproduk'=>[
                'rules'=>"required",
                'errors'=>[
                    'required'=> 'Kode Produk harus diisi.',
                ]
            ],
            'namaproduk'=>[
                'rules'=>"required",
                'errors'=>[
                    'required'=>'Nama produk harus diisi'
                ]
            ],
            'stok_tersedia'=>[
                'rules'=>"required|is_natural_no_zero",
                'errors'=>[
                    'required'=>'Stok harus diisi',
                    'is_natural_no_zero'=>'Stok harus berupa angka dan lebih besar dari nol'
                ]
            ],
            'harga_beli'=>[
                'rules'=>"required|is_natural_no_zero",
                'errors'=>[
                    'required'=>'Harga beli harus diisi',
                    'is_natural_no_zero'=>'Harga beli harus berupa angka dan lebih besar dari nol'
                ]
            ],
            'harga_jual'=>[
                'rules'=>"required|is_natural_no_zero",
                'errors'=>[
                    'required'=>'Harga jual harus diisi',
                    'is_natural_no_zero'=>'Harga jual harus berupa angka dan lebih besar dari nol'
                ]
            ],
            'gambar_produk'=>[
                'rules'=>'uploaded[gambar_produk]|is_image[gambar_produk]|mime_in[gambar_produk,image/png,image/jpg,image/jpeg]',
                'errors'=>[
                    'uploaded'=>'File belum di upload',
                    'is_image'=>'File yang dipilih bukan gambar',
                    'mime_in'=>'File yang dipilih bukan gambar'
                ]
            ],
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }

        $fileGambarProduk = $this->request->getFile('gambar_produk');
        
        /* Generate nama file*/
        $namaGambar = $fileGambarProduk->getRandomName();
        
        /* Pindahkan ke folder */
        
        $fileGambarProduk->move('img/toko/produk',$namaGambar);

        $this->produkModel->insert([
            'kodeproduk'=>$this->request->getVar('kodeproduk'),
            'namaproduk'=> $this->request->getVar('namaproduk'),
            'produk_satid'=>$this->request->getVar('satuan'),
            'produk_katid'=>$this->request->getVar('kategori'),
            'stok_tersedia'=>$this->request->getVar('stok_tersedia'),
            'harga_beli'=> $this->request->getVar('harga_beli'),
            'harga_jual'=>$this->request->getVar('harga_jual'),
            'gambar_produk'=>$namaGambar
        ]);
        return redirect()->to('produk/index');
    }

    public function edit($kodeproduk){
        $data = [
            'title'=>'Tambah Data Produk',
            'validation'=>\Config\Services::validation(),
            'kategori'=>$this->kategoriModel->findAll(),
            'satuan'=>$this->satuanModel->findAll(),
            'produk'=>$this->produkModel->where('kodeproduk',$kodeproduk)->first()
        ];
        return view('/toko/produk/edit',$data);
    }

    public function update($kodeproduk){
        if(!$this->validate([
            'kodeproduk'=>[
                'rules'=>"required",
                'errors'=>[
                    'required'=> 'Kode Produk harus diisi.',
                ]
            ],
            'namaproduk'=>[
                'rules'=>"required",
                'errors'=>[
                    'required'=>'Nama produk harus diisi'
                ]
            ],
            'stok_tersedia'=>[
                'rules'=>"required|is_natural_no_zero",
                'errors'=>[
                    'required'=>'Stok harus diisi',
                    'is_natural_no_zero'=>'Stok harus berupa angka dan lebih besar dari nol'
                ]
            ],
            'harga_beli'=>[
                'rules'=>"required|is_natural_no_zero",
                'errors'=>[
                    'required'=>'Harga beli harus diisi',
                    'is_natural_no_zero'=>'Harga beli harus berupa angka dan lebih besar dari nol'
                ]
            ],
            'harga_jual'=>[
                'rules'=>"required|is_natural_no_zero",
                'errors'=>[
                    'required'=>'Harga jual harus diisi',
                    'is_natural_no_zero'=>'Harga jual harus berupa angka dan lebih besar dari nol'
                ]
            ],
            'gambar_produk'=>[
                'rules'=>'is_image[gambar_produk]|mime_in[gambar_produk,image/png,image/jpg,image/jpeg]',
                'errors'=>[
                    'is_image'=>'File yang dipilih bukan gambar',
                    'mime_in'=>'File yang dipilih bukan gambar'
                ]
            ],
        ])){
            $validation =\Config\Services::validation();
            return redirect()->back()->withInput();
        }
        $fileGambarProduk = $this->request->getFile('gambar_produk');

        if($fileGambarProduk->getError()==4){
            $namaGambar = $this->request->getVar('gambarLama');
        }else{
            $namaGambar = $fileGambarProduk->getRandomName();
            $fileGambarProduk->move('img/toko/produk',$namaGambar);
            unlink('img/toko/produk/'. $this->request->getVar('gambarLama'));
        }

        
        $this->produkModel->update($kodeproduk,[
            'kodeproduk'=>$this->request->getVar('kodeproduk'),
            'namaproduk'=> $this->request->getVar('namaproduk'),
            'produk_satid'=>$this->request->getVar('satuan'),
            'produk_katid'=>$this->request->getVar('kategori'),
            'stok_tersedia'=>$this->request->getVar('stok_tersedia'),
            'harga_beli'=> $this->request->getVar('harga_beli'),
            'harga_jual'=>$this->request->getVar('harga_jual'),
            'gambar_produk'=>$namaGambar
        ]);
        return redirect()->to('produk/index');
    }

    public function delete($kodeproduk){
        /* cari gambar berdasarkan id */
        $barang_toko = $this->produkModel->find($kodeproduk);

        // hapus gambar
        unlink('img/toko/produk/' . $barang_toko['gambar_produk']);

        $this->produkModel->delete($kodeproduk);
        return redirect()->to('produk/index');
    }
}
