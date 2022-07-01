<link href="<?= base_url(); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<div class="modal fade" id="modalpengurus" tabindex="-1" aria-labelledby="modalpengurusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="modalpengurusLabel">data user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="keywordkode" id="keywordkode" value="<?= $keyword; ?>">
                <table class="table table-bordered table-responsive dataTable" id="datauser" width="100%" cellspacing="0" role="grid" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id User</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
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
        var table = $('#datauser').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('admin/listDataPengurus') ?>",
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

    function pilihitem(user_id, username, fullname, name) {
        $('#id_user').val(user_id);
        $('#username').val(username);
        $('#fullname').val(fullname);
        $('#role').val(name);

        $('#modalpengurus').modal('hide');
    }
</script>