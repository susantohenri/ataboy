<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bencanas extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'bencana';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),
      (object) array('mData' => 'status', 'sTitle' => 'Status'),
    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      ),
      array(
        'name' => 'status',
        'width' => 2,
        'label' => 'Status',
        'options' => array(
          array('value' => '-1', 'text' => 'UNVERIFIED'),
          array('value' => '1', 'text' => 'VERIFIED'),
          array('value' => '0', 'text' => 'BLOCKED')
        )
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select("IF(-1 = status, 'UNVERIFIED', IF(0 = status, 'BLOCKED', 'VERIFIED')) status")
      ->select('bencana.nama');
    return parent::dt();
  }

  function select2($field, $term)
  {
     $this->db->where('status', 1);
     return parent::select2($field, $term);
  }
}
