<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_seeds extends CI_Migration
{

  function up()
  {
    // DEFAULT START
    $this->load->model(array('Users', 'Roles', 'Permissions', 'Menus'));
    $fas = array('database', 'desktop', 'download', 'ethernet', 'hdd', 'hdd', 'headphones', 'keyboard', 'keyboard', 'laptop', 'memory', 'microchip', 'mobile', 'mobile-alt', 'plug', 'power-off', 'print', 'satellite', 'satellite-dish', 'save', 'save', 'sd-card', 'server', 'sim-card', 'stream', 'tablet', 'tablet-alt', 'tv', 'upload');
    $admin = $this->Roles->create(array('name' => 'Super Admin'));
    foreach (array('User', 'Role', 'Permission', 'Menu', 'Pengajuan', 'Kecamatan', 'Kelurahan', 'Bencana', 'PengajuanBarang', 'PengajuanPhoto', 'BarangKeluarBulk', 'BarangKeluar', 'Donasi', 'DonasiBarang', 'DonasiPhoto', 'Blog', 'Barang', 'BarangSatuan', 'BarangMasukBulk', 'BarangMasuk', 'RiwayatBarang', 'Donatur', 'KepalaKelurahan', 'AdminWarehouse'/*additionalEntity*/) as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
        $this->Permissions->create(array(
          'role' => $admin,
          'action' => $action,
          'entity' => $entity
        ));
      }
      if (!in_array($entity, array('Menu', 'Permission', 'Role'))) $this->Menus->create(array(
        'role' => $admin,
        'name' => $entity,
        'url' => $entity,
        'icon' => $fas[rand(0, count($fas) - 1)]
      ));
    }

    $this->Users->create(array(
      'username' => 'admin',
      'password' => md5('admin'),
      'nama' => 'Super Admin',
      'role' => $admin
    ));
    // DEFAULT END

    // DELETE PERMISSION FOR DELETING USERS START
    foreach ($this->Permissions->find(array('role' => $admin, 'action' => 'delete')) as $delete) {
      if (in_array($delete->entity, array('User', 'AdminWarehouse', 'kepalaKelurahan', 'Donatur'))) {
        $this->Permissions->delete($delete->uuid);
      }
    }
    // DELETE PERMISSION FOR DELETING USERS END

    // ROLE START
    foreach (array('Admin Warehouse', 'Kelurahan', 'Donatur') as $role) {
      $this->Roles->create(array(
        'name' => $role
      ));
    }
    // ROLE END

    // SETUP MENU START
    $this->db->set('name', 'Admin Warehouse')->set('icon', 'university')->where('url', 'AdminWarehouse')->update('menu');
    // SETUP MENU END

  }

  function down()
  {
  }
}
