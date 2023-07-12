<?php 
    if(!is_array($header) && !isset($map))
        throw new Exception("Jika header menggunakan string maka harus menyertakan mapping value", 1);
        
    if(!isset($adaTambah)) $adaTambah = false;
?>
<style>
    th {
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $desc ?? null ?></h3>
                </div>
                <!-- /.card-header -->
                <div style="overflow-x: scroll;" class="card-body">
                    <table id="<?= $dtid ?? $idContent ?>" class="table table-bordered table-hover">
                        <thead>
                            <?php if (is_array($header)) : ?>
                                <tr>
                                    <?php foreach ($header as $k => $v) : ?>
                                        <th><?= $k ?></th>
                                    <?php endforeach ?>
                                </tr>
                            <?php else : ?>
                                <?= $this->include($header); ?>
                            <?php endif ?>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($data as $k => $v) : ?>
                                <tr>
                                    <?php if (is_array($header)) : ?>
                                        <?php foreach ($header as $key => $value) : ?>
                                            <?php if (is_callable($value)) : ?>
                                                <td><?= $value($v, $k, $i) ?></td>
                                            <?php else : ?>
                                                <td><?= is_object($v) ? ($v->$value ?? null) : ($v[$value] ?? null) ?></td>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php else :  ?>
                                        <?php foreach($map as $key => $value): ?>
                                            <?php if (is_callable($value)) : ?>
                                                <td><?= $value($v, $k, $i) ?></td>
                                            <?php else : ?>
                                                <td><?= is_object($v) ? ($v->$value ?? null) : ($v[$value] ?? null) ?></td>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tr>
                            <?php $i+=1; endforeach ?>

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
        var ada_tambah = <?= $adaTambah ? 'true' : 'false' ?>;
        var buttons = <?= isset($buttons) && !empty($buttons) ? json_encode($buttons) : '[]' ?>;
        var options = {
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        };
        if (ada_tambah) {
            options.buttons.push({
                text: 'Tambah Data',
                action: function(e, dt, node, config) {
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