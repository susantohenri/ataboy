<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PengajuanPhotos extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'pengajuanphoto';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => '', 'sTitle' => ''),

    );
    $this->form = array (
    );
    $this->childs = array (
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('pengajuanphoto.');
    return parent::dt();
  }

}