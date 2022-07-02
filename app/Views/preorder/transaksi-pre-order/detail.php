<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3" style="max-height: 300px;">
                <div class="row no-gutters m-2">
                    <div class="col-md-4">
                        <img src="<?= base_url('/img/pre_order/barang/' . $transaksi_preorder->gambar_barang); ?>" class="card-img" style="max-width:200px ; max-heigth:200px">
                    </div>
                    <div class="col-md-8" style="line-height: 1;">
                        <div class="card-body">
                            <h5 class="card-title"><big><b><?= $transaksi_preorder->username; ?></b></big></h5>
                            <div class="row">
                                <div class="col-md-6" style="line-height: 1;">
                                    <p class="card-text">Barang yang dibeli : <?= $transaksi_preorder->nama_barang; ?></p>
                                    <p class="card-text">Harga barang : <?= "Rp." . number_format($transaksi_preorder->harga, 2, ',', '.'); ?></p>
                                    <p class="card-text">Jumlah barang : <?= $transaksi_preorder->transaksi_jumlah; ?></p>
                                    <p class="card-text">Kelas : <?= $transaksi_preorder->kelas; ?></p>
                                    <p class="card-text">Nomor Hp : <?= $transaksi_preorder->nomor_hp; ?></p>
                                    <p class="card-text">Total Harga : <?= "Rp." . number_format($transaksi_preorder->total_harga, 2, ',', '.'); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text">Metode Pembayaran : <?= $transaksi_preorder->nama_bank; ?></p>
                                    <p class="card-text">Rekening : <?= $transaksi_preorder->no_rekening ?></p>
                                    <p class="card-text">Atas Nama : <?= $transaksi_preorder->nama_pemilik ?></p>
                                    <?php if ($transaksi_preorder->statustransaksi == 0) : ?>
                                        <big><span class="badge badge-danger">Bukti pembayaran belum di Upload</span></big>
                                    <?php elseif ($transaksi_preorder->statustransaksi == 1) : ?>
                                        <big><span class="badge badge-warning text-dark">Pembayaran belum dikonfirmasi</span></big>
                                    <?php elseif ($transaksi_preorder->statustransaksi == 2) : ?>
                                        <big><span class="badge badge-success">Pembayaran berhasil</span></big>
                                    <?php elseif ($transaksi_preorder->statustransaksi == 3) : ?>
                                        <big><span class="badge badge-danger">Pembayaran ditolak</span></big>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <small><a href="<?= base_url('/preorder/transaksi-pre-order/index'); ?>">&laquo; Kembali ke halaman User List</a></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($transaksi_preorder->statustransaksi == 0) : ?>
                <div class="alert alert-danger">
                    Bukit Pembayaran Belum di Upload
                </div>
            <?php else : ?>
                <div class="card mb-3" style="max-height: 400px;">
                    <div class="row no-gutters m-2">
                        <div class="col-md-4">
                            <img src="<?= base_url('/img/pre_order/bukti_pembayaran/' . $transaksi_preorder->gambar_bukti_pembayaran); ?>" class="card-img" style="width:300px ; heigth:300px; max-width:300px; max-height:300px">
                        </div>
                        <div class="col-md-4">
                            <big>Keterangan</big>
                            <br>
                            <textarea readonly><?= $transaksi_preorder->keterangan; ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <?php if ($transaksi_preorder->statustransaksi == 1) : ?>
                                <form action="/transaksipreorder/konfirmasi/<?= $transaksi_preorder->transaksiid; ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
                                </form>
                                <form action="/transaksipreorder/tolak/<?= $transaksi_preorder->transaksiid; ?>" method="post" class="mt-2">
                                    <button type="submit" class="btn btn-danger">Tolak Bukti Pembayaran</button>
                                </form>
                            <?php elseif ($transaksi_preorder->statustransaksi == 2) : ?>
                                <div class="alert alert-success">
                                    Pembayaran telah di konfirmasi
                                </div>
                            <?php elseif ($transaksi_preorder->statustransaksi == 3) : ?>
                                <div class="alert alert-danger">
                                    Pembayaran telah di tolak
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>