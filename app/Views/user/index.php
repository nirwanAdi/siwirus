<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <?php if (in_groups('user')) : ?>
        <h1 class="h3 mb-4 text-gray-800">User Profile</h1>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="<?= base_url('/img/' . user()->user_image); ?>" class="card-img" alt="<?= user()->username; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h4><?= user()->username; ?></h4>
                                    </li>
                                    <?php if (user()->fullname) :; ?>
                                        <li class="list-group-item"><?= user()->fullname; ?></li>
                                    <?php endif; ?>
                                    <li class="list-group-item">
                                        <h6><?= user()->email; ?></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <h1 class="h3 mb-4 text-gray-800">User Profile</h1>

        <div class="row">
            <div class="col-lg-12" style="height:100px ;">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-sm-4">
                            <img src="<?= base_url('/img/' . user()->user_image); ?>" class="card-img" alt="<?= user()->username; ?>" style="width : 100px; height : 100px">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h4><?= user()->username; ?></h4>
                                    </li>
                                    <?php if (user()->fullname) :; ?>
                                        <li class="list-group-item"><?= user()->fullname; ?></li>
                                    <?php endif; ?>
                                    <li class="list-group-item">
                                        <h6><?= user()->email; ?></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>