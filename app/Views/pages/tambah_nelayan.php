<div class="modal" id="modal-form-nelayan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Nelayan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-nelayan" action="<?= base_url('nelayan/save') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="">Nama Lengkap <span class="symbol-required"></span></label>
                            <input name="nama" type="text" required maxlength="46" class="form-control" id="nama">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">No. Hp <span class="symbol-required"></span></label>
                            <input type="text" required maxlength="15" name="hp" class="form-control" id="hp">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Kecamatan <span class="symbol-required"></span></label>
                            <select required name="kecamatan" id="kecamatan" class="form-control">
                                <?php foreach ($wilayah['kecamatan'] as $id => $kec) : ?>
                                    <option value="<?= $id ?>"><?= $kec ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">Desa</label>
                            <select name="desa" id="desa" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Detail Alamat</label>
                            <textarea name="detail_alamat" id="detail_alamat" class="form-control" maxlength="46" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var data_wilayah = <?= json_encode($wilayah) ?>;
        console.log(data_wilayah);
        $("#tambah-nelayan").click(function() {
            bukaForm('baru');
        });
        $(".update-nelayan").click(function() {
            bukaForm('update', $(this).data('id'));
        });
        $("#kecamatan").change(function() {
            var desa = data_wilayah['hirarki'][$(this).val()]['anak'];
            $("#desa").empty();

            Object.keys(desa).forEach(id => {
                $("#desa").append('<option value="' + id + '">' + desa[id] + '</option>')
            });
        });
        function bukaForm(mode, id = null) {
            var modalId = '#modal-form-nelayan';
            var form = $('#form-nelayan');

            $(modalId).on('shown.bs.modal', async function() {
                form.find('input, textarea').val('');
                if (mode == 'update') {
                    var data = await $.post(basepath + 'nelayan/data/' + id).then(res => res);
                    form.find('#id').val(data.id);
                    form.find('#nama').val(data.nama_lengkap);
                    form.find('#hp').val(data.hp);
                    form.find('#detail_alamat').val(data.detail_alamat);
                    form.find('#id').val(data.id);
                    if (data.alamat) {
                        console.log(data.alamat);
                        $("#kecamatan option[value='" + (data.alamat.substr(0, 8) + ".0000']")).prop('selected', true).parent().trigger('change');
                        setTimeout(function() {
                            $("#desa option[value='" + data.alamat + "']").trigger('change').prop('selected', true).parent().trigger('change');
                        }, 300)
                    }
                } else {

                }
            });
            $(modalId).modal('show');
            $(modalId).off('shown.bs.modal');
        }

        $("#kecamatan").trigger('change')
    });
</script>