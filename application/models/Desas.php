<?php defined('BASEPATH') or exit('No direct script access allowed');

class Desas extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'desa';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      ),
      array(
        'name' => 'kec',
        'label' => 'Kecamatan',
        'options' => array(),
        'width' => 2,
        'attributes' => array(
          array('data-autocomplete' => 'true'),
          array('data-model' => 'Kecamatans'),
          array('data-field' => 'nama')
        )
      )
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('desa.nama');
    return parent::dt();
  }
}
