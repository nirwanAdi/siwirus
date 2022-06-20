<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Transaksi Pre Order</h1>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Nama Barang</th>
                <th scope="col">Username</th>
                <th scope="col">Status</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi_preorder as $transaksi) : ?>
                <tr>
                <td><?= $transaksi->nama_barang ?></td>
                <td><?= $transaksi->username ?></td>
                <td>
                    <?php if($transaksi->statustransaksi==0) :?>
                    <h5><span class="badge badge-danger">Bukti pembayaran belum di Upload</span></h5> 
                    <?php elseif($transaksi->statustransaksi==1) : ?>
                    <h5><span class="badge badge-warning text-dark">Pembayaran belum dikonfirmasi</span></h5> 
                    <?php elseif($transaksi->statustransaksi==2) : ?>
                    <h5><span class="badge badge-success">Pembayaran berhasil</span></h5> 
                    <?php elseif($transaksi->statustransaksi==3) : ?>
                    <h5><span class="badge badge-danger">Pembayaran ditolak</span></h5> 
                    <?php endif; ?>
                </td>
                <td><?= $transaksi->harga; ?></td>
                <td><?= $transaksi->jumlah; ?></td>
                <td><?= $transaksi->total_harga; ?></td>
                <td>
                    <a href="<?= base_url('preorder/transaksi-pre-order/detail/'.$transaksi->transaksiid); ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                    <form action="/transaksipreorder/<?= $transaksi->transaksiid; ?>" method="post" class="d-inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>