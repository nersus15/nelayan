<?php
if (isset($dataFooter) && is_array($dataFooter) && !empty($dataFooter)) extract($dataFooter);
?>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="<?= assets_url("vendor/adminlte/plugins/bootstrap/js/bootstrap") ?>.bundle.min.js"></script>
<!-- Plugin -->
<?php if (isset($extra_js)) : ?>
    <?php foreach ($extra_js as $js) : ?>
        <script src="<?= assets_url($js) ?>"></script>
    <?php endforeach ?>
<?php endif ?>
<!-- AdminLTE App -->
<script src="<?= assets_url("vendor/adminlte/dist/js/adminlte.min") ?>.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= assets_url("vendor/adminlte/dist/js/demo.js") ?>"></script>
</body>

</html>