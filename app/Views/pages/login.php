<?php
    $session = session();
    $message = $session->getFlashdata('response');
    $data = $session->getFlashdata('loginData');
    if(empty($data))
        $data = ['user' => null, 'password' => null];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SI Nelayan</title>
    <link href="<?= assets_url('vendor/sbadmin/css/styles.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= assets_url('css/main.css') ?>">
    <script src="<?= assets_url('vendor/bootstrap/js/jquery.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <style>
      .main-bg{
        background: url('<?= assets_url("img/banner/img-2.jpg")?>'); 
        background-repeat: no-repeat;
        background-size: cover;
    </style>

<body class=" main-bg"> <!-- Ganti background disini, bisa menggunakan class (bootstrap), atau style (manual) -->

    
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div  class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                               
                                <div class="card-body">
                                    <form action="<?= base_url('login') ?>" method="post">
                                        <div class="form-floating mb-3">
                                            <input required value="<?= $data['user'] ?>" class="form-control" name="user" id="inputEmail" type="text" />
                                            <label for="inputEmail">Username / Hp <span class="symbol-required"></span></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input required class="form-control" value="<?= $data['password'] ?>" name="password" id="inputPassword" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password <span class="symbol-required"></span></label>
                                        </div>
                                         <p class="text-danger"><?= $message ?></p>   
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html"></a>
                                           <button class="btn btn-primary" type="submit">Login</button>
                                        </div>
                                    </form>
                                    <div class="login100-more" > 
                                    </div>
                                </div>
                               
                                <div class="card-footer text-center py-3">
                                    <!-- <div class="small">Belum punya akun ?<a href="<?php // echo base_url('register') ?>">Klik disini</a> untuk mendaftar</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
    <script src="<?= assets_url('vendor/sbadmin/js/scripts.js') ?>"></script>

</body>
    


</html>