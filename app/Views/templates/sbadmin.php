<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $dataHeader['title'] ?? 'Dashboard' ?> - SI Nelayan</title>
    <link href="<?= assets_url('vendor/sbadmin/css/styles.css') ?>" rel="stylesheet" />
    <link href="<?= assets_url('css/main.css') ?>" rel="stylesheet" />
    <link  href="<?= assets_url('vendor/fontawesome/css/all.css') ?>" rel="stylesheet" />
    <script src="<?= assets_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script>var basepath = "<?= base_url() ?>"</script>
    <?php 
        if(!isset($dataHeader)) $dataHeader = [];
        if(!isset($dataFooter)) $dataFooter = [];
        if(!isset($activeMenu)) $activeMenu = '';

        if(c_isset($dataHeader, 'extra_css')){
            if(is_array($dataHeader['extra_css'])){
                foreach($dataHeader['extra_css'] as $css){                        
                    echo '<link rel="stylesheet" href="'. assets_url($css) .'"></link>';
                }
            }else{
                echo '<link rel="stylesheet" href="'. assets_url($dataHeader['extra_js']) .'"></link>';
            }
        }
        if(c_isset($dataHeader, 'extra_js')){
            if(is_array($dataHeader['extra_js'])){
                foreach($dataHeader['extra_js'] as $tipe => $js){                        
                    echo '<script src="'. assets_url($js) .'"></script>';
                }
            }else{
                echo '<script src="'. assets_url($dataHeader['extra_js']) .'"></script>';
            }
        }
    ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?= base_url() ?>">SI Nelayan</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group" style="display: none;">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php 
                    $photo =sessiondata('login', 'photo');
                    echo '<img style="width: 20px;height:20px; border-radius:100%; object-fit: cover" src="' . assets_url('img/profile/' . $photo) . '">'
                ?></a>
                <ul class="dropdown-menu dropdown-menu-end" id="user-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link <?= $activeMenu == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Barang
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url('barang/masuk') ?>">Masuk</a>
                                <a class="nav-link" href="<?= base_url('barang/keluar') ?>">Keluar</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="<?= base_url('nelayan') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-people-arrows"></i></div>
                            Data Nelayan Partner
                        </a>
                       
                        <a class="nav-link" href="<?= base_url('logout') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>
                    <?= sessiondata('login', 'username') ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php 
                        if(isset($contents) && is_array($contents)){
                            foreach($contents as $k => $content){
                                echo $this->setData(array_merge($content['data'], ['idContent' => $k]))->include($content['view'], $content['data']);
                            }
                        }
                    ?>
                </div>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="<?= assets_url('vendor/sbadmin/js/scripts.js') ?>"></script>

    <?php 
        if(c_isset($dataFooter, 'extra_js')){
            if(is_array($dataFooter['extra_js'])){
                foreach($dataFooter['extra_js'] as $tipe => $js){                        
                    echo '<script src="'. assets_url($js) .'"></script>';
                }
            }else{
                echo '<script src="'. assets_url($dataFooter['extra_js']) .'"></script>';
            }
        }
    ?>
</body>

</html>