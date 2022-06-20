<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
<div class="card mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
        <div class="col-md-4">
        <img src="<?= base_url('/img/pre_order/barang/'.$barangPreorder['gambar_barang']); ?>" class="card-img" alt="...">
        </div>
        <div class="col-md-8">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h5 class="card-title"><?= $barangPreorder['nama_barang']; ?></h5>
                </li>
                <li class="list-group-item">
                    <p class="card-text">Harga : Rp.  <?= number_format($barangPreorder['harga'],2,',','.'); ?></p>
                </li>
                <li class="list-group-item">
                        <small><a href="<?= base_url('preorder'); ?>">&laquo; Kembali ke halaman List Barang</a></small>
                </li>
            </ul>
        </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>