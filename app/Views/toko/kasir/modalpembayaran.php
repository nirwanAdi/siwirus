<!-- Modal -->
<script src="<?= base_url('vendor/autoNumeric.js') ?>"></script>
<div class="modal fade" id="modalpembayaran" tabindex="-1" aria-labelledby="modalpembayaranLabel" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalpembayaranLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('kasir/simpanPembayaran', ['class' => 'frmpembayaran']); ?>
            <div class="modal-body">
                <input type="hidden" name="nofaktur" value="<?= $nofaktur; ?>">
                <input type="hidden" name="kopeng" value="<?= $kopeng; ?>">
                <input type="hidden" name="totalkotor" id="totalkotor" value="<?= $totalbayar; ?>">
                <div class="form-group">
                    <label for="">Total Pembayaran</label>
                    <input type="text" class="form-control form-control-lg" name="totalbersih" id="totalbersih" value="<?= $totalbayar; ?>" style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" readonly>
                </div>
                <div class="form-group">
                    <label for="">Jumlah Uang</label>
                    <input type="text" class="form-control" name="jmluang" id="jmluang" style="text-align: right; color:red; font-weight : bold; font-size:25pt;" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Kembalian</label>
                    <input type="text" class="form-control" name="sisauang" id="sisauang" style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success tombolSimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        $('#totalbersih').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('#jmluang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('#sisauang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('#jmluang').keyup(function(e) {
            hitungSisaUang();
        })
        $('.frmpembayaran').submit(function(e) {
            e.preventDefault();

            let jmluang = ($('#jmluang').val() == "") ? 0 : $('#jmluang').autoNumeric('get');
            let sisauang = ($('#sisauang').val() == "") ? 0 : $('#sisauang').autoNumeric('get');

            if (parseFloat(jmluang) == 0 || parseFloat(jmluang) == "") {
                Toast.fire({
                    icon: 'warning',
                    title: 'Jumlah uang belum diinput'
                })
            } else if (parseFloat(sisauang) < 0) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Kembalian minus'
                })
            } else {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                        $('.tombolSimpan').prop('disabled', true);
                    },
                    complete: function() {
                        $('.tombolSimpan').html('Simpan');
                        $('.tombolSimpan').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!!',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }

            returnfalse
        })
    })

    function hitungSisaUang() {
        let totalpembayaran = $('#totalbersih').autoNumeric('get');
        let jumlahuang = ($('#jmluang').val() == "") ? 0 : $('#jmluang').autoNumeric('get');

        sisauang = parseFloat(jumlahuang) - parseFloat(totalpembayaran);

        $('#sisauang').val(sisauang);

        let sisauangx = $('#sisauang').val();
        $('#sisauang').autoNumeric('set', sisauangx);
    }
</script>