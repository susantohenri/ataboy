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
    foreach (array('User', 'Role', 'Permission', 'Menu', 'Pengajuan', 'Kecamatan', 'Desa', 'Bencana', 'PengajuanBarang', 'PengajuanPhoto', 'BarangKeluarBulk', 'BarangKeluar', 'Donasi', 'DonasiBarang', 'DonasiPhoto', 'Blog', 'Barang', 'BarangSatuan', 'BarangMasukBulk', 'BarangMasuk', 'RiwayatBarang', 'Donatur', 'Kelurahan', 'AdminWarehouse', 'SuperAdmin') as $entity) {
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

    // ROLE & PERMISSION START
    $appRole = array();
    foreach (array('Admin Warehouse', 'Kelurahan', 'Donatur') as $role) {
      $appRole[$role] = $this->Roles->create(array(
        'name' => $role
      ));
    }

    foreach (array('Pengajuan', 'Kecamatan', 'Desa', 'Bencana', 'PengajuanBarang', 'PengajuanPhoto', 'BarangKeluarBulk', 'BarangKeluar', 'Donasi', 'DonasiBarang', 'DonasiPhoto', 'Blog', 'Barang', 'BarangSatuan', 'BarangMasukBulk', 'BarangMasuk', 'RiwayatBarang', 'Donatur', 'Kelurahan') as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
        $this->Permissions->create(array(
          'role' => $appRole['Admin Warehouse'],
          'action' => $action,
          'entity' => $entity
        ));
      }
      if (!in_array($entity, array('Menu', 'Permission', 'Role'))) $this->Menus->create(array(
        'role' => $appRole['Admin Warehouse'],
        'name' => $entity,
        'url' => $entity,
        'icon' => $fas[rand(0, count($fas) - 1)]
      ));
    }
    // ROLE & PERMISSION END

    // DELETE PERMISSION FOR DELETING USERS START
    foreach ($this->Permissions->find(array('action' => 'delete')) as $delete) {
      if (in_array($delete->entity, array('SuperAdmin', 'AdminWarehouse', 'Kelurahan', 'Donatur'))) {
        $this->Permissions->delete($delete->uuid);
      }
    }
    // DELETE PERMISSION FOR DELETING USERS END

    // SETUP MENU START
    $this->db->where('url', 'User')->delete('menu');
    $this->db->set('name', 'Super Admin')->set('icon', 'user-circle')->where('url', 'SuperAdmin')->update('menu');
    $this->db->set('name', 'Admin Warehouse')->set('icon', 'user-cog')->where('url', 'AdminWarehouse')->update('menu');
    $this->db->set('icon', 'user-tag')->where('url', 'Kelurahan')->update('menu');
    $this->db->set('icon', 'user-tie')->where('url', 'Donatur')->update('menu');
    // SETUP MENU END

  }

  function down()
  {
  }
}
