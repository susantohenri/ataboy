<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluarBulks extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'barangkeluarbulk';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'pengajuan', 'sTitle' => 'Pengajuan'),

    );
    $this->form = array (
        array (
		      'name' => 'pengajuan',
		      'label'=> 'Pengajuan',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Pengajuans'),
		        array('data-field' => 'createdAt')
			    )),
    );
    $this->childs = array (
        array (
				      'label' => 'Item',
				      'controller' => 'BarangKeluar',
				      'model' => 'BarangKeluars'
					  ),
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('barangkeluarbulk.pengajuan');
    return parent::dt();
  }

}