<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Ubah Data Metode Pembayaran</h1>
    <form action="/metodepembayaran/update/<?= $metodePembayaran['id']; ?>" method="POST">
        <?= csrf_field(); ?>
        <div class="form-group row">
            <label for="nama_bank" class="col-sm-4 col-form-label">Nama Bank</label>
            <div class="col-sm-6">
                <input type="text" class="form-control <?= ($validation->hasError('nama_bank')) ? 'is-invalid' : ''; ?>" id="nama_bank" name="nama_bank" autofocus value="<?= (old('nama_bank')) ? old('nama_bank') : $metodePembayaran['nama_bank']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_bank'); ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="no_rekening" class="col-sm-4 col-form-label">No Rekening</label>
            <div class="col-sm-6">
                <input type="text" class="form-control <?= ($validation->hasError('no_rekening')) ? 'is-invalid' : ''; ?>" id="no_rekening" name="no_rekening" value="<?= (old('no_rekening')) ? old('no_rekening') : $metodePembayaran['no_rekening']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('no_rekening'); ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_pemilik" class="col-sm-4 col-form-label">Nama Pemilik Rekening</label>
            <div class="col-sm-6">
                <input type="text" class="form-control <?= ($validation->hasError('nama_pemilik')) ? 'is-invalid' : ''; ?>" id="nama_pemilik" name="nama_pemilik" value="<?= (old('nama_pemilik')) ? old('nama_pemilik') : $metodePembayaran['nama_pemilik']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('nama_pemilik'); ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary">Ubah Data</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>