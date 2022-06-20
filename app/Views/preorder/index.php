<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List Barang Pre Order</h1>
    <div class="row">
        <div class="col-lg-8">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($barangPreorder)) : ?>
                    <tr>
                        <td colspan="4" class="text-center"><big>Data Kosong</big></td>
                    </tr>
                    <?php else : ?>
                    <?php $i=1; ?>
                    <?php foreach($barangPreorder as $barang) : ?>
                    <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $barang['nama_barang']; ?></td>
                    <td><?= $barang['harga']; ?></td>
                    <td class="text-center">
                        <a href="/preorder/edit/<?= $barang['id']; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                        <form action="/preorder/<?= $barang['id']; ?>" method="post" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        <a href="<?= base_url('preorder/'.$barang['id']); ?>" class="btn btn-secondary"><i class="fas fa-search"></i></a>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>