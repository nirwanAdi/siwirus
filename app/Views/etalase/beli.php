<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="row">
    <div class="col-4">
        <div class="card-fluid">
            <div class="card-body">
            <img class="img-fluid"src="<?= base_url('img/pre_order/barang/'.$barangPreorder['gambar_barang'])?>" >
            </div>
        </div>
    </div>
    <div class="col-6">
            <form action="/etalase/save/" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="idBarang" value="<?= $barangPreorder['id']; ?>">
                <div class="form-group row">
                    <label for="nama_barang" class="col-sm-4 col-form-label" >Nama Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $barangPreorder['nama_barang']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-sm-4 col-form-label">Harga</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="harga" name="harga" value="<?= $barangPreorder['harga']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah" class="col-sm-4 col-form-label">Jumlah</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control <?= ($validation->hasError('jumlah'))? 'is-invalid' : '' ; ?>" id="jumlah" name="jumlah" min="1">
                        <div class="invalid-feedback">
                            <?= $validation->getError('jumlah'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_harga" class="col-sm-4 col-form-label">Total Harga</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="metode_pembayaran" class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="metode_pembayaran" name="metode_pembayaran">
                            <?php foreach($metodePembayaran as $metodes) : ?>
                                <option value="<?= $metodes['id']; ?>"><?= $metodes['nama_bank']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary">Beli</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
