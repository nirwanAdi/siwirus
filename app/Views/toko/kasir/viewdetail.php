<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Harga Jual</th>
            <th>Sub Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        <?php foreach ($datadetail->getResultArray() as $row) : ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['kode']; ?></td>
                <td><?= $row['namaproduk']; ?></td>
                <td><?= $row['qty']; ?></td>
                <td class="text-left"><?= number_format($row['harga_jual'], 2, ',', '.'); ?></td>
                <td><?= $row['subtotal']; ?></td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="hapusitem('<?= $row['id']; ?>','<?= $row['namaproduk']; ?>')">
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
            title: 'Hapus item?',
            html: `Yakin menghapus item <strong>${nama}</strong>`,
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
                    url: "<?= site_url('kasir/hapusItem'); ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataDetailPenjualan();
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