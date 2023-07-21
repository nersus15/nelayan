<?php
$session = session();
$response = $session->getFlashdata('response');
$postData = $session->getFlashdata('tambahData');

if (!isset($dataBarang)) {
    $dataBarang = [
        'nama' => null,
        'desc' => null,
        'stok' => 0,
        'harga' => 0,
        'satuan' => 'ekor',
    ];
}
if (!empty($postData))
    $dataBarang = array_merge($dataBarang, $postData);

?>
<div class="card mt-4">
    <div class="card-header">
        <h2 class="card-title"><?= $mode == 'baru' ? 'Tambah' : 'Update' ?> Data Barang</h2>
        <p class="card-subtitle"><?= $desc ?></p>
    </div>
    <form enctype="multipart/form-data" action="<?= base_url('barang/tambah') ?>" method="post">
        <input type="hidden" name="id" value="<?= $dataBarang['id'] ?? null ?>">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="">Nelayan <span class="symbol-required"></span></label>
                    <select required class="form-control" name="nelayan" id="nelayan">
                        <option value="">Pilih Nelayan</option>
                        <?php foreach($nelayan as $n) :?>
                            <option <?= isset($dataBarang['nelayan']) && $dataBarang['nelayan'] == $n['id'] ? 'selected' : '' ?> value="<?= $n['id'] ?>"><?= $n['nama_lengkap'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="">Nama Barang <span class="symbol-required"></span></label>
                    <input maxlength="46" required type="text" name="nama" value="<?= $dataBarang['nama'] ?>" id="nama" class="form-control">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="">Stok <span class="symbol-required"></span></label>
                    <input type="number" required min="1" name="stok" value="<?= $dataBarang['stok'] ?>" id="stok" class="form-control">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="">Harga <span class="symbol-required"></span></label>
                    <input type="text" required name="harga" value="<?= $dataBarang['harga'] ?>" id="harga" class="form-control">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="">Satuan <span class="symbol-required"></span></label>
                    <select name="satuan" id="satuan" class="form-control">
                        <option <?= $dataBarang['satuan'] == 'ekor' ? 'selected' : '' ?> value="ekor">Ekor</option>
                        <option <?= $dataBarang['satuan'] == 'kilo' ? 'selected' : '' ?> value="kilo">Kilo (Kg)</option>
                        <option <?= $dataBarang['satuan'] == 'bak' ? 'selected' : '' ?> value="bak">Bak</option>
                        <option <?= $dataBarang['satuan'] == 'ember' ? 'selected' : '' ?> value="ember">Ember</option>
                    </select>
                </div>
                <div class="form-group col-sm-12">
                    <label for="">Deskripsi</label>
                    <textarea class="form-control" name="desc" maxlength="100" id="desc" cols="30" rows="5"><?= c_isset($dataBarang, 'desc') ? $dataBarang['desc'] : (c_isset($dataBarang, 'deskripsi') ? $dataBarang['deskripsi'] : null) ?></textarea>
                </div>
                <div class="form-group  col-sm-12">
                    <label for="">Gambar</label>
                    <input type="hidden" name="photo" id="photo">
                    <script>
                        Dropzone.options.gambarBarang = {
                            maxFilesize: 4000,
                            paramName: 'photo',
                            acceptedFiles: 'image/*',
                            // previewsContainer: '.dz-preview',
                            headers: {
                                'jenis-gambar': 'barang'
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
                    <div class="dropzone" id="gambar-barang" action="<?= base_url('upload/gambar') ?>">
                        <!-- <input accept=".jpg, .jpeg, .png" class="file-styled " type="file" id="photo" name="photo"> -->

                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div style="float: right;" class="my-2">
                <a class="btn btn-danger" href="<?= base_url('barang') ?>" type="reset">Batal</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        Inputmask.extendAliases({
            'numeric': {
                "prefix": "Rp. ",
                "digits": 0,
                "digitsOptional": false,
                "decimalProtect": true,
                "groupSeparator": ".",
                "radixPoint": ",",
                "radixFocus": true,
                "autoGroup": true,
                "autoUnmask": true,
                "removeMaskOnSubmit": true
            }
        });

        Inputmask.extendAliases({
            'IDR': {
                alias: "numeric", //it inherits all the properties of numeric    
                // "prefix": "Rpoverrided" //overrided the prefix property   
            }
        });
        $("#harga").inputmask('IDR')
    });
</script>