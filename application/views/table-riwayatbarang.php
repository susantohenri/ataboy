<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="col-sm-12">
    <div class="card card-primary card-outline">
        <div class="card-header text-right">
            <div class="col-sm-12 text-right">
                <?php if (in_array("create_{$current['controller']}", $permission)) : ?>
                    <a href="<?= site_url($current['controller'] . '/create') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;Add New <?= $page_title ?>
                    </a>
                <?php endif ?>
                <a href="<?= site_url($current['controller'] . '/excel') ?>" class="btn btn-info" data-toggle="modal" data-target="#excelModal">
                    <i class="fa fa-file-excel"></i>&nbsp; Download Excel
                </a>
                <a href="<?= site_url($current['controller'] . '/pdf') ?>" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal">
                    <i class="fa fa-file-pdf"></i>&nbsp; Download PDF
                </a>
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

<!--modal download PDF-->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Download PDF</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= site_url($current['controller'] . '/pdf') ?>" id="formPDF">
                    <div id="rangemodalPDF" class="mb-4" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <input type="submit" class="btn btn-info" value="Download">
                            <a class="btn btn-danger" data-dismiss="modal" style="cursor:pointer">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal download Excel-->
<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Download Excel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= site_url($current['controller'] . '/excel') ?>" id="formExcel">
                    <div id="rangemodalExcel" class="mb-4" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <input type="submit" class="btn btn-info" value="Download">
                            <a class="btn btn-danger" data-dismiss="modal" style="cursor:pointer">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // PREVENT FORM RESUBMISSION ON REFRESH OR BACK
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    var thead = <?= json_encode($thead) ?>;
    var allow_read = <?= in_array("read_{$current['controller']}", $permission) ? 1 : 0 ?>
</script>