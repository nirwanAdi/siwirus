<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
<h3 class="h3 mb-4 text-gray-800">Tambah Data Produk</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="card-title ">
                <a href="/produk/index" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Kembali ke Management Data Produk</span>
                </a>
            </div>
        </div>
        <div class="card-body">
        <form action="/produk/save" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="form-group row">
        <label for="kodeproduk" class="col-sm-2 col-form-label">Kode Produk</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('kodeproduk'))? 'is-invalid' : '' ; ?>" id="kodeproduk" name="kodeproduk" autofocus value="<?= old('kodeproduk'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('kodeproduk'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="namaproduk" class="col-sm-2 col-form-label">Nama Produk</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('namaproduk'))? 'is-invalid' : '' ; ?>" id="namaproduk" name="namaproduk" value="<?= old('namaproduk'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('namaproduk'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
        <div class="col-sm-6">
            <select class="form-control" id="satuan" name="satuan">
                <?php foreach($satuan as $satuans) : ?>
                    <option value="<?= $satuans['satid']; ?>"><?= $satuans['satnama']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-6">
            <select class="form-control" id="kategori" name="kategori">
                <?php foreach($kategori as $kategoris) : ?>
                    <option value="<?= $kategoris['katid']; ?>"><?= $kategoris['katnama']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="stok_tersedia" class="col-sm-2 col-form-label">Stok</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('stok_tersedia'))? 'is-invalid' : '' ; ?>" id="stok_tersedia" name="stok_tersedia" value="<?= old('stok_tersedia'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('stok_tersedia'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('harga_beli'))? 'is-invalid' : '' ; ?>" id="harga_beli" name="harga_beli" value="<?= old('harga_beli'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('harga_beli'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
        <div class="col-sm-6">
        <input type="text" class="form-control <?= ($validation->hasError('harga_jual'))? 'is-invalid' : '' ; ?>" id="harga_jual" name="harga_jual" value="<?= old('harga_jual'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('harga_jual'); ?>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="gambar_produk" class="col-sm-2 col-form-label">Gambar Barang</label>
        <div class="col-sm-2">
            <img src="<?= base_url('img/pre_order/barang/default.png'); ?>" class="img-thumbnail img-preview">
        </div>
        <div class="col-sm-4">
        <div class="custom-file">
            <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_produk'))? 'is-invalid' : '' ; ?>" id="gambar_produk" name="gambar_produk" onchange="previewImgProduk()">
            <label class="custom-file-label" for="gambar_produk">Upload Gambar Barang</label>
            <div class="invalid-feedback">
                <?= $validation->getError('gambar_produk'); ?>
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
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function previewImgProduk(){
            const gambarProduk = document.querySelector('#gambar_produk');
            const gambarProdukLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');
    
            gambarProdukLabel.textContent = gambar_produk.files[0].name;
    
            const fileGambarProduk = new FileReader();
            fileGambarProduk.readAsDataURL(gambar_produk.files[0]);
            fileGambarProduk.onload = function(e){
                imgPreview.src = e.target.result;
            }
        }
</script>
<?= $this->endSection(); ?>