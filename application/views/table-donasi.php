<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.css') ?>">
<div class="col-sm-12">
    <div class="card card-primary card-outline">
        <div class="card-header text-right">
            <?php if (in_array("create_{$current['controller']}", $permission)) : ?>
                <div class="col-sm-12 text-right">
                    <a href="<?= site_url($current['controller'] . '/create') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;Add New <?= $page_title ?>
                    </a>
                    <a href="<?= site_url() ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> &nbsp; Cancel</a>
                </div>
            <?php endif ?>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-striped datatable table-model">
                <tfoot>
                    <tr>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div><!-- /.card -->
</div>
<?php if (isset($tiket_id)) : ?>
    <div class="modal in" tabindex="-1" role="dialog" style="display:block">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h2>Donasi Berhasil</h2>
                    <h4>ID: <?= $tiket_id ?></h4>
                    &nbsp;
                    <p>
                        Dimohon untuk mengecek secara berkala untuk mengetahui status terbaru.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$(this).parent().parent().parent().parent().remove()">OK</button>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<script type="text/javascript">
    var thead = <?= json_encode($thead) ?>;
    var allow_read = <?= in_array("read_{$current['controller']}", $permission) ? 1 : 0 ?>
</script>