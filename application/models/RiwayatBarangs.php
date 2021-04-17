<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatBarangs extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'riwayatbarang';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'barangMasuk', 'sTitle' => 'BarangMasuk'),

    );
    $this->form = array (
        array (
				      'name' => 'barangMasuk',
				      'width' => 2,
		      		'label'=> 'BarangMasuk',
					  ),
        array (
				      'name' => 'barangKeluar',
				      'width' => 2,
		      		'label'=> 'BarangKeluar',
					  ),
        array (
				      'name' => 'barang',
				      'width' => 2,
		      		'label'=> 'Barang',
					  ),
        array (
		      'name' => 'jumlah',
		      'label'=> 'Jumlah',
		      'width' => 2,
		      'attributes' => array(
		        array('data-number' => 'true')
			    )),
        array (
				      'name' => 'satuan',
				      'width' => 2,
		      		'label'=> 'Satuan',
					  ),
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('riwayatbarang.barangMasuk');
    return parent::dt();
  }

}