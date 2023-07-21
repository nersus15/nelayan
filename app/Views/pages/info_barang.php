<div class="row mb-4">
    <h1><?= $barang->nama ?></h1>
    <div class="img mt-4">
        <img style="width: 100%;" src="<?= assets_url('img/barang/' . $barang->photo) ?>" alt="Gambar Barang" srcset="">
    </div>
    <hr style="width: 80%; margin-left:auto; margin-right:auto">

    <div class="ml-4 col-sm-12 col-md-6 mt-4">
        <h2>Detail</h2>
        <div class="form-group">
            <label for="">Nama Barang: <b><?= $barang->nama ?></b></label>
        </div>
        <div class="form-group">
            <label for="">Deskripsi Barang: </label>
            <p class="ml-2" style="color: grey;"><?= $barang->deskripsi ?></p>
        </div>
        <div class="form-group">
            <label for="">Harga Barang: <b><?= rupiah_format($barang->harga) . '/' . $barang->satuan ?></b></label>
        </div>
        <div class="form-group">
            <label for="">Terjual/Stok Barang: <b><?= $barang->terjual . '/' . $barang->stok . ' ' . $barang->satuan ?></b></label>
        </div>

    </div>
    <div class="ml-4 col-md-6 col-sm-12 mt-4">
        <h2>Detail Nelayan</h2>
        <div class="form-group">
            <label for="">Nama Nelayan: <b><?= $barang->nama_lengkap ?> - <small>Bergabung sejak <?= $barang->bergabung ?></small></b></label>
        </div>
        <div class="form-group">
            <label for="">Alamat: </label>
            <p class="ml-2" style="color: grey;"><?= (!empty($barang->detail_alamat) ? $barang->detail_alamat . ', ' : '') . $barang->desa . ' Kecamatan ' . $barang->kecamatan ?></p>
        </div>
        <div class="form-group">
            <label for="">No.Hp: <b><?= $barang->hp ?></b></label>
        </div>
    </div>
</div>