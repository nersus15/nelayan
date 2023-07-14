<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Nelayan</title>

    <link rel="stylesheet" href="<?= assets_url('vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets_url('css/custom.card.css') ?>">
    <script src="<?= assets_url('vendor/bootstrap/js/jquery.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= assets_url('vendor/fontawesome/css/all.css') ?>">
    <script src="<?= assets_url('js/utils.js') ?>"></script>
    <style>
        body{
            background-color: #eee;
        }
        .carousel-item {
            height: 100vh;
            background-size: cover;
            background-position: center center;
            /* overflow: hidden; */
        }

        .carousel-item-1 {
            background: linear-gradient(rgb(72, 0, 72, 0.8), rgb(192, 72, 72, 0.8)), url(<?= assets_url('img/banner/img-1.jpg') ?>);
            background-size: cover;

        }

        .carousel-item-2 {
            background: linear-gradient(rgb(72, 0, 72, 0.8), rgb(192, 72, 72, 0.8)), url(<?= assets_url('img/banner/img-2.jpg') ?>);
            background-size: cover;

        }

        .carousel-item-3 {
            background: linear-gradient(rgb(72, 0, 72, 0.8), rgb(192, 72, 72, 0.8)), url(<?= assets_url('img/banner/img-3.jpg') ?>);
            background-size: cover;
        }

        .carousel-item h1 {
            margin: 0;
            color: white;
        }

        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgb(72,0,72,0.8);">
        <a class="navbar-brand" href="<?= base_url() ?>">SI Nelayan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url() ?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a id="nav-item-keranjang" class="nav-link" href="<?= base_url('keranjang') ?>">Keranjang </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('tracking') ?>">Lacak Pesanan</a>
                </li>
                <li class="nav-item">
                    <?php if(!is_login()): ?>
                    <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
                    <?php endif ?>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner text-center">
                <div class="carousel-item active carousel-item-1">
                    <div class="d-flex h-100 align-items-center justify-content-center">
                        <h1>Selamat Datang <br> di </br> Sistem Informasi Hasil Nelayan</h1>
                    </div>
                </div>
                <div class="carousel-item carousel-item-2">
                    <div class="d-flex h-100 align-items-center justify-content-center">
                        <h1>Selamat Datang <br> di </br> Sistem Informasi Hasil Nelayan</h1>
                    </div>
                </div>
                <div class="carousel-item carousel-item-3">
                    <div class="d-flex h-100 align-items-center justify-content-center">
                        <h1>Selamat Datang <br> di </br> Sistem Informasi Hasil Nelayan</h1>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Selanjutnya</span>
            </button>
        </div>
        <div class="container container-lg mt-4">
            <h3>Hasil Nelayan Hari Ini</h3>
            <hr>
            <div class="row">
                <?php foreach ($barang as $b) :?>
                <?php 
                 $b = (array) $b;
                 $textAlamat = '';

                 if(!empty($b['detail_alamat'])){
                    $textAlamat .= $b['detail_alamat'] . ', ';
                 }
                 $desa = empty($b['desa']) ? '' : ('Desa ' . $b['desa'] . ', ');
                 $kecamatan = empty($b['kecamatan']) ? '' : ('Kecamatan ' . $b['kecamatan']);

                 $textAlamat .= $desa . $kecamatan;
                ?>
                    <div class="col-sm-6 col-md-3 mt-2 mb-2">
                        <div class="card">
                            <div class="image-container">
                                <div class="first">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="discount"><?= $b['stok'] - $b['terjual'] > 0 ? 'Tersedia' : 'Habis' ?></span>
                                        <span class="wishlist">
                                           <?= $b['pemilik'] ?>
                                        </span>
                                    </div>
                                </div>
                                <img width="100%" src="<?=assets_url('img/barang/'. (  !empty($b['photo']) ? $b['photo'] : 'contoh.jpg')) ?>" class="img-fluid rounded thumbnail-image">
                            </div>
                            <div class="product-detail-container p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="dress-name"><?= $b['nama'] ?></h5>
                                    <div class="d-flex flex-column mb-2">
                                        <span class="new-price"><?= rupiah_format($b['harga']) ?></span>
                                        <small class="old-price text-right">/ <?= $b['satuan'] ?></small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-1">
                                    <p><?= $b['deskripsi'] ?></p>  
                                </div>
                                <div class="col-sm-12 m-0">
                                    <p style="color: grey;"><?= $textAlamat ?></p>  

                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-1">
                                    <div>
                                        <i class="fa fa-star-o rating-star"></i>
                                        <span class="rating-number"><?= $b['terjual'] .'/' . $b['stok'] ?></span>
                                    </div>
                                    <div class="buy">
                                        <span data-id="<?= $b['id'] ?>" class="btn-custom btn-tambah-belanja"><i class="fas fa-plus"></i></span>
                                        <input data-hp="<?= $b['hp'] ?>" data-username="<?= $b['pemilik'] ?>" data-nama="<?= $b['nama'] ?>" data-namalengkap="<?= $b['nama_lengkap'] ?>" data-alamat="<?= $textAlamat ?>" type="number" data-harga="<?= $b['harga'] ?>" class="jml-belanja" min="0" max="<?= $b['stok'] - $b['terjual'] ?>" name="jml-belanja" id="<?= $b['id'] ?>" >
                                        <span data-id="<?= $b['id'] ?>"  class="btn-custom btn-kurangi-belanja"><i class="fas fa-minus"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </main>
    <script src="<?= assets_url('js/custom_card.js') ?>"></script>

</body>

</html>