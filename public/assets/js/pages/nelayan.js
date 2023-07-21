function (row, data, dataIndex) {
    $(row).find(".hapus-nelayan").click(function (e) {
        e.preventDefault();
        var yakin = confirm("Apakah yakin akan menghapus data?");
        if (!yakin) return;
        location.href = $(this).attr('href');
    });

    $(row).find('.update-nelayan').click(function (e) {
        var modalId = '#modal-form-nelayan';
        var form = $('#form-nelayan');
        var id = $(this).data('id')
        $(modalId).on('shown.bs.modal', async function () {
            form.find('input, textarea').val('');
                var data = await $.post(basepath + 'nelayan/data/' + id).then(res => res);
                form.find('#id').val(data.id);
                form.find('#nama').val(data.nama_lengkap);
                form.find('#hp').val(data.hp);
                form.find('#detail_alamat').val(data.detail_alamat);
                form.find('#id').val(data.id);
                if (data.alamat) {
                    console.log(data.alamat);
                    $("#kecamatan option[value='" + (data.alamat.substr(0, 8) + ".0000']")).prop('selected', true).parent().trigger('change');
                    setTimeout(function () {
                        $("#desa option[value='" + data.alamat + "']").trigger('change').prop('selected', true).parent().trigger('change');
                    }, 300)
                }
            
        });
        $(modalId).modal('show');
        $(modalId).off('shown.bs.modal');

        $("#kecamatan").trigger('change')
    });
}