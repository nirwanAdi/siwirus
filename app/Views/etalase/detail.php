<?= $this->extend('templetes/index'); ?>
<?= $this->section('page-content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3" style="max-height: 300px;">
                    <div class="row no-gutters mt-2 ml-2 mr-2 mb-1">
                        <div class="col-md-4">
                            <img src="<?= base_url('/img/pre_order/barang/'.$transaksi_preorder->gambar_barang); ?>" class="card-img" style="max-width:200px ; max-heigth:200px">
                        </div>
                        <div class="col-md-8" style="line-height: 1;">
                        <div class="card-body">
                            <h5 class="card-title"><big><b><?= $transaksi_preorder->username; ?></b></big></h5>
                            <div class="row">
                                <div class="col-md-6" style="line-height: 1;">
                                    <p class="card-text">Barang yang dibeli : <?= $transaksi_preorder->nama_barang; ?></p>
                                    <p class="card-text">Harga barang : <?= "Rp.". number_format($transaksi_preorder->harga,2,',','.'); ?></p>
                                    <p class="card-text">Jumlah barang : <?= $transaksi_preorder->jumlah; ?></p>
                                    <p class="card-text">Total Harga : <?= "Rp.". number_format($transaksi_preorder->total_harga,2,',','.'); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text">Metode Pembayaran : <?= $transaksi_preorder->nama_bank; ?></p>
                                    <?php if($transaksi_preorder->statustransaksi==0) :?>
                                        <big><span class="badge badge-danger">Bukti pembayaran belum di Upload</span></big> 
                                    <?php elseif($transaksi_preorder->statustransaksi==1) : ?>
                                        <big><span class="badge badge-warning text-dark">Pembayaran belum dikonfirmasi</span></big> 
                                    <?php elseif($transaksi_preorder->statustransaksi==2) : ?>
                                        <big><span class="badge badge-success">Pembayaran berhasil</span></big> 
                                    <?php elseif($transaksi_preorder->statustransaksi==3) : ?>
                                        <big><span class="badge badge-danger">Pembayaran ditolak</span></big> 
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                            <?php if($transaksi_preorder->statustransaksi==0)  :?>
                            <p class="mt-2 mb-1">Silahkan lakukan pembayaran ke nomor rekening <?= $transaksi_preorder->no_rekening; ?> /an dan upload bukti pembayaran ke tempat yang telah disediakan</p>
                            <?php endif; ?>
                            <small><a href="<?= base_url('/etalase/transaksi'); ?>">&laquo; Kembali ke halaman User List</a></small>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="max-height: 400px;">
                    <div class="row no-gutters m-2">
                        <?php if($transaksi_preorder->statustransaksi==0): ?>
                            <form action="/etalase/upload_bukti_pembayaran/<?= $transaksi_preorder->transaksiid; ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                                <div class="form-group row">
                                    <div class="col-md-5">
                                            <img src="<?= base_url('img/pre_order/barang/default.png'); ?>" class="img-thumbnail img-preview" style="width:200px ; heigth:200px; max-width:200px; max-height:200px">
                                    </div>
                                    <div class="col-md-7">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_bukti_pembayaran'))? 'is-invalid' : '' ; ?>" id="gambar_bukti_pembayaran" name="gambar_bukti_pembayaran" onchange="previewImgBuktiPembayaran()">
                                        <label class="custom-file-label" for="gambar_bukti_pembayaran">Upload Bukti Pembayaran</label>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('gambar_bukti_pembayaran'); ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        <?php else : ?>
                        <div class="col-md-4">
                            <img src="<?= base_url('/img/pre_order/bukti_pembayaran/'.$transaksi_preorder->gambar_bukti_pembayaran); ?>" class="card-img" style="width:300px ; heigth:300px; max-width:300px; max-height:300px">
                        </div>
                        <div class="col-md-8">
                            <?php if($transaksi_preorder->statustransaksi==1) : ?>
                                <div class="alert alert-success">
                                    Bukti pembayaran berhasil di upload. Menunggu konfirmasi.
                                </div>
                            <?php elseif($transaksi_preorder->statustransaksi==2) : ?>
                                <div class="alert alert-success">
                                    Pembayaran telah di konfirmasi harap tunjukan ini ke pengurus ketika melakukan pengkuran atau pengambilan barang
                                </div>
                            <?php elseif($transaksi_preorder->statustransaksi==3) : ?>
                                <div class="alert alert-danger">
                                    Pembayaran ditolak. Ingin tetap lanjutkan pemesanan?
                                </div>
                                <form action="/etalase/lanjutkan_pemesanan/<?= $transaksi_preorder->transaksiid; ?>" method="post" class="d-inline mb-1">
                                    <button type="submit" class="btn btn-success" style="width:200px">Lanjutkan Pemesanan</button>
                                </form>
                                <form action="/etalase/<?= $transaksi_preorder->transaksiid; ?>" method="post" class="mt-2">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger" style="width:200px">Batalkan Pemesanan</button>
                                </form>
                            <?php endif; ?>
                        </div> 
                        <?php endif ; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function previewImgBuktiPembayaran(){
    const gambarBuktiPembayaran = document.querySelector('#gambar_bukti_pembayaran');
    const gambarBuktiPembayaranLabel = document.querySelector('.custom-file-label');
    const imgPreview = document.querySelector('.img-preview');

    gambarBuktiPembayaranLabel.textContent = gambar_bukti_pembayaran.files[0].name;

    const fileGambarBuktiPembayaran = new FileReader();
    fileGambarBuktiPembayaran.readAsDataURL(gambar_bukti_pembayaran.files[0]);
    fileGambarBuktiPembayaran.onload = function(e){
        imgPreview.src = e.target.result;
    }
}
</script>
<?= $this->endSection(); ?>
