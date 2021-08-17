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
        'attributes' => array(
          array('required' => 'required')
        )
      ),
      array(
        'name' => 'status',
        'width' => 2,
        'label' => 'Status',
        'options' => array(
          array('value' => '1', 'text' => 'ACTIVE'),
          array('value' => '0', 'text' => 'INACTIVE')
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
      ->select("IF(0 = status, 'INACTIVE', 'ACTIVE') status", false)
      ->select('bencana.nama')
      ->where('jenis', '');
    return parent::dt();
  }

  function select2($field, $term)
  {
     $this->db->where('status', 1);
     $this->db->where('jenis', '');
     return parent::select2($field, $term);
  }
  
  function getUuid($uuid) {
        $found = $this->findOne($uuid);
        if (isset($found['uuid']))
            return $uuid;
        else
            return $this->create(array('nama' => $uuid, 'jenis' => 'free-text'));
    }
}
