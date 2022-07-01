<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Input Kasir</h3>
    <div class="card card-default color-palette-box">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-warning btn-sm" onclick="window.location='<?= site_url('penjualan/index') ?>'">&laquo; Kembali</button>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nofaktur">Faktur</label>
                        <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="nofaktur" id="nofaktur" readonly value="<?= $nofaktur; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="napeng">Pengurus</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-sm" name="napeng" id="napeng" readonly value="<?= user()->username; ?>">
                            <input type="hidden" name="kopeng" id="kopeng" value="<?= user_id(); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal">Aksi</label>
                        <div class="input-group">
                            <button class="btn btn-success" type="button" id="btnSimpanTransaksi">
                                <i class="fa fa-save"></i>
                            </button>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="kodeproduk">Kode Produk</label>
                        <input type="text" class="form-control form-control-sm" name="kodeproduk" id="kodeproduk" autofocus>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="namaproduk">Barang</label>
                        <input type="text" class="form-control form-control-sm" name="namaproduk" id="namaproduk" autofocus readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="jml">Jumlah</label>
                        <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="jml">Total Bayar</label>
                        <input type="text" class="form-control form-control-lg" name="totalbayar" id="totalbayar" style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="0" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 dataDetailPenjualan">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display : none"></div>
<div class="viewmodalpembayaran" style="display : none"></div>
<script>
    $(document).ready(function() {
        dataDetailPenjualan();
        hitungTotalBayar();

        $('#kodeproduk').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        })
        $('#btnSimpanTransaksi').click(function(e) {
            e.preventDefault();
            pembayaran();
        })
    });

    function pembayaran() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('kasir/pembayaran'); ?>",
            data: {
                nofaktur: nofaktur,
                tglfaktur: $('#tanggal').val(),
                kopeng: $('#kopeng').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error!!!',
                        html: response.error,
                    });
                }
                if (response.data) {
                    $('.viewmodalpembayaran').html(response.data).show();
                    $('#modalpembayaran').on('shown.bs.modal', function(event) {
                        $('#jmluang').focus();
                    });
                    $('#modalpembayaran').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
            }
        })
    }

    function dataDetailPenjualan() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kasir/dataDetail'); ?>",
            data: {
                nofaktur: $('#nofaktur').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.dataDetailPenjualan').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
            }
        })
    }

    function cekKode() {
        let kode = $('#kodeproduk').val();

        if (kode.length == 0) {
            $.ajax({
                url: "<?= site_url('kasir/viewDataProduk'); ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.viewmodal).show();

                    $('#modalproduk').modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })
        } else {
            $.ajax({
                type: "post",
                url: "<?= site_url('kasir/simpanTemp'); ?>",
                data: {
                    kodeproduk: kode,
                    namaproduk: $('#namaproduk').val(),
                    jumlah: $('#jumlah').val(),
                    nofaktur: $('#nofaktur').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.totaldata == 'banyak') {
                        $.ajax({
                            type: "post",
                            url: "<?= site_url('kasir/viewDataProduk'); ?>",
                            data: {
                                keyword: kode
                            },
                            dataType: "json",
                            success: function(response) {
                                $('.viewmodal').html(response.viewmodal).show();

                                $('#modalproduk').modal('show');
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                            }
                        })
                    }

                    if (response.sukses == 'berhasil') {
                        dataDetailPenjualan();
                        kosong();
                    }

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!!!',
                            html: response.error,
                        });
                        dataDetailPenjualan();
                        kosong();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })
        }
    }

    function kosong() {
        $('#kodeproduk').val('');
        $('#namaproduk').val('');
        $('#jumlah').val('1');
        $('#kodeproduk').val('').focus();
        hitungTotalBayar()
    }

    function hitungTotalBayar() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kasir/hitungTotalBayar'); ?>",
            data: {
                nofaktur: $('#nofaktur').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.totalbayar) {
                    $('#totalbayar').val(response.totalbayar)
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
            }
        })
    }
</script>

<?= $this->endSection(); ?>