<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Management Data Barang</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="card-title ">
                <button type="button" class="btn btn-sm btn-primary btn-icon-split" onclick="window.location='<?= site_url('produk/add') ?>'">
                    <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                    <span class="text">Tambah Data</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= form_open('produk/index'); ?>
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Kode/Nama Produk" name="cariproduk" autofocus value="<?= $cari; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="tombolcariproduk">Cari</button>
                </div>
            </div>
            <?= form_close(); ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1 + (($nohalaman - 1) * 3);
                        foreach ($dataproduk as $row) :
                        ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= $row['kodeproduk']; ?></td>
                                <td><?= $row['namaproduk']; ?></td>
                                <td><?= $row['katnama']; ?></td>
                                <td><?= $row['satnama']; ?></td>
                                <td class="text-right"><?= number_format($row['harga_beli'], 0, ".", ","); ?></td>
                                <td class="text-right"><?= number_format($row['harga_jual'], 0, ".", ","); ?></td>
                                <td class="text-right"><?= $row['stok_tersedia']; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus Produk" onclick="hapus('<?= $row['kodeproduk'] ?>','<?= $row['namaproduk'] ?>')">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" title="Edit Produk" onclick="window.location='/produk/edit/<?= $row['kodeproduk'] ?>'">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?= $pager->links('produk', 'paging_data'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function hapus(kode, nama) {
        Swal.fire({
            title: 'Hapus Produk',
            html: `Yakin hapus produk <strong>${nama}</strong> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('produk/hapus') ?>",
                    data: {
                        kode: kode
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }
</script>
<?= $this->endSection(); ?>