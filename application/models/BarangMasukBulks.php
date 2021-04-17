<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangMasukBulks extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'barangmasukbulk';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'donasi', 'sTitle' => 'Donasi'),

    );
    $this->form = array (
        array (
		      'name' => 'donasi',
		      'label'=> 'Donasi',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Donasis'),
		        array('data-field' => 'createdAt')
			    )),
        array (
				      'name' => 'keterangan',
				      'width' => 2,
		      		'label'=> 'Keterangan',
					  ),
    );
    $this->childs = array (
        array (
				      'label' => 'Item',
				      'controller' => 'BarangMasuk',
				      'model' => 'BarangMasuks'
					  ),
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('barangmasukbulk.donasi');
    return parent::dt();
  }

}