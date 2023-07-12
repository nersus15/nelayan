$(document).ready(function () {
    $(".btn-tambah-belanja").click(function () {
        var id = $(this).data('id');
        belanjaanHandler(id, 'tambah');
    });

    $(".btn-kurangi-belanja").click(function () {
        var id = $(this).data('id');
        belanjaanHandler(id,'kurang');
    });

    function loadBelanjaan(){
        var data = localStorage.getItem('belanjaan_nelayan');
        if (data)
            data = JSON.parse(data);
        else
            return;

        data.forEach(barang => {
            $("#" + barang.id).val(barang.jumlah);
        });
         // Hitung Barang Belanjaan
         var barangBelanja = data.filter(arr => arr.jumlah > 0);
         $("#nav-item-keranjang").html('Kernajang<span class="badge badge-danger">'+ barangBelanja.length +'</span>');
    }
    function belanjaanHandler(id, operasi = 'tambah') {
        var data = localStorage.getItem('belanjaan_nelayan');
        var input = $('#' + id);
        var oldVal = input.val();
        var max = input.attr('max');
        var newVal = null;
        var harga = input.data('harga');
        var nama = input.data('nama');
        
        if (!oldVal) oldVal = 0;

        if (data)
            data = JSON.parse(data);
        else
            data = [];
        if (operasi == 'tambah') {
            if (oldVal < max)
                input.val(parseInt(oldVal) + 1);
            else {
                alert("Hanya bisa membeli maksimal sebanyak 3 ");
                return;
            }


            newVal = parseInt(oldVal) + 1;
        } else {
            if (oldVal > 0)
                input.val(parseInt(oldVal) - 1);
            else
                return;

            newVal = parseInt(oldVal) - 1;
        }

        var newData = {
            id: id,
            nama: nama,
            jumlah: newVal,
            harga: harga,
            total: (harga * newVal).toString().rupiahFormat()
        }
        if (data.length == 0) {
            data.push(newData);
        } else {
            var barangIni = {};
            for (let i = 0; i < data.length; i++) {
                if (data[i].id == id) {
                    barangIni['index'] = i;
                    barangIni['data'] = data[i];
                    break;
                }
            }
            if (Object.keys(barangIni).length > 0) {
                data.splice(barangIni.index, 1);
            }
            data.push(newData);
        }
        localStorage.setItem('belanjaan_nelayan', JSON.stringify(data));

        // Hitung Barang Belanjaan
        var barangBelanja = data.filter(arr => arr.jumlah > 0);
        $("#nav-item-keranjang").html('Keranjang<span class="badge badge-danger">'+ barangBelanja.length +'</span>');
    }

    loadBelanjaan();
});