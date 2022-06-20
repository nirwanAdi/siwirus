<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Managaement Data Satuan</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <!-- Button trigger modal -->
            <div class="card-title ">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
            <span>Tambah Data</span>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/satuan/save" method="post">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="satnama" class="col-sm-4 col-form-label">Nama Satuan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control <?= ($validation->hasError('satnama'))? 'is-invalid' : '' ; ?>" id="satnama" name="satnama" autofocus>
                                <div class="invalid-feedback">
                                <?= $validation->getError('satnama'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1+(($nohalaman-1)*2) ?>
                    <?php foreach($satuanModel as $satuan) : ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $satuan['satnama']; ?></td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editSatuan">
                                <i class="fas fa-edit"></i>
                                </button>
                                <div class="modal fade" id="editSatuan" tabindex="-1" aria-labelledby="editSatuanLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSatuanLabel">Edit Data Satuan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/satuan/update/<?= $satuan['satid']; ?>" method="post">
                                    <div class="modal-body">
                                        <?= csrf_field(); ?>
                                            <div class="form-group row">
                                                <label for="satnama" class="col-sm-4 col-form-label">Nama Satuan</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control <?= ($validation->hasError('satnama'))? 'is-invalid' : '' ; ?>" id="satnama" name="satnama" autofocus value="<?= (old('satnama')) ? old('satnama') : $satuan['satnama']; ?>">
                                                    <div class="invalid-feedback">
                                                    <?= $validation->getError('satnama'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                                <form action="/satuan/<?= $satuan['satid']; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('satuan','paging_data'); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>