<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahans extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'kelurahan';
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
        array (
				      'name' => 'alamat',
				      'width' => 2,
		      		'label'=> 'Alamat',
					  ),
        array (
		      'name' => 'desa',
		      'label'=> 'Desa',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Desas'),
		        array('data-field' => 'nama')
			    )),
        array (
				      'name' => 'nohp',
				      'width' => 2,
		      		'label'=> 'Nohp',
					  ),
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('kelurahan.status');
    return parent::dt();
  }

}