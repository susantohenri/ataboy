<?php if (isset($reset_password)) : ?>
    <div class="modal in" tabindex="-1" role="dialog" style="display:block">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form method="post" action="<?= site_url('Home') ?>">
                        <input type="hidden" name="action" value="reset-password">
                        <input type="hidden" name="uuid" value="<?= $reset_password ?>">
                        <div class="form-group row">
                            <div class="col-sm-12 input-group">
                                <input class="form-control" type="password" value="" name="password" required="required" placeholder="Kata Sandi Baru">
                                <div class="input-group-append">
                                    <span class="input-group-text show-password">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 offset-8">
                                <button type="submit" class="btn btn-primary btn-flat">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>