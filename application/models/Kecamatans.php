<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kecamatans extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'kecamatan';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
        'attributes' => array(
          array('required' => 'required')
        )
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('kecamatan.nama');
    return parent::dt();
  }
}
