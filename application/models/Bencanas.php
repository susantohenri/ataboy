<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bencanas extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'bencana';
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
				      'name' => 'status',
				      'width' => 2,
		      		'label'=> 'Status',
					  ),
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('bencana.nama');
    return parent::dt();
  }

}