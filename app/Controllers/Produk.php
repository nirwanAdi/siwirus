<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;
use CodeIgniter\Exceptions\AlertError;

class Produk extends BaseController
{

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->satuanModel = new SatuanModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $tombolCari = $this->request->getPost('tombolcariproduk');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('cariproduk');
            session()->set('cariproduk', $cari);
            redirect()->to('/produk/index');
        } else {
            $cari = session()->get('cariproduk');
        }

        $dataProduk = $cari ? $this->produkModel->cariData($cari) : $this->produkModel->join('kategori', 'katid=produk_katid')->join('satuan', 'satid=produk_satid');

        $noHalaman = $this->request->getVar('page_produk') ? $this->request->getVar('page_produk') : 1;
        $data = [
            'title' => 'Barang Toko',
            'dataproduk' => $this->produkModel->paginate(3, 'produk'),
            'pager' => $this->produkModel->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('/toko/produk/index', $data);
    }
    public function add()
    {
        $data = [
            'title' => 'Tambah Data Barang Toko'
        ];
        return view('toko/produk/formtambah', $data);
    }

    public function ambilDataKategori()
    {
        if ($this->request->isAJAX()) {
            $datakategori = $this->kategoriModel->findAll();

            $isidata = "<option value='' selected>-Pilih-</option>";

            foreach ($datakategori as $row) :
                $isidata .= '<option value="' . $row['katid'] . '">' . $row['katnama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

    public function ambilDataSatuan()
    {
        if ($this->request->isAJAX()) {
            $datakategori = $this->satuanModel->findAll();

            $isidata = "<option value='' selected>-Pilih-</option>";

            foreach ($datakategori as $row) :
                $isidata .= '<option value="' . $row['satid'] . '">' . $row['satnama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $produk = $this->produkModel->find('kode');
            if (!empty($produk['gambar_produk'])) {
                // hapus gambar
                unlink('img/toko/produk/' . $produk['gambar_produk']);
            }
            $kodeproduk = $this->request->getVar('kode');
            $this->produkModel->delete($kodeproduk);

            $msg = [
                'sukses' => 'Kategori berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }

    public function edit($kodeproduk)
    {
        $row = $this->produkModel->find($kodeproduk);
        if ($row) {
            $data = [
                'title' => 'Edit Data Barang',
                'kode' => $row['kodeproduk'],
                'nama' => $row['namaproduk'],
                'stok' => $row['stok_tersedia'],
                'harga_beli' => $row['harga_beli'],
                'harga_jual' => $row['harga_jual'],
                'kategoriproduk' => $row['produk_katid'],
                'datakategori' => $this->kategoriModel->findAll(),
                'satuanproduk' => $row['produk_satid'],
                'datasatuan' => $this->satuanModel->findAll(),
                'gambar' => $row['gambar_produk'],
            ];
            return view('/toko/produk/formedit', $data);
        } else {
            return redirect()->to('/toko/produk/index');
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kodeproduk = $this->request->getVar('kodeproduk');
            $namaproduk = $this->request->getVar('namaproduk');
            $stok = $this->request->getVar('stok');
            $kategori = $this->request->getVar('kategori');
            $satuan = $this->request->getVar('satuan');
            $hargabeli = str_replace(',', '', $this->request->getVar('hargabeli'));
            $hargajual = str_replace(',', '', $this->request->getVar('hargajual'));

            $validation =  \Config\Services::validation();

            $doValid = $this->validate([
                'kodeproduk' => [
                    'label' => 'Kode Produk',
                    'rules' => "is_unique[barang_toko.kodeproduk,kodeproduk,$kodeproduk]|required",
                    'errors' => [
                        'is_unique' => 'Kode Produk sudah ada, coba dengan kode yang lain',
                        'required' => 'Kode Produk tidak boleh kosong'
                    ]
                ],
                'namaproduk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Produk tidak boleh kosong'
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Tersedia',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Stok tidak boleh kosong'
                    ]
                ],
                'hargabeli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga beli tidak boleh Kosong',
                    ]
                ],
                'hargajual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga jual tidak boleh Kosong'
                    ]
                ],
                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]',
                    'errors' => [
                        'mime_in'  => 'File yang diupload bukan gambar',
                        'ext_in'  => 'File yang diupload bukan gambar',
                        'is_image'  => 'File yang diupload bukan gambar',
                    ]
                ]
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorKodeProduk' => $validation->getError('kodeproduk'),
                        'errorNamaProduk' => $validation->getError('namaproduk'),
                        'errorStok' => $validation->getError('stok'),
                        'errorKategori' => $validation->getError('kategori'),
                        'errorSatuan' => $validation->getError('satuan'),
                        'errorHargaBeli' => $validation->getError('hargabeli'),
                        'errorHargaJual' => $validation->getError('hargajual'),
                        'errorUpload' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {

                $fileUploadGambar = $_FILES['uploadgambar']['name'];

                $rowDataProduk = $this->produkModel->find($kodeproduk);

                if ($fileUploadGambar != NULL) {
                    unlink($rowDataProduk['gambar_produk']);
                    $namaFileGambar = "$kodeproduk-$namaproduk";
                    $fileGambar = $this->request->getFile('uploadgambar');
                    $fileGambar->move('img/toko/produk', $namaFileGambar . '.' . $fileGambar->getExtension());
                    $pathGambar = 'img/toko/produk/' . $fileGambar->getName();
                } else {
                    $pathGambar = $rowDataProduk['gambar_produk'];
                }
                $this->produkModel->update($kodeproduk, [
                    'kodeproduk' => $kodeproduk,
                    'namaproduk' => $namaproduk,
                    'produk_satid' => $satuan,
                    'produk_katid' => $kategori,
                    'stok_tersedia' => $stok,
                    'harga_beli' => $hargabeli,
                    'harga_jual' => $hargajual,
                    'gambar_produk' => $pathGambar
                ]);

                $msg = [
                    'sukses' => 'Data Produk Berhasil di Update'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kodeproduk = $this->request->getVar('kodeproduk');
            $namaproduk = $this->request->getVar('namaproduk');
            $stok = $this->request->getVar('stok');
            $kategori = $this->request->getVar('kategori');
            $satuan = $this->request->getVar('satuan');
            $hargabeli = str_replace(',', '', $this->request->getVar('hargabeli'));
            $hargajual = str_replace(',', '', $this->request->getVar('hargajual'));

            $validation =  \Config\Services::validation();

            $doValid = $this->validate([
                'kodeproduk' => [
                    'label' => 'Kode Produk',
                    'rules' => 'is_unique[barang_toko.kodeproduk]|required',
                    'errors' => [
                        'is_unique' => 'Kode Produk sudah ada, coba dengan kode yang lain',
                        'required' => 'Kode Produk tidak boleh kosong'
                    ]
                ],
                'namaproduk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Produk tidak boleh kosong'
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Tersedia',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Stok tidak boleh kosong'
                    ]
                ],
                'kategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori wajib dipilih'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan wajib dipilih'
                    ]
                ],
                'hargabeli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga beli tidak boleh Kosong',
                    ]
                ],
                'hargajual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga jual tidak boleh Kosong'
                    ]
                ],
                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'uploaded[uploadgambar]|mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]',
                    'errors' => [
                        'uploaded' => 'Gambar belum diupload',
                        'mime_in'  => 'File yang diupload bukan gambar',
                        'ext_in'  => 'File yang diupload bukan gambar',
                        'is_image'  => 'File yang diupload bukan gambar',
                    ]
                ]
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorKodeProduk' => $validation->getError('kodeproduk'),
                        'errorNamaProduk' => $validation->getError('namaproduk'),
                        'errorStok' => $validation->getError('stok'),
                        'errorKategori' => $validation->getError('kategori'),
                        'errorSatuan' => $validation->getError('satuan'),
                        'errorHargaBeli' => $validation->getError('hargabeli'),
                        'errorHargaJual' => $validation->getError('hargajual'),
                        'errorUpload' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {

                $namaFileGambar = "$kodeproduk-$namaproduk";
                $fileGambar = $this->request->getFile('uploadgambar');
                $fileGambar->move('img/toko/produk', $namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'img/toko/produk/' . $fileGambar->getName();

                $this->produkModel->insert([
                    'kodeproduk' => $kodeproduk,
                    'namaproduk' => $namaproduk,
                    'produk_satid' => $satuan,
                    'produk_katid' => $kategori,
                    'stok_tersedia' => $stok,
                    'harga_beli' => $hargabeli,
                    'harga_jual' => $hargajual,
                    'gambar_produk' => $pathGambar
                ]);

                $msg = [
                    'sukses' => 'Berhasil dieksekusi'
                ];
            }

            echo json_encode($msg);
        }
    }
}
