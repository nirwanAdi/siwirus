<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h3 class="h3 mb-4 text-gray-800">Kasir</h3>

    <div class="row">
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-70 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="h5 mb-0 font-weight-bold text-primary text-uppercase">Input Kasir</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-0 mt-0">
                    <a href="<?= site_url('kasir/input'); ?>" class="text-center">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-70 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-1">
                            <div class="h5 mb-0 font-weight-bold text-primary text-uppercase">Laporan Keuangan Toko</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-0 mt-0">
                    <a href="#" class="text-center">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>