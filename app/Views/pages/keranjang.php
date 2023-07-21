<?php
$session = session();
$message = $session->getFlashdata('response');
$token = $session->getFlashdata('token');
$data = $session->getFlashdata('loginData');
if (empty($data))
    $data = ['nama' => null, 'alamat' => null, 'hp' => null, 'kecamatan' => null, 'desa' => null, 'detailAlamat' => null];
if (!empty($user)){
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
    <link rel="stylesheet" href="<?= assets_url('css/main.css') ?>">
    <script src="<?= assets_url('js/utils.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/jquery.min.js') ?>"></script>
    <script src="<?= assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
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
                                    <h3 class="text-center font-weight-light my-4">Keranjang</h3>
                                    <p id="token"></p>
                                </div>
                                <div style="overflow-x: scroll;" class="card-body">
                                    <form action="<?= base_url('pesan') ?>" method="post">
                                        <div class="form-floating mb-3">
                                            <input required value="<?= $data['nama'] ?>" class="form-control" name="nama" id="inputEmail" type="text" />
                                            <label for="inputEmail">Nama <span class="symbol-required"></span></label>
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
                                            <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control"><?= $data['detailAlamat'] ?></textarea>
                                            <label for="alamat">Detail Alamat</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input required value="<?= $data['hp'] ?>" class="form-control" name="hp" id="inputEmail" type="text" />
                                            <label for="inputEmail">Hp <span class="symbol-required"></span></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <table id="tbl-keranjang" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Barang</th>
                                                        <th>Hasil Tangkapan Nelayan</th>
                                                        <th>No.Hp</th>
                                                        <th>Alamat</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>SubTotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <p class="text-danger"><?= $message ?></p>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="<?= base_url() ?>">Kembali</a>
                                            <button class="btn btn-primary" type="submit">Pesan</button>
                                        </div>
                                    </form>
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
        $(document).ready(function(){
            var dataDesa = <?= json_encode($desa) ?>;
            var desaTerpilih = "<?= $data['desa'] ?>";
            var token = "<?= $token ?>";
            if(token){
                // Hapus data pesanan karena sudah checkout, tampilkan Token pesanan
                $("#token").html('Token: ' + token + '<span>(Copy dan simpan token untuk melacak pesanan)</span>');
                localStorage.removeItem('belanjaan_nelayan');

            }
            $("#kecamatan").change(function() {
                var value = $(this).val();
                if (!value) return;

                $("#desa").empty();
                var kode = value.substr(0, 8);
                // Render Option
                dataDesa[kode].forEach(d => {
                    $("#desa").append('<option value="' + d.id + '">' + d.nama + '</option>');
                });

                setTimeout(function(){
                    $("#desa option[value='" + desaTerpilih + "']").prop('selected', true).parent().trigger('change');
                });
            });

            $("#kecamatan").trigger('change');

            // Load Keranjang
            var dataPesanan = localStorage.getItem('belanjaan_nelayan');
            var table = $('#tbl-keranjang');
            var form = $("form");
            var tbody = table.find('tbody');
            if(!dataPesanan){
                if(token)
                    tbody.append('<tr><td style="text-align:center" colspan=7>Anda sudah melakukan checkout / pemesanan</td></tr>');
                else
                    tbody.append('<tr><td style="text-align:center" colspan=7>Keranjang Masih Kosong</td></tr>');
            }else{
                dataPesanan = JSON.parse(dataPesanan);
                var total = 0;
                dataPesanan.forEach(pesanan => {
                    if(pesanan.jumlah < 1) return;
                    total += parseInt(pesanan.harga) * parseInt(pesanan.jumlah);
                    form.append("<input name='barang[]' value='"+ pesanan.id +"' type='hidden' />");
                    form.append("<input name='jumlah[]' value='"+ pesanan.jumlah +"' type='hidden' />");

                    row = '<tr>';
                    row += '<td>' + pesanan.nama + '</td>';
                    row += '<td>' + pesanan.nama_pemilik + '</td>';
                    row += '<td>' + pesanan.hp + '</td>';
                    row += '<td>' + pesanan.alamat + '</td>';
                    row += '<td>Rp. ' + pesanan.harga.toString().rupiahFormat() + '</td>';
                    row += '<td>' + pesanan.jumlah + '</td>';
                    row += '<td>Rp. ' + pesanan.total + '</td></tr>';

                    tbody.append(row);
                });
                tbody.append('<tr><td style="text-align:center" colspan="7"><b>Total: Rp. ' + total.toString().rupiahFormat() + '</b></td></tr>')
            }

        });
    </script>
</body>

</html>