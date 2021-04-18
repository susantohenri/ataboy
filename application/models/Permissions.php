<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'permission';
    $this->thead = array();
    $this->form = array(
      array (
        'name' => 'entity',
        'label'=> 'Entity',
        'options' => array(
          array ('text' => 'User', 'value' => 'User'),
          array ('text' => 'Role', 'value' => 'Role'),
          array ('text' => 'Permission', 'value' => 'Permission'),
          array ('text' => 'Pengajuan', 'value' => 'Pengajuan'),
          array ('text' => 'Kecamatan', 'value' => 'Kecamatan'),
          array ('text' => 'Desa', 'value' => 'Desa'),
          array ('text' => 'Kelurahan', 'value' => 'Kelurahan'),
          array ('text' => 'Bencana', 'value' => 'Bencana'),
          array ('text' => 'PengajuanBarang', 'value' => 'PengajuanBarang'),
          array ('text' => 'PengajuanPhoto', 'value' => 'PengajuanPhoto'),
          array ('text' => 'BarangKeluarBulk', 'value' => 'BarangKeluarBulk'),
          array ('text' => 'BarangKeluar', 'value' => 'BarangKeluar'),
          array ('text' => 'Donasi', 'value' => 'Donasi'),
          array ('text' => 'DonasiBarang', 'value' => 'DonasiBarang'),
          array ('text' => 'DonasiPhoto', 'value' => 'DonasiPhoto'),
          array ('text' => 'Blog', 'value' => 'Blog'),
          array ('text' => 'Barang', 'value' => 'Barang'),
          array ('text' => 'BarangSatuan', 'value' => 'BarangSatuan'),
          array ('text' => 'BarangMasukBulk', 'value' => 'BarangMasukBulk'),
          array ('text' => 'BarangMasuk', 'value' => 'BarangMasuk'),
          array ('text' => 'RiwayatBarang', 'value' => 'RiwayatBarang'),
          array ('text' => 'Donatur', 'value' => 'Donatur'),
          array ('text' => 'AdminWarehouse', 'value' => 'AdminWarehouse'),
          /*additionalEntity*/
        ),
        'width' => 4
      ),
      array (
        'name' => 'action',
        'label'=> 'Action',
        'options' => array(
          array ('text' => 'List', 'value' => 'index'),
          array ('text' => 'Create', 'value' => 'create'),
          array ('text' => 'Detail', 'value' => 'read'),
          array ('text' => 'Update', 'value' => 'update'),
          array ('text' => 'Delete', 'value' => 'delete')
        ),
        'width' => 4
      ),
    );
  }

  function getPermissions () {
    $permission = array();
    foreach ($this->find(array('role' => $this->session->userdata('role'))) as $perm) $permission[] = "{$perm->action}_{$perm->entity}";
    return $permission;
  }

  function getPermittedMenus () {

  }
}