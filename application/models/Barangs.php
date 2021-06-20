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
      (object) array('mData' => 'status', 'sTitle' => 'Status'),
      (object) array('mData' => 'stok', 'sTitle' => 'Stok')
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
    return $this->datatables
      ->select('uuid')
      ->select('orders')
      ->select('nama')
      ->select('stok')
      ->select('status')
      ->from("
        (SELECT
          barang.uuid
          , barang.orders
          , barang.nama
          , IF(0 = status, 'INACTIVE', 'ACTIVE') status
          , CONCAT(FORMAT(SUM(riwayatbarang.jumlah * barangsatuan.skala), 0), ' ', lowest.nama) stok
        FROM barang
        LEFT JOIN riwayatbarang ON riwayatbarang.barang = barang.uuid
        LEFT JOIN barangsatuan ON riwayatbarang.satuan = barangsatuan.uuid
        LEFT JOIN barangsatuan lowest ON lowest.barang = barang.uuid AND lowest.skala = 1
        GROUP BY barang.uuid
        ) barangWithStock
      ")
      ->generate();
  }

  function select2($field, $term)
  {
    $this->db->where('status', 1);
    return parent::select2($field, $term);
  }

  // BARANG CUSTOM BY DONATUR
  function getUuid($uuid)
  {
    $found = $this->findOne($uuid);
    if (isset($found['uuid'])) return $uuid;
    else return $this->create(array('nama' => $uuid));
  }
}
