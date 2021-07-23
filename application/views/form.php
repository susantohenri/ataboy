<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
<form enctype='multipart/form-data' action="<?= site_url($current['controller']) ?>" method="POST" class="main-form col-sm-12">
  <div class="card card-primary card-outline">
    <div class="card-header text-right">
      <?php if ((empty($uuid) && in_array("create_{$current['controller']}", $permission)) || (!empty($uuid) && in_array("update_{$current['controller']}", $permission))) : ?>
        <button class="btn btn-info btn-save"><i class="fa fa-save"></i> &nbsp; Save</button>
      <?php endif ?>
      <?php if (!empty($uuid) && in_array("delete_{$current['controller']}", $permission)) : ?>
        <a href="<?= site_url($current['controller'] . "/delete/$uuid") ?>" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Delete</a>
      <?php endif ?>
      <a href="<?= site_url($current['controller']) ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> &nbsp; Cancel</a>
    </div>
    <div class="card-body">

      <div class="" data-controller="<?= $current['controller'] ?>">
        <div class="form-horizontal form-groups">
          <input type="hidden" name="last_submit" value="<?= time() ?>">

          <?php foreach ($form as $field) : ?>

            <?php switch ($field['type']):
              case 'hidden': ?>
                <input class="form-control" type="<?= $field['type'] ?>" value="<?= $field['value'] ?>" name="<?= $field['name'] ?>" <?= $field['attr'] ?>>
                <?php break; ?>
              <?php
              case 'select': ?>
                <div class="form-group row">
                  <label class="col-sm-3 control-label"><?= $field['label']  ?></label>
                  <div class="col-sm-9">
                    <?php if (preg_match('/(multiple)/', $field['attr']) > 0) : ?>
                      <input type="hidden" name="<?= str_replace('[]', '', $field['name']) ?>">
                    <?php endif ?>
                    <select class="form-control" name="<?= $field['name'] ?>" <?= $field['attr'] ?>>
                      <?php foreach ($field['options'] as $opt) : ?>
                        <option <?= $opt['value'] === $field['value'] || (is_array($field['value']) && in_array($opt['value'], $field['value'])) ? 'selected="selected"' : '' ?> value="<?= $opt['value'] ?>"><?= $opt['text'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <?php break; ?>
              <?php
              case 'textarea': ?>
                <div class="form-group row">
                  <label class="col-sm-3 control-label"><?= $field['label']  ?></label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="<?= $field['name'] ?>" <?= $field['attr'] ?>><?= $field['value'] ?></textarea>
                  </div>
                </div>
                <?php break; ?>
              <?php
              case 'file': ?>
                <div class="form-group row">
                  <label class="col-sm-3 control-label"><?= $field['label']  ?></label>
                  <div class="col-sm-9">
                    <input class="form-control" type="<?= $field['type'] ?>" value="<?= htmlentities($field['value']) ?>" name="<?= $field['name'] ?>" <?= $field['attr'] ?>>
                    <?php if (strlen($field['value']) > 0) : ?>
                      <br>
                      <?php if (substr($field['value'], -3) === 'pdf') : ?>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#preview<?= $field['name'] ?>">
                          <i class="fa fa-eye"></i> &nbsp;
                          Preview <?= $field['label'] ?>
                        </button>
                        <div class="modal fade" id="preview<?= $field['name'] ?>" tabindex="-1" role="dialog" aria-labelledby="preview<?= $field['name'] ?>Label" aria-hidden="true">
                          <div class="modal-dialog" role="document" style="display: table;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">&nbsp;</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <embed src="<?= base_url($field['value']) . '?token=' . time() ?>" width='800px' height='600px' />
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php else : ?>
                        <img src="<?= base_url($field['value']) ?>" width="200" height="100">
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>
                <?php break; ?>
              <?php
              default: ?>
                <div class="form-group row">
                  <label class="col-sm-3 control-label"><?= $field['label']  ?></label>
                  <div class="col-sm-9">
                    <input class="form-control" type="<?= $field['type'] ?>" value="<?= htmlentities($field['value']) ?>" name="<?= $field['name'] ?>" <?= $field['attr'] ?>>
                  </div>
                </div>
                <?php break; ?>
            <?php endswitch; ?>

          <?php endforeach ?>

        </div>
      </div>

    </div>
  </div>

  <?php if (count($subform) > 0) : foreach ($subform as $subfield) : ?>
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h4><?= $subfield['label'] ?></h4>
        </div>
        <div class="card-body">
          <fieldset class="form-child" data-controller="<?= $subfield['controller'] ?>" data-uuids="<?= str_replace('"', "'", json_encode($subfield['uuids'])) ?>">
            <!-- <legend><?= $subfield['label'] ?></legend> -->
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-12">
                <?php if ((empty($subfield->uuids) && in_array("create_{$subfield['controller']}", $permission)) || (!empty($subfield->uuids) && in_array("update_{$subfield['controller']}", $permission))) : ?>

                  <a class="btn btn-warning btn-add">
                    <i class="fa fa-plus"></i> &nbsp;Input <?= $subfield['label'] ?>
                  </a>

                <?php endif ?>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
  <?php endforeach;
  endif; ?>

</form>