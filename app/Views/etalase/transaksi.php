<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">

<!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Transaksi</h1>
    <div class="row">
        <div class="col-lg-12">
        <?php $i = 1; ?>
        <?php foreach ($transaksi_preorder as $transaksi) : ?>
        <?php if($transaksi->id_pembeli==user_id()): ?>
        <div class="card mb-2">
            <div class="row no-gutters m-2">
                <div class="col-md-3 mt-2">
                <img src="<?= base_url('img/pre_order/barang/'.$transaksi->gambar_barang)?>" class="card-img" style="max-height:150px ; max-width : 150px ;">
                </div>
                <div class="col-md-4">
                <div class="card-body" style="line-height: 0.5;">
                    <h5 class="card-title text-primary"><b><?= $transaksi->nama_barang; ?></b></h5>
                    <p class="card-text">Harga: <?= "Rp.". number_format($transaksi->harga,2,',','.'); ?></p>
                    <p class="card-text">Jumlah Barang : <?= $transaksi->jumlah; ?></p>
                    <p class="card-text">Total Harga : <?= "Rp.". number_format($transaksi->total_harga,2,',','.'); ?></p>
                    <p class="card-text">Metode Pembayaran : <?= $transaksi->nama_bank; ?></p>
                    <?php if($transaksi->statustransaksi==0) :?>
                        <big><span class="badge badge-danger">Bukti pembayaran belum di Upload</span></big> 
                    <?php elseif($transaksi->statustransaksi==1) : ?>
                        <big><span class="badge badge-warning text-dark">Pembayaran belum dikonfirmasi</span></big> 
                    <?php elseif($transaksi->statustransaksi==2) : ?>
                        <big><span class="badge badge-success">Pembayaran berhasil</span></big> 
                    <?php elseif($transaksi->statustransaksi==3) : ?>
                        <big><span class="badge badge-danger">Pembayaran ditolak</span></big> 
                    <?php endif; ?>
                </div>
                </div>
                <div class="col-md6">
                <a href="<?= base_url('etalase/detail_transaksi/'.$transaksi->transaksiid); ?>" class="btn btn-primary" style="width:200px">Detail Pesanan</a>
                        <?php if($transaksi->statustransaksi== 0 || $transaksi->statustransaksi == 3) : ?>
                            <form action="/etalase/hapus/<?= $transaksi->transaksiid; ?>" method="post" class="mt-2">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger" style="width:200px">Batalkan Pemesanan</button>
                            </form>
                        <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>