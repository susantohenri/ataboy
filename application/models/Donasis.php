<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Donasis extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'donasi';
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
				      'name' => 'alamat',
				      'width' => 2,
		      		'label'=> 'Alamat',
					  ),
    );
    $this->childs = array (
        array (
				      'label' => 'Item',
				      'controller' => 'DonasiBarang',
				      'model' => 'DonasiBarangs'
					  ),
        array (
				      'label' => 'Foto',
				      'controller' => 'DonasiPhoto',
				      'model' => 'DonasiPhotos'
					  ),
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('donasi.status');
    return parent::dt();
  }

}