<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdminWarehouses extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'adminwarehouse';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'status', 'sTitle' => 'Status'),

    );
    $this->form = array (
        array (
				      'name' => 'status',
				      'width' => 2,
		      		'label'=> 'Status',
					  ),
        array (
				      'name' => 'nama',
				      'width' => 2,
		      		'label'=> 'Nama',
					  ),
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('adminwarehouse.status');
    return parent::dt();
  }

}