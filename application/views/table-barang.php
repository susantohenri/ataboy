<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.css') ?>">
<div class="col-sm-12">
    <div class="card card-primary card-outline">
        <div class="card-header text-right">
            <div class="col-sm-12 text-right">
                <a href="<?= site_url($current['controller'] . '/excel') ?>" class="btn btn-info">
                    <i class="fa fa-file-excel"></i>&nbsp; Download Excel
                </a>
                <a href="<?= site_url($current['controller'] . '/pdf') ?>" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i>&nbsp; Download PDF
                </a>
                <?php if (in_array("create_{$current['controller']}", $permission)) : ?>
                    <a href="<?= site_url($current['controller'] . '/create') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;Add New <?= $page_title ?>
                    </a>
                <?php endif ?>
                <a href="<?= site_url() ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> &nbsp; Cancel</a>
            </div>
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
<script type="text/javascript">
    // PREVENT FORM RESUBMISSION ON REFRESH OR BACK
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    var thead = <?= json_encode($thead) ?>;
    var allow_read = <?= in_array("read_{$current['controller']}", $permission) ? 1 : 0 ?>
</script>
