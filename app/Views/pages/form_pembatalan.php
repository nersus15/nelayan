<div class="modal" id="modal-form-pembatalan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pembatalan Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-pembatalan" action="<?= base_url('tolak') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id-transaksi">
                    <input type="hidden" name="pembatal" value="<?= $pembatal ?>">
                    <div style="display: none;" class="row" id="info-pembatalan">
                        <div class="form-group col-sm-6">
                            <label for="">Oleh</label>
                            <input disabled type="text" name="_pembatal" id="_pembatal" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">Tanggal</label>
                            <input disabled type="text" name="_tanggal" id="_tanggal" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Alasan Pembatalan</label>
                            <textarea name="alasan" id="alasan" class="form-control" maxlength="46" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>