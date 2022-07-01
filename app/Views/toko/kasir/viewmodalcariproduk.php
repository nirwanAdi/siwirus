<!-- Modal -->
<link href="<?= base_url(); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<div class="modal fade" id="modalproduk" tabindex="-1" aria-labelledby="modalprodukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="modalprodukLabel">data produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="keywordkode" id="keywordkode" value="<?= $keyword; ?>">
                <table class="table table-bordered table-responsive dataTable" id="dataproduk" width="100%" cellspacing="0" role="grid" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#dataproduk').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('kasir/listDataProduk') ?>",
                "type": "POST",
                "data": {
                    keywordkode: $('#keywordkode').val()
                }
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
    });

    function pilihitem(kode, nama) {
        $('#kodeproduk').val(kode);
        $('#namaproduk').val(nama);

        $('#modalproduk').modal('hide');
    }
</script>