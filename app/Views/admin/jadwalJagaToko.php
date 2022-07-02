<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">User Detail</h1>
    <div class="row mx-0">
        <div class="card mb-3 w-100">
            <div class="row align-content-center justify-content-center no-gutters px-5 py-4">
                <div class="row justify-content-end w-100 mx-0 mb-4">
                    <button class="btn btn-primary" onclick="showModalJadwal();">+ Jadwal</button>
                </div>
                <?php if (!empty($jadwal)) { ?>
                    <div class="w-100">
                        <table id="tabelJadwal" class="display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Hari</th>
                                    <th>Sesi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <script>
                        let data = [];
                        <?php foreach ($jadwal as $key => $data) { ?>
                            data[<?= $key ?>] = ["<?= $key+1 ?>", "<?= $data['username'] ?>", "<?= $data['hari'] ?>", "<?= $data['sesi'] ?>"];
                        <?php } ?>

                        $('#tabelJadwal').DataTable({
                            data: data
                        });
                    </script>
                <?php } else { ?>
                    <h4 class="font-weight-bold mb-0">Belum ada jadwal jaga toko.</h4>
                <?php } ?>
            </div>
        </div>
    </div>

    <div id="modalJadwal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">+ Jadwal Jaga Toko</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">Penjaga</label>
                        <select class="form-control" id="user_id">
                            <option disabled selected hidden>Pilih Penjaga</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label for="user_id">Penjaga</label>
                        <input type="date" class="form-control" id="hari" />
                    </div>
                    <div class="form-group mt-4">
                        <label for="user_id">Sesi</label>
                        <select class="form-control" id="sesi">
                            <option disabled selected hidden>Pilih Sesi</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="simpanJadwal();">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModalJadwal() {
            $('#modalJadwal').modal('show');
        }

        function simpanJadwal() {
            user_id = document.getElementById('user_id').value;
            hari = document.getElementById('hari').value;
            sesi = document.getElementById('sesi').value;
            $.post(
                '<?= base_url() ?>/admin/tambahJadwalJaga',
                {user_id:user_id, hari:hari, sesi:sesi},
                function(response){ 
                    res = JSON.parse(response);
                    if (res.status == 'berhasil') {
                        Swal.fire({
                            text: "Jadwal berhasil ditambahkan!",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else if (res.type == 'user_id') {
                        Swal.fire({
                            text: "User tidak ditemukan!",
                            icon: "error"
                        });
                    } else if (res.type == 'hari') {
                        Swal.fire({
                            text: "Penjaga ini sudah ditugaskan pada jadwal tersebut!",
                            icon: "error"
                        });
                    } else {
                        Swal.fire({
                            text: "Jadwal gagal ditambahkan!",
                            icon: "error"
                        });
                    }
                }
            );
        }
    </script>
</div>

<?= $this->endSection(); ?>