<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Jabatan</th>
            <th>Poin</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        <?php foreach ($datadetail->getResultArray() as $row) : ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['username']; ?></td>
                <td><?= $row['fullname']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['poin']; ?></td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="hapusitem('<?= $row['id']; ?>','<?= $row['fullname']; ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function hapusitem(id, nama) {
        Swal.fire({
            title: 'Hapus pengurus?',
            html: `Yakin menghapus <strong>${nama}</strong> dari pengurus?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya Hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('admin/hapusPengurus'); ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataDetailPengurus();
                            kosong();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                    }
                })
            }
        })
    }
</script>