<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Management Data Satuan</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Button trigger modal -->
            <div class="card-title ">
                <button type="button" class="btn btn-sm btn-primary btn-icon-split tombolTambah">
                    <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                    <span class="text">Tambah Data</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="/satuan/index">
                <?= csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama Satuan" name="carisatuan" autofocus value="<?= $cari; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="tombolsatuan">Cari</button>
                    </div>
                </div>
            </form>
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1 + (($nohalaman - 1) * 3);
                    foreach ($datasatuan as $row) :
                    ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $row['satnama']; ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" title="Hapus Satuan" onclick="hapus('<?= $row['satid'] ?>','<?= $row['satnama'] ?>')">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" title="Edit Satuan" onclick="edit('<?= $row['satid'] ?>')">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <?= $pager->links('satuan', 'paging_data'); ?>
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
    function hapus(id, nama) {
        Swal.fire({
            title: 'Hapus Satuan',
            html: `Yakin hapus satuan <strong>${nama}</strong> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('satuan/hapus') ?>",
                    data: {
                        idsatuan: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }

    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('satuan/formEdit') ?>",
            data: {
                idsatuan: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalformedit').on('shown.bs.modal', function(event) {
                        $('#namasatuan').focus();
                    });
                    $('#modalformedit').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    $(document).ready(function() {
        $('.tombolTambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('satuan/formTambah') ?>",
                dataType: "json",
                type: 'post',
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahsatuan').on('shown.bs.modal', function(event) {
                            $('#namasatuan').focus();
                        });
                        $('#modaltambahsatuan').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>