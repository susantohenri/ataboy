<?php defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasukBulks extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'barangmasukbulk';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'createdAt', 'sTitle' => 'Waktu Input', 'width' => '20%'),
      (object) array('mData' => 'admin', 'sTitle' => 'Admin'),
      (object) array('mData' => 'donatur', 'sTitle' => 'Donatur'),
    );
    $this->form = array(
      array(
        'name' => 'donasi',
        'label' => 'Donasi',
        'options' => array(),
        'width' => 2,
        'attributes' => array(
          array('data-autocomplete' => 'true'),
          array('data-model' => 'Donasis'),
          array('data-field' => 'tiket_id')
        )
      ),
      array(
        'name' => 'keterangan',
        'width' => 2,
        'label' => 'Keterangan',
        'type' => 'textarea'
      ),
    );
    $this->childs = array(
      array(
        'label' => 'Item',
        'controller' => 'BarangMasuk',
        'model' => 'BarangMasuks'
      ),
      array(
        'label' => 'Log History',
        'controller' => 'BarangMasukBulkLog',
        'model' => 'BarangMasukBulkLogs'
      ),
    );
  }

  function dt()
  {
    return $this->datatables
      ->select('orders')
      ->select('uuid')
      ->select('createdAt')
      ->select('admin')
      ->select('donatur')
      ->from("
        (SELECT
          barangMasukBulk.orders
          , barangMasukBulk.uuid
          , barangMasukBulk.createdAt
          , admin.nama admin
          , donatur.nama donatur
        FROM barangMasukBulk
        LEFT JOIN user admin ON admin.uuid = barangMasukBulk.createdBy
        LEFT JOIN donasi ON donasi.uuid = barangMasukBulk.donasi
        LEFT JOIN user donatur ON donasi.createdBy = donatur.uuid) barangMasukBulkAdminDonatur
      ")
      ->generate();
  }

  function getForm($uuid = false, $isSubform = false)
  {
    $form = parent::getForm($uuid, $isSubform);
    if (false !== $uuid) {
      $form = array_map(function ($field) {
        if ('donasi' === $field['name']) {
          $field['attr'] .= ' disabled="disabled"';
        }
        return $field;
      }, $form);
    } else {
      unset($this->childs[1]); // HIDE LOG
    }
    return $form;
  }

  function save ($data)
  {
    unset($this->childs[1]); // HIDE LOG
    return parent::save($data);
  }

  function create($data)
  {
    $data['createdBy'] = $this->session->userdata('uuid');
    if (isset($data['donasi']) && strlen($data['donasi']) > 0) {
      $this->load->model('Donasis');
      $this->Donasis->selesai($data['donasi']);
    }
    $uuid = parent::create($data);
    if (isset($data['donasi']) && strlen($data['donasi']) > 0) {
      $this->load->model('BarangMasuks');
      $this->BarangMasuks->setDonasi($uuid, $data['donasi']);
    }
    return $uuid;
  }
}
