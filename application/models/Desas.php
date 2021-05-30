<?php defined('BASEPATH') or exit('No direct script access allowed');

class Desas extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'desa';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),
      (object) array('mData' => 'namakec', 'sTitle' => 'Kecamatan'),
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
        'name' => 'kec',
        'label' => 'Kecamatan',
        'options' => array(),
        'width' => 2,
        'attributes' => array(
          array('data-autocomplete' => 'true'),
          array('data-model' => 'Kecamatans'),
          array('data-field' => 'nama'),
          array('required' => 'required')
        )
      )
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select('uuid')
      ->select('orders')
      ->select('nama')
      ->select('namakec')
      ->from("
        (SELECT
          desa.uuid
          , desa.orders
          , desa.nama
          , kecamatan.nama namakec
        FROM desa
        LEFT JOIN kecamatan ON desa.kec = kecamatan.uuid) desakec
      ")
      ;
    return $this->datatables->generate();
  }

  function select2WithKec ($field, $term, $kec)
  {
    $this->db->where('kec', $kec);
    return parent::select2($field, $term);
  }
}
