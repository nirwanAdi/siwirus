<?php

use App\Controllers\PreOrder;
?>
<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Metode Pembayaran</h1>
    <div class="row">
        <div class="col-lg-8">
        <a href="<?= base_url('preorder/metode-pembayaran/create'); ?>" class="btn btn-primary mb-3">Tambah Data</a>
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Nama Bank</th>
                    <th scope="col">Nomor Rekening</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($metodePembayaran)) : ?>
                    <tr>
                        <td colspan="4" class="text-center"><big>Data Kosong</big></td>
                    </tr>
                    <?php else : ?>
                    <?php $i=1; ?>
                    <?php foreach($metodePembayaran as $pembayaran) : ?>
                    <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $pembayaran['nama_bank']; ?></td>
                    <td><?= $pembayaran['no_rekening']; ?></td>
                    <td class="text-center">
                        <a href="/preorder/metode-pembayaran/edit/<?= $pembayaran['id']; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                        <form action="/metodepembayaran/<?= $pembayaran['id']; ?>" method="post" class="d-inline">
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