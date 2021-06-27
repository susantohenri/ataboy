<?php defined('BASEPATH') or exit('No direct script access allowed');

class RiwayatBarangs extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'riwayatbarang';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'tanggal', 'sTitle' => 'Tanggal', 'width' => '15%'),
      (object) array('mData' => 'namabarang', 'sTitle' => 'Barang'),
      (object) array('mData' => 'jenis', 'sTitle' => 'Jenis', 'width' => '10%'),
      (object) array('mData' => 'jumlah', 'sTitle' => 'Jumlah', 'width' => '15%'),
      (object) array('mData' => 'tiket_id', 'sTitle' => 'Donasi / Pengajuan', 'width' => '20%')
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
    $this->query = "
      SELECT
        riwayatbarang.orders
        , riwayatbarang.uuid
        , riwayatbarang.createdAt tanggal
        , barang.nama namabarang
        , IF(LENGTH(riwayatbarang.barangmasuk) > 0, 'MASUK', IF(LENGTH(riwayatbarang.barangkeluar) > 0, 'KELUAR', 'UNDEFINED')) jenis
        , CONCAT(FORMAT(riwayatbarang.jumlah, 0), ' ', barangsatuan.nama) jumlah
        , IF(donasi.tiket_id IS NOT NULL, donasi.tiket_id, IF(pengajuan.tiket_id IS NOT NULL, pengajuan.tiket_id, 'MANUAL')) tiket_id
      FROM riwayatbarang
      LEFT JOIN barang ON riwayatbarang.barang = barang.uuid
      LEFT JOIN barangsatuan ON barangsatuan.uuid = riwayatbarang.satuan
      LEFT JOIN barangmasuk ON riwayatbarang.barangmasuk = barangmasuk.uuid
      LEFT JOIN barangkeluar ON riwayatbarang.barangKeluar = barangkeluar.uuid
      LEFT JOIN barangmasukbulk ON barangmasuk.barangmasukbulk = barangmasukbulk.uuid
      LEFT JOIN barangkeluarbulk ON barangkeluar.barangkeluarbulk = barangkeluarbulk.uuid
      LEFT JOIN donasi ON barangmasukbulk.donasi = donasi.uuid
      LEFT JOIN pengajuan ON barangkeluarbulk.pengajuan = pengajuan.uuid
    ";
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
      ->select('tiket_id')
      ->from("({$this->query}) riwayatBarangBarang");
    return $this->datatables->generate();
  }

  function download ()
  {
    $no = 0;
    return array_map(function ($record) use (&$no) {
      $no++;
      return array(
        'NO' => $no,
        'TANGGAL' => $record->tanggal,
        'BARANG' => $record->namabarang,
        'JENIS' => $record->jenis,
        'JUMLAH' => $record->jumlah,
        'DONASI / PENGAJUAN' => $record->tiket_id
      );
    }, $this->db->query($this->query)->result());
  }
}
