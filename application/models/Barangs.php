<?php defined('BASEPATH') or exit('No direct script access allowed');

class Barangs extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'barang';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      )
    );
    $this->childs = array(
      array(
        'label' => 'Satuan',
        'controller' => 'BarangSatuan',
        'model' => 'BarangSatuans'
      ),
    );
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('barang.nama');
    return parent::dt();
  }
}
