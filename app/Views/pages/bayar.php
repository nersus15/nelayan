<?php
$session = session();
$message = $session->getFlashdata('response');
$jenis = $session->getFlashdata('jenis');
$data = $session->getFlashdata('loginData');
if (empty($data))
    $data = ['nama' => null, 'alamat' => null, 'hp' => null, 'kecamatan' => null, 'desa' => null, 'detailAlamat' => null];
if (!empty($user)) {
    $data = [
        'nama' => $user['username'],
        'alamat' => $user['alamat'],
        'hp' => $user['hp'],
        'kecamatan' => level_wilayah($user['alamat']) == 3 ? $user['alamat'] : (substr($user['alamat'], 0, 8) . '.0000'),
        'desa' => level_wilayah($user['alamat']) == 4 ? $user['alamat'] : '',
        'detailAlamat' => $user['detail_alamat']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pembayaran - SI Nelayan</title>
    <link href="<?= assets_url('vendor/sbadmin/css/styles.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= assets_url('vendor/dropzone/basic.css') ?>">
    <link rel="stylesheet" href="<?= assets_url('vendor/dropzone/dropzone.css') ?>">
    <link rel="stylesheet" href="<?= assets_url('css/main.css') ?>">
    <script src="<?= assets_url('js/utils.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/jquery.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/dropzone/dropzone.js') ?>"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Pembayaran</h3>
                                    <?php if (!empty($pesan)) : ?>
                                        <p><?= $pesan ?></p>
                                    <?php endif ?>
                                </div>
                                <div style="overflow-x: scroll;" class="card-body" id="form-wrapper">
                                    <?php if (!empty($pesan) && !$sudahBayar) : ?>
                                        <form action="<?= base_url('bayar') ?>" method="post">
                                            <p class="text-danger"><?= $message ?></p>
                                            <div class="form-group">
                                                <label for="">Token</label>
                                                <input type="text" name="" id="token" class="form-control">
                                            </div>
                                        </form>
                                    <?php elseif (!$sudahBayar) : ?>
                                        <p>Silahkan lakukan pembayaran ke salah satu rekening berikut:</p>
                                        <ol>
                                            <?php foreach ($rekening as $r) : ?>
                                                <li><?= $r['type'] ?>: <b><?= $r['number'] ?></b> Atas Nama <b><?= $r['name'] ?></b></li>
                                            <?php endforeach ?>
                                        </ol>

                                        <p>Jika sudah melakukan pembayaran, silahkan upload bukti pembayarannya di form berikut:</p>
                                        <script>
                                            Dropzone.options.buktiBayar = {
                                                maxFilesize: 4000,
                                                paramName: 'photo',
                                                acceptedFiles: 'image/*',
                                                // previewsContainer: '.dz-preview',
                                                headers: {
                                                    'jenis-gambar': 'bukti_bayar',
                                                    'force-name': '<?= $token ?>',
                                                },
                                                success: function(file, res) {
                                                    $(file.previewElement).find('.dz-success-mark').css('opacity', 1);
                                                    $("#photo").val(res.new);
                                                    $('.dropzone').unbind('click');
                                                    $('.dropzone').unbind('drag');
                                                },
                                                error: function(file, res) {
                                                    $(file.previewElement).find('.dz-error-message').css('opacity', 1).text(res.message).show();
                                                    $(file.previewElement).find('.dz-error-mark').css('opacity', 1);
                                                }
                                            }
                                        </script>
                                        <div class="dropzone" id="bukti-bayar" action="<?= base_url('upload/gambar') ?>">

                                        </div>
                                    <?php endif ?>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="<?= base_url() ?>">Kembali</a>
                                        <button class="btn btn-primary" type="button" id="redirect">Bayar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <script src="<?= assets_url('vendor/sbadmin/js/scripts.js') ?>"></script>
    <script>
        $(document).ready(function() {
            var path = '<?= base_url() ?>';
            var sudahBayar = <?= $sudahBayar ? 'true' : 'false' ?>;
            var pesan = "<?= $pesan ?>";
            var token = '<?= $token ?>';
            $("#redirect").click(function() {
                location.href = path + 'bayar/' + (pesan && !sudahBayar ? $("#token").val() : token);
            });
        });
    </script>
</body>

</html>