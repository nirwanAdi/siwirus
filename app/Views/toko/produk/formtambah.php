<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<script src="<?= base_url('vendor/autoNumeric.js') ?>"></script>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Tambah Data Barang</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="card-title ">
                <button type="button" class="btn btn-sm btn-primary btn-icon-split" onclick="window.location='<?= site_url('produk/index') ?>'">
                    <span class="icon text-white-50"><i class="fas fa-backward"></i></span>
                    <span class="text">Kembali</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= form_open_multipart('', ['class' => 'formsimpan']) ?>
            <?= csrf_field(); ?>
            <div class="form-group row">
                <label for="kodeproduk" class="col-sm-4 col-form-label">Kode Barang</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-sm" id="kodeproduk" name="kodeproduk" autofocus>
                    <div class="invalid-feedback errorKodeProduk">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="namaproduk" class="col-sm-4 col-form-label">Nama Barang</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-sm" id="namaproduk" name="namaproduk">
                    <div class="invalid-feedback errorNamaProduk">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="stok" class="col-sm-4 col-form-label">Stok Tersedia</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="stok" name="stok" value="0">
                    <div class="invalid-feedback errorStok">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm" name="kategori" id="kategori">

                    </select>
                    <div class="invalid-feedback errorKategori">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="satuan" class="col-sm-4 col-form-label">Satuan</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm" name="satuan" id="satuan">

                    </select>
                    <div class="invalid-feedback errorSatuan">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="hargabeli" class="col-sm-4 col-form-label">Harga Beli (Rp)</label>
                <div class="col-sm-4">
                    <input style="text-align: right;" type="text" class="form-control form-control-sm" name="hargabeli" id="hargabeli">
                    <div class="invalid-feedback errorHargaBeli">
                    </div>
                </div>

            </div>
            <div class="form-group row">
                <label for="hargajual" class="col-sm-4 col-form-label">Harga Jual (Rp)</label>
                <div class="col-sm-4">
                    <input style="text-align: right;" type="text" class="form-control form-control-sm" name="hargajual" id="hargajual">
                    <div class="invalid-feedback errorHargaJual">
                    </div>
                </div>

            </div>
            <div class="form-group row">
                <label for="uploadgambar" class="col-sm-4 col-form-label">Upload Gambar</label>
                <div class="col-sm-4">
                    <input type="file" name="uploadgambar" id="uploadgambar" class="form-control form-control-md" accept=".jpg,.jpeg,.png">
                    <div class="invalid-feedback errorUpload">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-success tombolSimpan">
                        Simpan
                    </button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<div class="viewmodal" style="display:none ;"></div>
<script>
    function tampilKategori() {
        $.ajax({
            url: "<?= site_url('produk/ambilDataKategori') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#kategori').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function tampilSatuan() {
        $.ajax({
            url: "<?= site_url('produk/ambilDataSatuan') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#satuan').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    $(document).ready(function() {
        tampilKategori();
        tampilSatuan();


        $('#hargabeli').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('#hargajual').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('#stok').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

        $('.tombolSimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formsimpan')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('produk/simpandata') ?>",
                data: data,
                dataType: "json",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.tombolSimpan').prop('disabled', true);
                },
                complete: function() {
                    $('.tombolSimpan').html('Simpan');
                    $('.tombolSimpan').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let msg = response.error;
                        if (msg.errorKodeProduk) {
                            $('.errorKodeProduk').html(msg.errorKodeProduk).show();
                            $('#kodeproduk').addClass('is-invalid');
                        } else {
                            $('.errorKodeProduk').fadeOut();
                            $('#kodeproduk').removeClass('is-invalid');
                            $('#kodeproduk').addClass('is-valid');
                        }

                        if (msg.errorNamaProduk) {
                            $('.errorNamaProduk').html(msg.errorNamaProduk).show();
                            $('#namaproduk').addClass('is-invalid');
                        } else {
                            $('.errorNamaProduk').fadeOut();
                            $('#namaproduk').removeClass('is-invalid');
                            $('#namaproduk').addClass('is-valid');
                        }

                        if (msg.errorStok) {
                            $('.errorStok').html(msg.errorStok).show();
                            $('#stok').addClass('is-invalid');
                        } else {
                            $('.errorStok').fadeOut();
                            $('#stok').removeClass('is-invalid');
                            $('#stok').addClass('is-valid');
                        }

                        if (msg.errorKategori) {
                            $('.errorKategori').html(msg.errorKategori).show();
                            $('#kategori').addClass('is-invalid');
                        } else {
                            $('.errorKategori').fadeOut();
                            $('#kategori').removeClass('is-invalid');
                            $('#kategori').addClass('is-valid');
                        }

                        if (msg.errorSatuan) {
                            $('.errorSatuan').html(msg.errorSatuan).show();
                            $('#satuan').addClass('is-invalid');
                        } else {
                            $('.errorSatuan').fadeOut();
                            $('#satuan').removeClass('is-invalid');
                            $('#satuan').addClass('is-valid');
                        }

                        if (msg.errorHargaBeli) {
                            $('.errorHargaBeli').html(msg.errorHargaBeli).show();
                            $('#hargabeli').addClass('is-invalid');
                        } else {
                            $('.errorHargaBeli').fadeOut();
                            $('#hargabeli').removeClass('is-invalid');
                            $('#hargabeli').addClass('is-valid');
                        }

                        if (msg.errorHargaJual) {
                            $('.errorHargaJual').html(msg.errorHargaJual).show();
                            $('#hargajual').addClass('is-invalid');
                        } else {
                            $('.errorHargaJual').fadeOut();
                            $('#hargajual').removeClass('is-invalid');
                            $('#hargajual').addClass('is-valid');
                        }

                        if (msg.errorUpload) {
                            $('.errorUpload').html(msg.errorUpload).show();
                            $('#uploadgambar').addClass('is-invalid');
                        }
                    } else {
                        Swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.assign('<?= site_url('produk/index') ?>');
                            }
                        });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    })
</script>
<?= $this->endSection(); ?>