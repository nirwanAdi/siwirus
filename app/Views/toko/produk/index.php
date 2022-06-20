<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
<h3 class="h3 mb-4 text-gray-800">Management Data Produk</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="card-title ">
                <a href="/produk/create" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Data Produk</span>
                </a>
            </div>
        </div>
        <div class="card-body">
        <table class="table table-hover table-responsive">
                <thead>
                    <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($barang_toko)) : ?>
                    <tr>
                        <td colspan="4" class="text-center"><big>Data Kosong</big></td>
                    </tr>
                    <?php else : ?>
                    <?php $i=1; ?>
                    <?php foreach($barang_toko as $barang) : ?>
                    <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $barang->kodeproduk; ?></td>
                    <td><?= $barang->namaproduk; ?></td>
                    <td><?= $barang->satnama; ?></td>
                    <td><?= $barang->katnama; ?></td>
                    <td><?= $barang->stok_tersedia; ?></td>
                    <td><?= $barang->harga_beli; ?></td>
                    <td><?= $barang->harga_jual; ?></td>
                    <td class="text-center">
                        <a href="/produk/edit/<?= $barang->kodeproduk; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                        <form  action="/produk/<?= $barang->kodeproduk; ?>" method="post" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>