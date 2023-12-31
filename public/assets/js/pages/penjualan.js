$(document).ready(function () {
    function initPenolakan() {
        $(".batalkan-pesanan").off('click');
        $(".batalkan-pesanan").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var formid = 'form-pembatalan';
            var modalid = 'modal-' + formid;

            $("#" + modalid).on('shown.bs.modal', function () {
                $("#info-pembatalan").hide();
                $("#alasan").prop('disabled', false);
                $("#" + formid).find('button[type="submit"]').show();


                $("#" + formid).find('#id-transaksi').val(id);
                $("#" + formid).find('#alasan').val('');

                $("#" + formid).find('button[type="submit"]').click(function (e) {
                    e.preventDefault();
                    var yakin = confirm("Yakin ingin membatalkan pesanan ini?");
                    if (!yakin) return;

                    $("#" + formid).submit();
                });
            });
            $("#" + modalid).on('hidden.bs.modal', function () {
                $("#" + modalid).off('shown.bs.modal');
            });
            $("#" + modalid).modal('show');
        });

        $(".info-pesanan").off('click');
        $(".info-pesanan").click(function () {
            var id = $(this).data('id');
            var formid = 'form-pembatalan';
            var modalid = 'modal-' + formid;

            $("#" + modalid).on('shown.bs.modal', function () {
                $("#info-pembatalan").show();
                $("#alasan").prop('disabled', true);
                $("#" + formid).find('button[type="submit"]').hide();
                $.get(basepath + 'info/' + id, function (res) {
                    $("#alasan").val(res.alasan_batal);
                    $("#_tanggal").val(res.diupdate);
                    $("#_pembatal").val(res.pembatal);
                });
            });
            $("#" + modalid).on('hidden.bs.modal', function () {
                $("#" + modalid).off('shown.bs.modal');
            });
            $("#" + modalid).modal('show');
        });
    }

    $("#track").click(function (e) {
        e.preventDefault();
        var token = $("#token").val();
        if (!token) {
            $(".text-danger").text("Token harus diisi");
            return;
        }
        $(".text-danger").text("");
        $.get(basepath + 'track/' + token, function (res) {
            // Render
            var tbody = $("#tbl-pesanan tbody");
            tbody.empty();
            res.forEach(data => {
                var row = '<tr>';
                var bg;
                if (data.status == 'proses')
                    bg = 'bg-warning';
                else if (data.status == 'siap')
                    bg = 'bg-info';
                else if (data.status == 'selesai')
                    bg = 'bg-success';
                else if (data.status == 'batal')
                    bg = 'bg-danger'

                row += '<td>' + data.nama + '</td>';
                row += '<td>' + data.nama_lengkap + '</td>';
                row += '<td>' + data.username + '</td>';
                row += '<td>' + data.hp + '</td>';
                row += '<td>' + data.alamat_penjual + '</td>';
                row += '<td>' + data.pembeli + '</td>';
                row += '<td>Rp.' + data.harga.toString().rupiahFormat() + '</td>';
                row += '<td>' + data.jumlah + '</td>';
                row += '<td>Rp.' + (parseInt(data.harga) * parseInt(data.jumlah)).toString().rupiahFormat() + '</td>';
                row += '<td><span class="badge '+ bg +'">' + data.status + '</span></td>';

                if (data.status == 'proses') {
                    row += '<td><button data-id="' + data.id + '" class="batalkan-pesanan btn btn-danger">Batalkan</button></td>';
                } else if (data.status == 'batal') {
                    row += '<td><button data-id="' + data.id + '" class="info-pesanan btn btn-info">Info Pembatalan</button></td>';
                } else {
                    row += '<td></td>';
                }
                row += '</tr>'

                tbody.append(row);
            });

            initPenolakan();
        }).fail(function (res) {
            $('.text-danger').html(res.responseJSON.message);
        });
    });
    initPenolakan();
});