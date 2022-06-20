<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="conatiner-fluid">
    <div class="row ml-2">
        <?php foreach($barangPreorder as $barangs) :?>
                <div class="col-4">
                    <div class="card text-center">
                        <div class="card-header">
                            <span class="text-primary"><strong><?= $barangs['nama_barang']; ?></strong></span>
                        </div>
                        <div class="card-body">
                            <img class="img-thumbnail" style="height:150px ; width : 150px ;" src="<?= base_url('/img/pre_order/barang/'.$barangs['gambar_barang']); ?>">
                            <h5 class="mt-3 text-primary"><?= "Rp.". number_format($barangs['harga'],2,',','.')?></h5>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('etalase/beli/'.$barangs['id']); ?>" style="width:100%;" class="btn btn-primary">Beli</a>
                        </div>
                    </div>
                </div>
        <?php endforeach ?>
    </div>
</div>


<?= $this->endSection(); ?>