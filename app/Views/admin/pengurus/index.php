<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Pengurus</h3>
    <div class="card card-default color-palette-box">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="username" id="username" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="fullname" id="fullname" readonly value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="role">Jabatan</label>
                        <input type="text" class="form-control form-control-sm" name="role" id="role" readonly value="">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="hidden" class="form-control form-control-sm" name="id_user" id="id_user" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 dataDetailPengurus">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display : none"></div>
<script>
    $(document).ready(function() {
        dataDetailPengurus();

        $('#username').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        })
        $('#btnSimpanTransaksi').click(function(e) {
            e.preventDefault();
        })
    })

    function dataDetailPengurus() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/dataDetail'); ?>",
            data: {
                username: $('#username').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.dataDetailPengurus').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
            }
        })
    }

    function cekKode() {
        let kode = $('#username').val();

        if (kode.length == 0) {
            $.ajax({
                url: "<?= site_url('admin/viewDataPengurus'); ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.viewmodal).show();

                    $('#modalpengurus').modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })
        } else {
            $.ajax({
                type: "post",
                url: "<?= site_url('admin/simpanPengurus'); ?>",
                data: {
                    id_user: $('#id_user').val(),
                    username: $('#username').val(),
                    fullname: $('#fullname').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.totaldata == 'banyak') {
                        $.ajax({
                            type: "post",
                            url: "<?= site_url('admin/viewDataPengurus'); ?>",
                            data: {
                                keyword: kode
                            },
                            dataType: "json",
                            success: function(response) {
                                $('.viewmodal').html(response.viewmodal).show();

                                $('#modalpengurus').modal('show');
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                            }
                        })
                    }

                    if (response.sukses == 'berhasil') {
                        dataDetailPengurus();
                        kosong();
                    }

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!!!',
                            html: response.error,
                        });
                        dataDetailPengurus();
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
        $('#username').val('');
        $('#fullname').val('');
        $('#role').val('');
        $('#username').val('').focus();
    }
</script>
<?= $this->endSection(); ?>