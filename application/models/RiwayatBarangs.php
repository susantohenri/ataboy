<?php defined('BASEPATH') or exit('No direct script access allowed');

class RiwayatBarangs extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'riwayatbarang';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'tanggal', 'sTitle' => 'Tanggal', 'width' => '20%'),
      (object) array('mData' => 'namabarang', 'sTitle' => 'Barang'),
      (object) array('mData' => 'jenis', 'sTitle' => 'Jenis'),
      (object) array('mData' => 'jumlah', 'sTitle' => 'Jumlah', 'width' => '20%'),
    );
    $this->form = array(
      array(
        'name' => 'barangMasuk',
        'width' => 2,
        'label' => 'BarangMasuk',
      ),
      array(
        'name' => 'barangKeluar',
        'width' => 2,
        'label' => 'BarangKeluar',
      ),
      array(
        'name' => 'barang',
        'width' => 2,
        'label' => 'Barang',
      ),
      array(
        'name' => 'jumlah',
        'label' => 'Jumlah',
        'width' => 2,
        'attributes' => array(
          array('data-number' => 'true')
        )
      ),
      array(
        'name' => 'satuan',
        'width' => 2,
        'label' => 'Satuan',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select('orders')
      ->select('uuid')
      ->select('tanggal')
      ->select('namabarang')
      ->select('jenis')
      ->select('jumlah')
      ->from("
        (
          SELECT
            riwayatbarang.orders
            , riwayatbarang.uuid
            , riwayatbarang.createdAt tanggal
            , barang.nama namabarang
            , IF(LENGTH(riwayatbarang.barangMasuk) > 0, 'MASUK', IF(LENGTH(riwayatbarang.barangKeluar) > 0, 'KELUAR', 'UNDEFINED')) jenis
            , CONCAT(riwayatbarang.jumlah, ' ', barangsatuan.nama) jumlah
          FROM riwayatbarang
          LEFT JOIN barang ON riwayatbarang.barang = barang.uuid
          LEFT JOIN barangsatuan ON barangsatuan.uuid = riwayatbarang.satuan
        ) riwayatBarangBarang
      ");
    return $this->datatables->generate();
  }
}
