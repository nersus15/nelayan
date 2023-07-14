<?php
$session = session();
$message = $session->getFlashdata('response');
$data = $session->getFlashdata('registerData');
if (empty($data))
    $data = [
        'username' => null,
        'password' => null,
        'repass' => null,
        'nama' => null,
        'email' => null,
        'hp' => null,
        'desa' => null,
        'kecamatan' => null,        
        'alamat' => null,
    ];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SI Nelayan</title>
    <link href="<?= assets_url('vendor/sbadmin/css/styles.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= assets_url('css/main.css') ?>">
    <script src="<?= assets_url('vendor/bootstrap/js/jquery.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Buat Akun</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?= base_url('register') ?>">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input value="<?= $data['username'] ?>" class="form-control" required id="inputFirstName" maxlength="16" name="username" type="text" placeholder="Username" />
                                                    <label for="inputFirstName">Usernmae <span class="symbol-required"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input value="<?= $data['nama'] ?>" class="form-control" id="inputLastName" name="nama" type="text" placeholder="Nama Lengkap" />
                                                    <label for="inputLastName">Nama Lengkap</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input value="<?= $data['email'] ?>" class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input value="<?= $data['hp'] ?>" required class="form-control" name="hp" id="hp" type="text" maxlength="15" placeholder="Nomor Hp" />
                                            <label for="hp">No. Hp <span class="symbol-required"></span></label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input value="<?= $data['password'] ?>" class="form-control" id="inputPassword" required name="password" type="password" placeholder="Create a password" />
                                                    <label for="inputPassword">Password <span class="symbol-required"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input value="<?= $data['repass'] ?>" class="form-control" id="inputPasswordConfirm" type="password" name="repass" placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Ulangi Password <span class="symbol-required"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select name="kecamatan" id="kecamatan" required class="form-control">
                                                        <option value="">Pilih</option>
                                                        <?php foreach ($kec as $k) : ?>
                                                            <option <?= $data['kecamatan'] == $k['id'] ? 'selected' : '' ?> value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <label for="kecamatan">Kecamatan <span class="symbol-required"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select name="desa" id="desa" required class="form-control">
                                                        <option value="">Pilih</option>
                                                    </select>
                                                    <label for="desa">Desa <span class="symbol-required"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control"><?= $data['alamat'] ?></textarea>
                                            <label for="alamat">Detail Alamat</label>
                                        </div>
                                        <p class="text-danger"><?= $message ?></p>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" >Daftar</button></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">Sudah punya akun ?<a href="<?= base_url('login') ?>">Klik disini</a> untuk login</div>
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
            var dataDesa = <?= json_encode($desa) ?>;
            var desaTerpilih = "<?= $data['desa'] ?>";
            console.log(desaTerpilih);
            $("#kecamatan").change(function() {
                var value = $(this).val();
                if (!value) return;

                $("#desa").empty();
                var kode = value.substr(0, 8);
                console.log(dataDesa, kode);
                // Render Option
                dataDesa[kode].forEach(d => {
                    $("#desa").append('<option value="' + d.id + '">' + d.nama + '</option>');
                });

                setTimeout(function(){
                    $("#desa option[value='" + desaTerpilih + "']").prop('selected', true).parent().trigger('change');
                });
            });

            $("#kecamatan").trigger('change');
        });
    </script>
</body>

</html>