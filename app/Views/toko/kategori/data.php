<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Managaement Data Kategori</h3>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/kategori/save" method="post">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="katnama" class="col-sm-4 col-form-label">Nama Kategori</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control <?= ($validation->hasError('nama_bank'))? 'is-invalid' : '' ; ?>" id="katnama" name="katnama" autofocus>
                                <div class="invalid-feedback">
                                <?= $validation->getError('katnama'); ?>
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
            <form action="/kategori/index" method="post">
                <?= csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama Kategori" name="cari_kategori" autofocus>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="tombol_kategori" id="button-addon2"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1+(($nohalaman-1)*2) ?>
                    <?php foreach($kategori as $kategoris) : ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $kategoris['katnama']; ?></td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editKategori">
                                <i class="fas fa-edit"></i>
                                </button>
                                <div class="modal fade" id="editKategori" tabindex="-1" aria-labelledby="editKategoriLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editKategoriLabel">Edit Data Kategori</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/kategori/update/<?= $kategoris['katid']; ?>" method="post">
                                    <div class="modal-body">
                                        <?= csrf_field(); ?>
                                            <div class="form-group row">
                                                <label for="katnama" class="col-sm-4 col-form-label">Nama Kategori</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control <?= ($validation->hasError('katnama'))? 'is-invalid' : '' ; ?>" id="katnama" name="katnama" autofocus value="<?= (old('katnama')) ? old('katnama') : $kategoris['katnama']; ?>">
                                                    <div class="invalid-feedback">
                                                    <?= $validation->getError('katnama'); ?>
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
                                <form action="/kategori/<?= $kategoris['katid']; ?>" method="post" class="d-inline">
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
                <?= $pager->links('kategori','paging_data'); ?>
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display : none;"></div>
<?= $this->endSection(); ?>