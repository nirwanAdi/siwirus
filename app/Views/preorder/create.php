<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Barang</h1>
    <form action="/preorder/save" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="form-group row">
        <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('nama_barang'))? 'is-invalid' : '' ; ?>" id="nama_barang" name="nama_barang" autofocus value="<?= old('nama_barang'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('nama_barang'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('harga'))? 'is-invalid' : '' ; ?>" id="harga" name="harga" value="<?= old('harga'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('harga'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="gambar_barang" class="col-sm-2 col-form-label">Gambar Barang</label>
        <div class="col-sm-2">
            <img src="<?= base_url('img/pre_order/barang/default.png'); ?>" class="img-thumbnail img-preview">
        </div>
        <div class="col-sm-4">
        <div class="custom-file">
            <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_barang'))? 'is-invalid' : '' ; ?>" id="gambar_barang" name="gambar_barang" onchange="previewImg()">
            <label class="custom-file-label" for="gambar_barang">Upload Gambar Barang</label>
            <div class="invalid-feedback">
                <?= $validation->getError('gambar_barang'); ?>
            </div>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
        <button type="submit" class="btn btn-primary">Tambah Data</button>
        </div>
    </div>
    </form>
</div>

<?= $this->endSection(); ?>