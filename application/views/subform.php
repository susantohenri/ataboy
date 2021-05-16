<div class="form-group row" data-orders="<?= isset ($item) ? $item['orders'] : '' ?>">

    <?php foreach ($form as $field) : ?>
        <?php switch($field['type']): case 'hidden': ?>
            <input class="form-control" type="<?= $field['type'] ?>" value="<?= $field['value'] ?>" name="<?= "{$controller}_" ?><?= $field['name'] ?>[<?= $uuid ?>]" <?= $field['attr'] ?> placeholder="<?= $field['label'] ?>">
        <?php break; ?>
        <?php case 'select': if(preg_match('/(multiple)/', $field['attr']) > 0) echo '<input type="hidden" name="'.$controller.'_'.$field['name'].'">'; ?>
          <div class="input-group col-sm-<?= $field['width'] ?>">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-+on1"><?= $field['label'] ?></span>
            </div>
            <select class="form-control" name="<?= "{$controller}_" ?><?= $field['name'] ?>[<?= $uuid ?>]" <?= $field['attr'] ?>>
            <?php foreach ($field['options'] as $opt): ?>
            <option <?= $opt['value'] === $field['value'] || (is_array($field['value']) && in_array($opt['value'], $field['value'])) ? 'selected="selected"':'' ?> value="<?= $opt['value'] ?>"><?= $opt['text'] ?></option>
            <?php endforeach ?>
            </select>
          </div>
        <?php break; ?>
        <?php case 'file': ?>
          <?php if (strlen($field['value']) > 0): ?>
          <div class="input-group col-sm-2">
            <img src="<?= base_url($field['value']) ?>" width="200" height="100">
          </div>
          <?php endif ?>
          <div class="<?= strlen($field['value']) > 0 ? 'd-none':'' ?> input-group col-sm-<?= $field['width'] ?>">
            <div class="input-group-prepend">
              <span class="input-group-text"><?= $field['label'] ?></span>
            </div>
            <input class="form-control" type="<?= $field['type'] ?>" value="<?= htmlentities($field['value']) ?>" name="<?= "{$controller}_" ?><?= $field['name'] ?>[<?= $uuid ?>]" <?= $field['attr'] ?> placeholder="<?= $field['label'] ?>">
          </div>
        <?php break; ?>
        <?php default: ?>
          <div class="input-group col-sm-<?= $field['width'] ?>">
            <div class="input-group-prepend">
              <span class="input-group-text"><?= $field['label'] ?></span>
            </div>
            <input class="form-control" type="<?= $field['type'] ?>" value="<?= htmlentities($field['value']) ?>" name="<?= "{$controller}_" ?><?= $field['name'] ?>[<?= $uuid ?>]" <?= $field['attr'] ?> placeholder="<?= $field['label'] ?>">
          </div>
        <?php break; ?>
        <?php endswitch; ?>
    <?php endforeach ?>

    <?php if (in_array("delete_{$controller}", $permission)) : ?>
    <div class="col-sm-1">
      <a class="btn btn-danger btn-delete" data-uuid="<?= $uuid ?>">
        <i class="fa fa-trash"></i>
      </a>
    </div>
    <?php endif ?>

</div>
