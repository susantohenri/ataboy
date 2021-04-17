<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuans extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'pengajuan';
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
		      'name' => 'kecamatan',
		      'label'=> 'Kecamatan',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Kecamatans'),
		        array('data-field' => 'nama')
			    )),
        array (
		      'name' => 'kelurahan',
		      'label'=> 'Kelurahan',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Kelurahans'),
		        array('data-field' => 'nama')
			    )),
        array (
				      'name' => 'latitude',
				      'width' => 2,
		      		'label'=> 'Latitude',
					  ),
        array (
				      'name' => 'longitude',
				      'width' => 2,
		      		'label'=> 'Longitude',
					  ),
        array (
		      'name' => 'bencana',
		      'label'=> 'Bencana',
		      'options' => array(),
		      'width' => 2,
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => 'Bencanas'),
		        array('data-field' => 'nama')
			    )),
        array (
		      'name' => 'jumlah_kk_jiwa',
		      'label'=> 'Jumlah KK / Jiwa',
		      'width' => 2,
		      'attributes' => array(
		        array('data-number' => 'true')
			    )),
        array (
				      'name' => 'tiket_id',
				      'width' => 2,
		      		'label'=> 'Tiket_id',
					  ),
    );
    $this->childs = array (
        array (
				      'label' => 'Item',
				      'controller' => 'PengajuanBarang',
				      'model' => 'PengajuanBarangs'
					  ),
        array (
				      'label' => 'Foto',
				      'controller' => 'PengajuanPhoto',
				      'model' => 'PengajuanPhotos'
					  ),
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('pengajuan.status');
    return parent::dt();
  }

}