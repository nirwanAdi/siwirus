<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class DataProdukModel extends Model
{
    protected $table = 'barang_toko';
    protected $column_order = [null, 'kodeproduk', 'namaproduk', 'katnama', 'stok_tersedia', 'harga_jual', null];
    protected $column_search = ['kodeproduk', 'namaproduk'];
    protected $order = ['namaproduk' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    private function getDatatablesQuery($keywordkode)
    {
        if (strlen($keywordkode) == 0) {
            $this->dt = $this->db->table($this->table)->join('kategori', 'katid=produk_katid');
        } else {
            $this->dt = $this->db->table($this->table)->join('kategori', 'katid=produk_katid')->like('kodeproduk', $keywordkode)->orLike('namaproduk', $keywordkode);
        }
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables($keywordkode)
    {
        $this->getDatatablesQuery($keywordkode);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered($keywordkode)
    {
        $this->getDatatablesQuery($keywordkode);
        return $this->dt->countAllResults();
    }

    public function countAll($keywordkode)
    {
        if (strlen($keywordkode) === 0) {
            $tbl_storage = $this->db->table($this->table)->join('kategori', 'katid=produk_katid');
        } else {
            $tbl_storage = $this->db->table($this->table)->join('kategori', 'katid=produk_katid')->like('kodeproduk', $keywordkode)->orLike('namaproduk', $keywordkode);
        }
        return $tbl_storage->countAllResults();
    }
}
