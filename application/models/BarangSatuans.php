<?php defined('BASEPATH') or exit('No direct script access allowed');

class BarangSatuans extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'barangsatuan';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 4,
        'label' => 'Nama',
      ),
      array(
        'name' => 'skala',
        'width' => 2,
        'label' => 'Skala',
        'attributes' => array(
          array('data-number' => 'true')
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
      ->select('barangsatuan.nama');
    return parent::dt();
  }

  function select2WithBarang($field, $term, $brg)
  {
    $this->db->where('barang', $brg);
    return parent::select2($field, $term);
  }

  function getSmallest($barang)
  {
    $satuan = $this->findOne(array('barang' => $barang, 'skala' => 1));
    return $satuan ? $satuan['nama'] : '*smallest-scale-notfound';
  }
}
