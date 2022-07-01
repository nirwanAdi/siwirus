<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user/index'); ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('/img/logo-2.png'); ?>" alt="" style="width: 75px;height: 75px; border-radius :50%">
        </div>
        <div class="sidebar-brand-text mx-3">SIWIRUS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <?php if (in_groups('admin')) : ?>
        <div class="sidebar-heading">
            Menu Admin
        </div>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/index'); ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Management User</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/pengurus'); ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Pengurus UKM</span></a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Pre-Order -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-shopping-cart"></i>
                <span>Pre Order</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Menu Pre Order:</h6>
                    <a class="collapse-item" href="<?= base_url('preorder/index'); ?>">List Stok</a>
                    <a class="collapse-item" href="<?= base_url('preorder/create'); ?>">Tambah Stok</a>
                    <a class="collapse-item" href="<?= base_url('preorder/metode-pembayaran/index'); ?>">Metode Pembayaran</a>
                    <a class="collapse-item" href="<?= base_url('preorder/transaksi-pre-order/index'); ?>">Transaksi</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Toko -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShop" aria-expanded="true" aria-controls="collapseShop">
                <i class="fas fa-store-alt"></i>
                <span>Toko</span>
            </a>
            <div id="collapseShop" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Menu Toko:</h6>
                    <a class="collapse-item" href="<?= base_url('produk/index'); ?>">Barang</a>
                    <a class="collapse-item" href="<?= base_url('kategori/index'); ?>">Kategori</a>
                    <a class="collapse-item" href="<?= base_url('satuan/index'); ?>">Satuan</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('kasir/index'); ?>">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Kasir</span></a>
        </li>
        <!-- Divider -->
        <!--                         <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShop"
                    aria-expanded="true" aria-controls="collapseShop">
                    <i class="fad fa-fw fa-shopping-cart"></i>
                    <span>Pre Order</span>
                </a>
                <div id="collapseShop" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Pre Order:</h6>
                        <a class="collapse-item" href="<?= base_url('preorder/create'); ?>">Tambah Stok</a>
                        <a class="collapse-item" href="<?= base_url('preorder/view'); ?>">List Stok</a>
                    </div>
                </div>
            </li> -->
        <!-- Divider -->
        <hr class="sidebar-divider">

    <?php endif; ?>

    <?php if (in_groups('user')) : ?>

        <div class="sidebar-heading">
            Pre Order
        </div>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('etalase/index'); ?>">
                <i class="fas fa-fw fa-shopping-basket"></i>
                <span>Etalase</span></a>
        </li>

        <!-- Nav Item - Edit Profile -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('etalase/transaksi'); ?>">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Transaksi</span></a>
        </li>
        <hr class="sidebar-divider">
    <?php endif; ?>

    <div class="sidebar-heading">
        User Profile
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li> -->

    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
                Addons
            </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item active" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li> -->

    <!-- Nav Item - My Profile-->

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/index'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>My Profile</span></a>
    </li>

    <!-- Nav Item - Edit Profile -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Edit Profile</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Log Out -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>