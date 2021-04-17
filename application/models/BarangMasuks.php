<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangMasuks extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'barangmasuk';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'barang', 'sTitle' => 'Barang'),

    );
    $this->form = array (
        array (
		      'name' => 'barang',
		      'label'=> 'Barang',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Barangs'),
		        array('data-field' => 'nama')
			    )),
        array (
		      'name' => 'jumlah',
		      'label'=> 'Jumlah',
		      'width' => 2,
		      'attributes' => array(
		        array('data-number' => 'true')
			    )),
        array (
		      'name' => 'satuan',
		      'label'=> 'Satuan',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'BarangSatuans'),
		        array('data-field' => 'nama')
			    )),
        array (
				      'name' => 'keterangan',
				      'width' => 2,
		      		'label'=> 'Keterangan',
					  ),
        array (
				      'name' => 'donasi',
				      'width' => 2,
		      		'label'=> 'Donasi',
					  ),
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('barangmasuk.barang');
    return parent::dt();
  }

}