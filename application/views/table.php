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
<script type="text/javascript">
    var thead = <?= json_encode($thead) ?>;
    var allow_read = <?= in_array("read_{$current['controller']}", $permission) ? 1 : 0 ?>
</script>