<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangSatuans extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'barangsatuan';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array (
        array (
				      'name' => 'nama',
				      'width' => 2,
		      		'label'=> 'Nama',
					  ),
        array (
				      'name' => 'skala',
				      'width' => 2,
		      		'label'=> 'Skala',
					  ),
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('barangsatuan.nama');
    return parent::dt();
  }

}