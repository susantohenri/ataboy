<style type="text/css">
    .select2-container {
        width: 100% !important;
        padding: 0;
    }
</style>
<div class="modal fade" id="kelurahanModal" tabindex="-1" role="dialog" aria-labelledby="kelurahanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Registrasi Kelurahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" class="main-form col-sm-12">
                    <div class="">
                        <div class="form-horizontal form-groups">
                            <input type="hidden" name="last_submit" value="<?= time() ?>">

                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Alamat Email</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="" name="username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Nama</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="" name="nama">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Kelurahan</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="desa">
                                        <option value=""></option>
                                        <?php foreach ($desas as $desa) : ?>
                                            <option value="<?= $desa['uuid'] ?>"><?= $desa['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">No. HP</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="" name="nohp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Kata Sandi</label>
                                <div class="col-sm-9 input-group">
                                    <input class="form-control" type="password" value="" name="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-password">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <small>
                                        * Akun anda dapat digunakan setelah melalui proses verifikasi, pastikan nomor telepon anda valid
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-right">
                                    <input type="submit" class="btn btn-info" value="Registrasi">
                                    <a class="btn btn-danger" data-dismiss="modal" style="cursor:pointer">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>