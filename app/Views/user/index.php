<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <?php if (in_groups('user')) : ?>
        <h1 class="h3 mb-4 text-gray-800">User Profile</h1>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="<?= base_url('/img/' . user()->user_image); ?>" class="card-img" alt="<?= user()->username; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h4><?= user()->username; ?></h4>
                                    </li>
                                    <?php if (user()->fullname) :; ?>
                                        <li class="list-group-item"><?= user()->fullname; ?></li>
                                    <?php endif; ?>
                                    <li class="list-group-item">
                                        <h6><?= user()->email; ?></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <h1 class="h3 mb-4 text-gray-800">User Profile</h1>

        <div class="row" style="height : 100px ;">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-sm-4 p-2">
                            <img src="<?= base_url('/img/' . user()->user_image); ?>" class="card-img" alt="<?= user()->username; ?>" style="width : 100px; height : 100px">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="row mx-0">
                                    <ul class="list-group list-group-flush w-100">
                                        <li class="list-group-item">
                                            <h4><?= user()->username; ?></h4>
                                        </li>
                                        <?php if (user()->fullname) :; ?>
                                            <li class="list-group-item"><?= user()->fullname; ?></li>
                                        <?php endif; ?>
                                        <li class="list-group-item">
                                            <h6><?= user()->email; ?></h6>
                                        </li>
                                    </ul>
                                    <div class="row justify-content-end w-100 mx-0 mt-5">
                                        <?php if (empty($absensi)) { ?>
                                            <button class="btn btn-success" onclick="absen('datang')">Absensi Datang</button>
                                        <?php } elseif (empty($absensi['waktu_pulang'])) { ?>
                                            <select id="daftarKegiatan" class="form-control" style="max-height: 60px;" multiple>
                                                <option>Melayani Pembeli</option>
                                                <option>Display Barang</option>
                                                <option>Menerima Barang</option>
                                                <option>Input Barang</option>
                                                <option>Membersihkan Toko</option>
                                            </select>
                                            <button class="btn btn-success mt-2" onclick="absen('pulang')">Absensi Pulang</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function absen(type) {
            var kegiatan = document.getElementById('daftarKegiatan');
            if (kegiatan!=null) {
                var daftarKegiatan = $('#daftarKegiatan').val().toString();
            }

            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", `<?= base_url() ?>/user/absen/${type}/${daftarKegiatan}`);
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText.includes("berhasil")) {
                        Swal.fire({
                            text: "Presensi berhasil dilakukan!",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            text: 'Presensi gagal dilakukan!',
                            icon: 'error',
                        });
                    }
                }
            };
            xhttp.send();
        }
    </script>
</div>

<?= $this->endSection(); ?>