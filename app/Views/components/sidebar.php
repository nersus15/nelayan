<?php
    if(isset($sidebarOpt) && is_array($sidebarOpt) && !empty($sidebarOpt)) extract($sidebarOpt);

if (!isset($activeMenu))
  $activeMenu = '';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?= assets_url('vendor/adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Pelayanan Posyandu</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= assets_url('img/profile/' . sessiondata('login', 'photo', 'default.jpg')) ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url('profile') ?>" class="d-block"><?= sessiondata("login", "nama_lengkap") ?? sessiondata("login", "username", 'No Login') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $activeMenu == 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt text-info"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?= in_array($activeMenu, ['bayi05', 'bayi611', 'bayi1223', 'bayi2459']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= in_array($activeMenu, ['bayi05', 'bayi611', 'bayi1223', 'bayi2459']) ? 'actaive' : '' ?>">
            <i class="nav-icon far fa-peoples"></i>
            <p>
              Data Bayi/Balita
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-3">
            <li class="nav-item">
              <a href="<?= base_url('anak/list/05') ?>" class="nav-link <?= $activeMenu == 'bayi05' ? 'active' : '' ?>">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <p>Umur 0-5 bulan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('anak/list/611') ?>" class="nav-link <?= $activeMenu == 'bayi611' ? 'active' : '' ?>">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <p>Umur 6-11 bulan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('anak/list/1223') ?>" class="nav-link <?= $activeMenu == 'bayi1223' ? 'active' : '' ?>">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <p>Umur 12-23 bulan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('anak/list/2459') ?>" class="nav-link <?= $activeMenu == 'bayi2459' ? 'active' : '' ?>">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <p>Umur 24-59 bulan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('bumil') ?>" class="nav-link <?= $activeMenu == 'bumil' ? 'active' : '' ?>">
            <!-- <i class="nav-icon far fa-circle text-info"></i> -->
            <p>Data Ibu Hamil</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('lansia') ?>" class="nav-link <?= $activeMenu == 'lansia' ? 'active' : '' ?>">
            <!-- <i class="nav-icon far fa-circle text-info"></i> -->
            <p>Data Lansia</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('kader') ?>" class="nav-link <?= $activeMenu == 'kader' ? 'active' : '' ?>">
            <!-- <i class="nav-icon far fa-circle text-info"></i> -->
            <p>Data Kader</p>
          </a>
        </li>
        <li class="nav-header">Akun</li>
        <li class="nav-item">
          <a href="<?= base_url('ws/user/logout') ?>" class="nav-link">
            <p>Log Out</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>