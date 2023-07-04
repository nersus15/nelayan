<style>
    th{
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $desc ?? null ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="<?= $dtid ?? $idContent ?>" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <?php foreach ($header as $k => $v) : ?>
                                    <th><?= $k ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $k => $v) : ?>
                                <tr>
                                    <?php foreach ($header as $key => $value) : ?>
                                        <?php if(is_callable($value)): ?>
                                            <td><?= $value($v, $k) ?></td>
                                        <?php else: ?>
                                            <td><?= is_object($v) ? ($v->$value ?? null) : ($v[$value] ?? null) ?></td>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<script>
    $(document).ready(function() {
        var dtid = "<?= $dtid ?? $idContent ?>";
        var ada_tambah = <?= $adaTambah ?? 'false' ?>;
        var buttons = <?= isset($buttons) && !empty($buttons) ? json_encode($buttons) : '[]' ?>;
        var options = {
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        };
        if(ada_tambah){
            options.buttons.push({
                text: 'Tambah Data',
                action: function ( e, dt, node, config ) {
                   location.href = basepath + 'bumil/add';
                }
            })
        }
        buttons.forEach(button => {
            options.buttons.push({
                text: button.text,
                action: button.action.parseFunction()
            });
        });
        $("#" + dtid).DataTable(options).buttons().container().appendTo('#' + dtid + '_wrapper .col-md-6:eq(0)');
    });
</script>