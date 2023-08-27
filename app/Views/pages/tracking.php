<?php
$session = session();
$message = $session->getFlashdata('response');
$token = $session->getFlashdata('token');
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
    <title>Keranjang - SI Nelayan</title>
    <link href="<?= assets_url('vendor/sbadmin/css/styles.css') ?>" rel="stylesheet" />
    <link href="<?= assets_url('vendor/lightbox/lightbox.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= assets_url('css/main.css') ?>">
    <script src="<?= assets_url('js/utils.js') ?>"></script>
    <script src="<?= assets_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/lightbox/lightbox.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>var basepath = "<?= base_url() ?>";</script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-lg-10">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Traking Status Pesanan Anda</h3>
                                </div>
                                <div style="overflow-x: scroll;" class="card-body">
                                    <form id="form-tracking" action="">
                                        <div class="form-group mb-3">
                                            <label for="inputEmail">Token <span class="symbol-required"></span></label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Token pesanan anda" id="token" required name="token" aria-describedby="track">
                                                <div class="input-group-append">
                                                    <span style="cursor: pointer;" class="input-group-text" id="track">Cari</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-danger"><?= $message ?></p>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                                        <a class="small" href="<?= base_url() ?>">Kembali</a>

                                        </div>
                                    </form>
                                    <table id="tbl-pesanan" class="table">
                                        <thead>
                                            <tr>
                                                <th>Bukti Bayar</th>
                                                <th>Bukt Refund</th>
                                                <th>Barang</th>
                                                <th>Pemilik</th>
                                                <!-- <th>Username</th> -->
                                                <th>No.Hp</th>
                                                <th>Alamat Penjual</th>
                                                <th>Nama Pembeli</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>SubTotal</th>
                                                <th>Ongkir</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?= $this->setData(['pembatal' => 'pembeli'])->include('pages/form_pembatalan'); ?>
    </div>
    <script src="<?= assets_url('js/pages/penjualan.js') ?>"></script>
    <script src="<?= assets_url('vendor/sbadmin/js/scripts.js') ?>"></script>
</body>

</html>