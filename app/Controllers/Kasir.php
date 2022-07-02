<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\DataProdukModel;
use App\Models\JadwalJagaToko;
use Config\Services;

class Kasir extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kasir',
        ];
        return view('toko/kasir/index', $data);
    }
    public function input()
    {
        $model = new JadwalJagaToko();
        $jam = (string)date('G');
        $sesi = '4';

        if ($jam >= '7' && $jam < '10') {
            $sesi = '1';
        } elseif ($jam >= '10' && $jam < '13') {
            $sesi = '2';
        } elseif ($jam >= '13' && $jam < '16') {
            $sesi = '3';
        }

        $jadwal = $model->where('user_id', session('logged_in'))
                        ->where('hari', date('Y-m-d'))
                        ->where('sesi', $sesi)
                        ->get()->getResultArray();
        
        if (empty($jadwal)) {
            session()->setFlashdata('msg', '<script>Swal.fire({text: "Maaf, saat ini kamu tidak memiliki jadwal jaga toko!", icon: "error"})</script>');
            return redirect()->back();
        }
        
        $data = [
            'nofaktur' => $this->buatFaktur(),
            'title' => 'Input Kasir',
        ];
        return view('toko/kasir/input', $data);
    }

    public function buatFaktur()
    {
        $tgl = date('Y-m-d');
        $query = $this->db->query("SELECT MAX(jual_faktur) AS nofaktur FROM penjualan WHERE DATE_FORMAT(jual_tgl, '%Y-%m-%d') = '$tgl'");
        $hasil = $query->getRow();
        $data = $hasil->nofaktur;

        $lastNoUrut = substr($data, -4);
        $nextNoUrut = intval($lastNoUrut) + 1;

        $fakturPenjualan = 'J' . user_id() . date('dmy', strtotime($tgl)) . sprintf('%04s', $nextNoUrut);
        return $fakturPenjualan;
    }

    public function dataDetail()
    {
        $nofaktur = $this->request->getPost('nofaktur');

        $tempPenjualan = $this->db->table('temp_penjualan');
        $queryTampil = $tempPenjualan->select('detjual_id as id, detjual_kodeproduk as kode, namaproduk, detjual_hargajual as harga_jual, detjual_jml as qty, detJual_subtotal as subtotal')->join('barang_toko', 'detjual_kodeproduk=kodeproduk')->where('detjual_faktur', $nofaktur)->where('detjual_pengurus', user_id())->orderBy('detjual_id', 'asc');

        $data = [
            'datadetail' => $queryTampil->get()
        ];
        $msg = [
            'data' => view('toko/kasir/viewdetail', $data)
        ];
        echo json_encode($msg);
    }

    public function viewDataProduk()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword
            ];
            $msg = [
                'viewmodal' => view('toko/kasir/viewmodalcariproduk', $data)
            ];
            echo json_encode($msg);
        };
    }

    public function listDataProduk()
    {
        if ($this->request->isAJAX()) {
            $keywordkode = $this->request->getPost('keywordkode');
            $request = Services::request();
            $dataProdukModel = new DataProdukModel($request);
            if ($request->getMethod(true) === 'POST') {
                $lists = $dataProdukModel->getDatatables($keywordkode);
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->kodeproduk;
                    $row[] = $list->namaproduk;
                    $row[] = $list->katnama;
                    $row[] = $list->stok_tersedia;
                    $row[] = number_format($list->harga_jual, 2, ',', '.');
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"pilihitem('" . $list->kodeproduk . "','" . $list->namaproduk . "')\">Pilih</button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordTotals" => $dataProdukModel->countAll($keywordkode),
                    "data" => $data
                ];
                echo json_encode($output);
            }
        }
    }

    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            $kodeproduk = $this->request->getPost('kodeproduk');
            $namaproduk = $this->request->getPost('namaproduk');
            $jumlah = $this->request->getPost('jumlah');
            $nofaktur = $this->request->getPost('nofaktur');

            if (strlen($namaproduk) > 0) {
                $queryCekProduk = $this->db->table('barang_toko')->where('kodeproduk', $kodeproduk)->where('namaproduk', $namaproduk)->get();
            } else {
                $queryCekProduk = $this->db->table('barang_toko')->like('kodeproduk', $kodeproduk)->orLike('namaproduk', $kodeproduk)->get();
            }

            $totalData = $queryCekProduk->getNumRows();

            if ($totalData > 1) {
                $msg = [
                    'totaldata' => 'banyak'
                ];
            } else if ($totalData == 1) {
                $tblTempPenjualan = $this->db->table('temp_penjualan');
                $rowProduk = $queryCekProduk->getRowArray();

                $stokProduk = $rowProduk['stok_tersedia'];

                if (intval($stokProduk) == 0) {
                    $msg = [
                        'error' => 'Maaf,stok tidak tersedia'
                    ];
                } else if ($jumlah > intval($stokProduk)) {
                    $msg = [
                        'error' => 'Maaf,stok tidak mencukupi'
                    ];
                } else {
                    $inserData = [
                        'detjual_faktur' => $nofaktur,
                        'detjual_kodeproduk' => $rowProduk['kodeproduk'],
                        'detjual_hargabeli' => $rowProduk['harga_beli'],
                        'detjual_hargajual' => $rowProduk['harga_jual'],
                        'detjual_jml' => $jumlah,
                        'detjual_subtotal' => intval($rowProduk['harga_jual']) * $jumlah,
                        'detjual_pengurus' => user_id(),
                    ];
                    $tblTempPenjualan->insert($inserData);

                    $msg = ['sukses' => 'berhasil'];
                }
            } else {
                $msg = ['error' => 'Kode produk tidak ditemukan'];
            }

            echo json_encode($msg);
        }
    }

    public function hitungTotalBayar()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $tblTempPenjualan = $this->db->table('temp_penjualan');

            $queryTotal = $tblTempPenjualan->SELECT('SUM(detjual_subtotal) as totalbayar')->where('detjual_faktur', $nofaktur)->where('detjual_pengurus', user_id())->get();
            $rowTotal = $queryTotal->getRowArray();

            $msg = [
                'totalbayar' => number_format($rowTotal['totalbayar'], 0, ",", ".")
            ];

            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $tblTempPenjualan = $this->db->table('temp_penjualan');
            $queryHapus =  $tblTempPenjualan->delete(['detjual_id' => $id]);

            if ($queryHapus) {
                $msg = [
                    'sukses' => 'berhasil'
                ];

                echo json_encode($msg);
            }
        }
    }

    public function pembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $kopeng = $this->request->getPost('kopeng');

            $tblTempPenjualan = $this->db->table('temp_penjualan');
            $cekDataTempPenjualan = $tblTempPenjualan->getWhere(['detjual_faktur' => $nofaktur]);
            $queryTotal = $tblTempPenjualan->SELECT('SUM(detjual_subtotal) as totalbayar')->where('detjual_faktur', $nofaktur)->where('detjual_pengurus', user_id())->get();
            $rowTotal = $queryTotal->getRowArray();
            if ($cekDataTempPenjualan->getNumRows() > 0) {
                $data = [
                    'nofaktur' => $nofaktur,
                    'kopeng' => $kopeng,
                    'totalbayar' => $rowTotal['totalbayar']
                ];

                $msg = [
                    'data' => view('toko/kasir/modalpembayaran', $data)
                ];
            } else {
                $msg = [
                    'error' => 'Maaf, Anda belum memasukkan item'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function simpanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kopeng = $this->request->getPost('kopeng');
            $totalkotor = $this->request->getPost('totalkotor');
            $totalbersih = str_replace(",", "", $this->request->getPost('totalbersih'));
            $jmluang = str_replace(",", "", $this->request->getPost('jmluang'));
            $sisauang = str_replace(",", "", $this->request->getPost('sisauang'));

            $tblPenjualan = $this->db->table('penjualan');
            $tblTempPenjualan = $this->db->table('temp_penjualan');
            $tblDetailPenjualan = $this->db->table('penjualan_detail');

            $dataInsertPenjualan = [
                'jual_faktur' => $nofaktur,
                'jual_tgl' => date('Y-m-d H:i:s'),
                'jual_pengurus' => $kopeng,
                'jual_dispersen' => 0,
                'jual_disuang' => 0,
                'jual_totalkotor' => $totalkotor,
                'jual_totalbersih' => $totalbersih,
                'jual_jmluang' => $jmluang,
                'jual_sisauang' => $sisauang,
            ];
            $tblPenjualan->insert($dataInsertPenjualan);

            $ambilDataTemp = $tblTempPenjualan->getWhere(['detjual_faktur' => $nofaktur, 'detjual_pengurus' => $kopeng]);

            $fieldDetailPenjualan = [];
            foreach ($ambilDataTemp->getResultArray() as $row) {
                $fieldDetailPenjualan[] = [
                    'detjual_faktur' => $row['detjual_faktur'],
                    'detjual_kodeproduk' => $row['detjual_kodeproduk'],
                    'detjual_hargabeli' => $row['detjual_hargabeli'],
                    'detjual_hargajual' => $row['detjual_hargajual'],
                    'detjual_jml' => $row['detjual_jml'],
                    'detjual_subtotal' => $row['detjual_subtotal'],
                    'detjual_pengurus' => $row['detjual_pengurus'],
                ];
            }
            $tblDetailPenjualan->insertBatch($fieldDetailPenjualan);

            $tblTempPenjualan->delete(['detjual_faktur' => $nofaktur, 'detjual_pengurus' => $kopeng]);

            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }
}
