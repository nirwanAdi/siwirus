<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                  <tr role="row">
                    <th crowspan="1" colspan="1" style="width: 57px;">Nomor</th>
                    <th rowspan="1" colspan="1" style="width: 61px;">Nama Lengkap</th>
                    <th rowspan="1" colspan="1" style="width: 49px;">Username</th>
                    <th rowspan="1" colspan="1" style="width: 31px;">Email</th>
                    <th rowspan="1" colspan="1" style="width: 68px;">Role</th>
                    <th rowspan="1" colspan="1" style="width: 68px;">Aktif</th>
                    <th rowspan="1" colspan="1" style="width: 67px;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($users as $rw) {
                    $row = "row" . $rw->id;
                    echo $$row;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form action="<?= base_url(); ?>/admin/changeGroup" method="post">
    <div class="modal fade" id="changeGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Grup</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="list-group-item p-3">
              <div class="row align-items-start">
                <div class="col-md-4 mb-8pt mb-md-0">
                  <div class="media align-items-left">
                    <div class="d-flex flex-column media-body media-middle">
                      <span class="card-title">Grup</span>
                    </div>
                  </div>
                </div>
                <div class="col mb-8pt mb-md-0">
                  <select name="group" class="form-control" data-toggle="select">
                    <?php
                    foreach ($groups as $key => $row) {
                    ?>
                      <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id" class="id">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Ubah</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- Page Heading -->
  <!-- <h1 class="h3 mb-4 text-gray-800">User List</h1>
<div class="row">
    <div class="col-lg-8">
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach ($users as $user) : ?>
    <tr>
      <th scope="row"><?= $i++; ?></th>
      <td><?= $user->username; ?></td>
      <td><?= $user->email; ?></td>
      <td><?= $user->name; ?></td>
      <td>
          <a href="<?= base_url('admin/' . $user->userid); ?>" class="btn btn-info">Detail</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
    </div>
</div> -->

</div>

<script>
  $('.btn-change-group').on('click', function() {
    const id = $(this).data('id');

    $('.id').val(id);
    $('#changeGroupModal').modal('show');
  });
</script>

<?= $this->endSection(); ?>