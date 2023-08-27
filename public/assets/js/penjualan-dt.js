function (row) {
    $(row).find(".batalkan-pesanan").click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var formid = 'form-pembatalan';
        var modalid = 'modal-' + formid;
    
        $("#" + modalid).on('shown.bs.modal', function () {
            $("#info-pembatalan").hide();
            $("#alasan").prop('disabled', false);
            $("#" + formid).find('button[type="submit"]').show();
            $("#image-wrapper").show();
            Dropzone.options.refund.headers['force-name'] = id;
    
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
    
    $(row).find(".info-pesanan").click(function () {
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
            $("#image-wrapper").hide();
    
        });
        $("#" + modalid).on('hidden.bs.modal', function () {
            $("#" + modalid).off('shown.bs.modal');
        });
        $("#" + modalid).modal('show');
    });
    
    $(row).find(".btn-terima").click(function(e){{
        e.preventDefault();          
        var Ongkir = null;
        var jenis = $(this).data('jenis');
        var href = $(this).attr('href');
    
        if(jenis == 'cod'){
            Ongkir = prompt('Masukkan ongkir');
            if(Ongkir == null)
                return;
        }
        location.href = href + (Ongkir ? '_' +  Ongkir : '');
    }});
}