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
    foreach (array('User', 'Role', 'Permission', 'Menu', 'Pengajuan', 'PengajuanBarang', 'PengajuanPhoto', 'Donasi', 'DonasiBarang', 'DonasiPhoto', 'Barang', 'BarangSatuan', 'RiwayatBarang', 'BarangKeluarBulk', 'BarangKeluar', 'BarangMasukBulk', 'BarangMasuk', 'Kecamatan', 'Desa', 'Bencana', 'Blog', 'Donatur', 'Kelurahan', 'AdminWarehouse', 'SuperAdmin') as $entity) {
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
    // ADMIN WAREHOUSE PERMISSION
    foreach (array('Pengajuan', 'Kecamatan', 'Desa', 'Bencana', 'PengajuanBarang', 'PengajuanPhoto', 'BarangKeluarBulk', 'BarangKeluar', 'Donasi', 'DonasiBarang', 'DonasiPhoto', 'Blog', 'Barang', 'BarangSatuan', 'BarangMasukBulk', 'BarangMasuk', 'RiwayatBarang', 'Donatur', 'Kelurahan') as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
        $this->Permissions->create(array(
          'role' => $appRole['Admin Warehouse'],
          'action' => $action,
          'entity' => $entity
        ));
      }
      $this->Menus->create(array(
        'role' => $appRole['Admin Warehouse'],
        'name' => $entity,
        'url' => $entity,
        'icon' => $fas[rand(0, count($fas) - 1)]
      ));
    }
    // DONATUR PERMISSION
    foreach (array('Donasi', 'DonasiBarang', 'DonasiPhoto') as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
        $this->Permissions->create(array(
          'role' => $appRole['Donatur'],
          'action' => $action,
          'entity' => $entity
        ));
      }
    }
    $this->Menus->create(array(
      'role' => $appRole['Donatur'],
      'name' => 'Donasi Baru',
      'url' => 'Donasi/create',
      'icon' => 'file-medical'
    ));
    $iconDonasis = array ('credit-card', 'business-time', 'truck-pickup', 'shipping-fast', 'map-marker-alt', 'clipboard-check', 'check-circle');
    foreach (array('Menunggu Pembayaran', 'Menunggu Pengiriman', 'Menunggu Pengambilan', 'Proses Pengiriman', 'Sampai Tujuan', 'Verifikasi', 'Selesai') as $index => $statusDonasi)
    {
      $this->Menus->create(array(
        'role' => $appRole['Donatur'],
        'name' => $statusDonasi,
        'url' => 'Donasi?status=' . $statusDonasi,
        'icon' => $iconDonasis[$index]
      ));
    }
    // KELURAHAN PERMISSION
    foreach (array('Pengajuan', 'PengajuanBarang', 'PengajuanPhoto') as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
        $this->Permissions->create(array(
          'role' => $appRole['Kelurahan'],
          'action' => $action,
          'entity' => $entity
        ));
      }
    }
    $this->Menus->create(array(
      'role' => $appRole['Kelurahan'],
      'name' => 'Pengajuan Baru',
      'url' => 'Pengajuan/create',
      'icon' => 'file-medical'
    ));
    $iconPengajuans = array ('file-signature', 'file-archive', 'file-powerpoint', 'file-prescription');
    foreach (array('Diajukan', 'Diverifikasi', 'Diterima', 'Ditolak') as $index => $statusPengajuan)
    {
      $this->Menus->create(array(
        'role' => $appRole['Kelurahan'],
        'name' => $statusPengajuan,
        'url' => 'Pengajuan?status=' . $statusPengajuan,
        'icon' => $iconPengajuans[$index]
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
    foreach (array(
      'User'
      , 'DonasiBarang'
      , 'DonasiPhoto'
      , 'PengajuanBarang'
      , 'PengajuanPhoto'
      , 'BarangMasuk'
      , 'BarangKeluar'
      , 'BarangSatuan'
    ) as $noNeedMenu) $this->db->where('url', $noNeedMenu)->delete('menu');

    $this->db->set('name', 'Admin Warehouse')->set('icon', 'user-shield')->where('url', 'AdminWarehouse')->update('menu');
    $this->db->set('name', 'User Kelurahan')->set('icon', 'user-check')->where('url', 'Kelurahan')->update('menu');
    $this->db->set('name', 'User Donatur')->set('icon', 'user-tie')->where('url', 'Donatur')->update('menu');
    $this->db->set('icon', 'medkit')->where('url', 'Donasi')->update('menu');
    $this->db->set('icon', 'hand-holding')->where('url', 'Pengajuan')->update('menu');
    $this->db->set('icon', 'hands-helping')->where('url', 'Donasi')->update('menu');
    $this->db->set('name', 'Master Barang')->set('icon', 'box-open')->where('url', 'Barang')->update('menu');
    $this->db->set('name', 'Daftar Kecamatan')->set('icon', 'map-marked-alt')->where('url', 'Kecamatan')->update('menu');
    $this->db->set('name', 'Daftar Desa')->set('icon', 'map-marker-alt')->where('url', 'Desa')->update('menu');
    $this->db->set('name', 'Jenis Bencana')->set('icon', 'house-damage')->where('url', 'Bencana')->update('menu');
    $this->db->set('icon', 'pen-alt')->where('url', 'Blog')->update('menu');
    $this->db->set('name', 'Barang Keluar')->set('icon', 'shipping-fast')->where('url', 'BarangKeluarBulk')->update('menu');
    $this->db->set('name', 'Barang Masuk')->set('icon', 'people-carry')->where('url', 'BarangMasukBulk')->update('menu');
    $this->db->set('name', 'Riwayat Barang')->set('icon', 'history')->where('url', 'RiwayatBarang')->update('menu');

    $this->db->set('name', 'REPLACE(name, " ", "<br>")', false)->update('menu');
    $this->db->set('name', 'Super Admin')->set('icon', 'user-secret')->where('url', 'SuperAdmin')->update('menu');
    // SETUP MENU END

    $this->db->query("
      INSERT INTO `kecamatan` (`uuid`, `orders`, `createdAt`, `updatedAt`, `nama`) VALUES
      ('16577254-a4ad-11eb-887d-3d1cd7e0deb7', '1', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Selo'),
      ('16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', '2', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Ampel'),
      ('16579e64-a4ad-11eb-887d-3d1cd7e0deb7', '3', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Cepogo'),
      ('1657b016-a4ad-11eb-887d-3d1cd7e0deb7', '4', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Musuk'),
      ('1657c164-a4ad-11eb-887d-3d1cd7e0deb7', '5', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Boyolali'),
      ('1657d032-a4ad-11eb-887d-3d1cd7e0deb7', '6', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Mojosongo'),
      ('1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', '7', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Teras'),
      ('1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', '8', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Sawit'),
      ('1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', '9', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Banyudono'),
      ('1658134e-a4ad-11eb-887d-3d1cd7e0deb7', '10', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Sambi'),
      ('165825b4-a4ad-11eb-887d-3d1cd7e0deb7', '11', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Ngemplak'),
      ('1658361c-a4ad-11eb-887d-3d1cd7e0deb7', '12', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Nogosari'),
      ('165845e4-a4ad-11eb-887d-3d1cd7e0deb7', '13', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Simo'),
      ('165853fe-a4ad-11eb-887d-3d1cd7e0deb7', '14', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Karanggede'),
      ('16586146-a4ad-11eb-887d-3d1cd7e0deb7', '15', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Klego'),
      ('16586e52-a4ad-11eb-887d-3d1cd7e0deb7', '16', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Andong'),
      ('16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', '17', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Kemusu'),
      ('16588860-a4ad-11eb-887d-3d1cd7e0deb7', '18', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Wonosegoro'),
      ('16589576-a4ad-11eb-887d-3d1cd7e0deb7', '19', '2021-04-24 10:28:07', '2021-04-24 10:28:07', 'Juwangi')
    ");

    $this->db->query("
      INSERT INTO `desa` (`uuid`, `orders`, `createdAt`, `updatedAt`, `kec`, `nama`) VALUES
      ('7099e714-a4d1-11eb-887d-3d1cd7e0deb7', '268', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Tlogolele'),
      ('709ba25c-a4d1-11eb-887d-3d1cd7e0deb7', '269', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Klakah'),
      ('709d508e-a4d1-11eb-887d-3d1cd7e0deb7', '270', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Jrakah'),
      ('709ef088-a4d1-11eb-887d-3d1cd7e0deb7', '271', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Lencoh'),
      ('70a09118-a4d1-11eb-887d-3d1cd7e0deb7', '272', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Suroteleng'),
      ('70a23752-a4d1-11eb-887d-3d1cd7e0deb7', '273', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Samiran'),
      ('70a3e8e0-a4d1-11eb-887d-3d1cd7e0deb7', '274', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Selo'),
      ('70a5703e-a4d1-11eb-887d-3d1cd7e0deb7', '275', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Tarubatang'),
      ('70a6f1de-a4d1-11eb-887d-3d1cd7e0deb7', '276', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Senden'),
      ('70a876ee-a4d1-11eb-887d-3d1cd7e0deb7', '277', NULL, NULL, '16577254-a4ad-11eb-887d-3d1cd7e0deb7', 'Jeruk'),
      ('70a9f9ba-a4d1-11eb-887d-3d1cd7e0deb7', '278', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Seboto'),
      ('70ab7628-a4d1-11eb-887d-3d1cd7e0deb7', '279', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Tanduk'),
      ('70acf3b8-a4d1-11eb-887d-3d1cd7e0deb7', '280', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Banyuanyar'),
      ('70ae7558-a4d1-11eb-887d-3d1cd7e0deb7', '281', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Sidomulyo'),
      ('70b000bc-a4d1-11eb-887d-3d1cd7e0deb7', '282', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngargosari'),
      ('70b18eb4-a4d1-11eb-887d-3d1cd7e0deb7', '283', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Selodoko'),
      ('70b30abe-a4d1-11eb-887d-3d1cd7e0deb7', '284', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngenden'),
      ('70b4929e-a4d1-11eb-887d-3d1cd7e0deb7', '285', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngampon'),
      ('70b6189e-a4d1-11eb-887d-3d1cd7e0deb7', '286', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Gondang Slamet'),
      ('70b79868-a4d1-11eb-887d-3d1cd7e0deb7', '287', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Candi'),
      ('70b91756-a4d1-11eb-887d-3d1cd7e0deb7', '288', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Urutsewu'),
      ('70baa0ee-a4d1-11eb-887d-3d1cd7e0deb7', '289', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Kaligentong'),
      ('70bc2914-a4d1-11eb-887d-3d1cd7e0deb7', '290', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Gladagsari'),
      ('70bdaff0-a4d1-11eb-887d-3d1cd7e0deb7', '291', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Kembang'),
      ('70bf34c4-a4d1-11eb-887d-3d1cd7e0deb7', '292', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngagrong'),
      ('70c0b51a-a4d1-11eb-887d-3d1cd7e0deb7', '293', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Candisari'),
      ('70c23714-a4d1-11eb-887d-3d1cd7e0deb7', '294', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngargoloka'),
      ('70c3b7a6-a4d1-11eb-887d-3d1cd7e0deb7', '295', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Sampetan'),
      ('70c53a36-a4d1-11eb-887d-3d1cd7e0deb7', '296', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngadirojo'),
      ('70c6bc80-a4d1-11eb-887d-3d1cd7e0deb7', '297', NULL, NULL, '16578cf8-a4ad-11eb-887d-3d1cd7e0deb7', 'Jlarem'),
      ('70c83c36-a4d1-11eb-887d-3d1cd7e0deb7', '298', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Wonodoyo'),
      ('70c9f530-a4d1-11eb-887d-3d1cd7e0deb7', '299', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Jombang'),
      ('70cb89b8-a4d1-11eb-887d-3d1cd7e0deb7', '300', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Gedangan'),
      ('70cd16c0-a4d1-11eb-887d-3d1cd7e0deb7', '301', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Sumbung'),
      ('70cea04e-a4d1-11eb-887d-3d1cd7e0deb7', '302', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Paras'),
      ('70d025cc-a4d1-11eb-887d-3d1cd7e0deb7', '303', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Jelok'),
      ('70d1ad0c-a4d1-11eb-887d-3d1cd7e0deb7', '304', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Bakulan'),
      ('70d3323a-a4d1-11eb-887d-3d1cd7e0deb7', '305', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Candigatak'),
      ('70d4be16-a4d1-11eb-887d-3d1cd7e0deb7', '306', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Cabeankunti'),
      ('70d64560-a4d1-11eb-887d-3d1cd7e0deb7', '307', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Mliwis'),
      ('70d7cc8c-a4d1-11eb-887d-3d1cd7e0deb7', '308', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Sukabumi'),
      ('70d95976-a4d1-11eb-887d-3d1cd7e0deb7', '309', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Genting'),
      ('70dae2b4-a4d1-11eb-887d-3d1cd7e0deb7', '310', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Cepogo'),
      ('70dc6b0c-a4d1-11eb-887d-3d1cd7e0deb7', '311', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Kembangkuning'),
      ('70ddf710-a4d1-11eb-887d-3d1cd7e0deb7', '312', NULL, NULL, '16579e64-a4ad-11eb-887d-3d1cd7e0deb7', 'Gubug'),
      ('70df86ac-a4d1-11eb-887d-3d1cd7e0deb7', '313', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Lampar'),
      ('70e10c7a-a4d1-11eb-887d-3d1cd7e0deb7', '314', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Dragan'),
      ('70e292f2-a4d1-11eb-887d-3d1cd7e0deb7', '315', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Karanganyar'),
      ('70e41884-a4d1-11eb-887d-3d1cd7e0deb7', '316', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Jemowo'),
      ('70e5a190-a4d1-11eb-887d-3d1cd7e0deb7', '317', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Sumur'),
      ('70e72a38-a4d1-11eb-887d-3d1cd7e0deb7', '318', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Sangup'),
      ('70e8b51a-a4d1-11eb-887d-3d1cd7e0deb7', '319', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Mriyan'),
      ('70ea438a-a4d1-11eb-887d-3d1cd7e0deb7', '320', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Lanjaran'),
      ('70ebd36c-a4d1-11eb-887d-3d1cd7e0deb7', '321', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Karangkendal'),
      ('70ed61e6-a4d1-11eb-887d-3d1cd7e0deb7', '322', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Keposong'),
      ('70eeec6e-a4d1-11eb-887d-3d1cd7e0deb7', '323', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Pagerjurang'),
      ('70f07fd4-a4d1-11eb-887d-3d1cd7e0deb7', '324', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Sukorejo'),
      ('70f20fca-a4d1-11eb-887d-3d1cd7e0deb7', '325', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Sruni'),
      ('70f39dd6-a4d1-11eb-887d-3d1cd7e0deb7', '326', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Cluntang'),
      ('70f52dd6-a4d1-11eb-887d-3d1cd7e0deb7', '327', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Kembangsari'),
      ('70f6bb4c-a4d1-11eb-887d-3d1cd7e0deb7', '328', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Ringinlarik'),
      ('70f85092-a4d1-11eb-887d-3d1cd7e0deb7', '329', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Kebongulo'),
      ('70f9e254-a4d1-11eb-887d-3d1cd7e0deb7', '330', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Musuk'),
      ('70fb6da4-a4d1-11eb-887d-3d1cd7e0deb7', '331', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Sukorame'),
      ('70fcf85e-a4d1-11eb-887d-3d1cd7e0deb7', '332', NULL, NULL, '1657b016-a4ad-11eb-887d-3d1cd7e0deb7', 'Pusporenggo'),
      ('70fe8cb4-a4d1-11eb-887d-3d1cd7e0deb7', '333', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Pulisen'),
      ('71001836-a4d1-11eb-887d-3d1cd7e0deb7', '334', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Siwodipuran'),
      ('7101a20a-a4d1-11eb-887d-3d1cd7e0deb7', '335', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Banaran'),
      ('7103307a-a4d1-11eb-887d-3d1cd7e0deb7', '336', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Karanggeneng'),
      ('7104be4a-a4d1-11eb-887d-3d1cd7e0deb7', '337', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Winong'),
      ('71064990-a4d1-11eb-887d-3d1cd7e0deb7', '338', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Penggung'),
      ('7107d4e0-a4d1-11eb-887d-3d1cd7e0deb7', '339', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Kiringan'),
      ('71096f3a-a4d1-11eb-887d-3d1cd7e0deb7', '340', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Mudal'),
      ('710b0034-a4d1-11eb-887d-3d1cd7e0deb7', '341', NULL, NULL, '1657c164-a4ad-11eb-887d-3d1cd7e0deb7', 'Kebonbimo'),
      ('710c8f94-a4d1-11eb-887d-3d1cd7e0deb7', '342', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Kemiri'),
      ('710e1c74-a4d1-11eb-887d-3d1cd7e0deb7', '343', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Mojosongo'),
      ('710fa6e8-a4d1-11eb-887d-3d1cd7e0deb7', '344', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Madu'),
      ('711139ea-a4d1-11eb-887d-3d1cd7e0deb7', '345', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Singosari'),
      ('7112c94a-a4d1-11eb-887d-3d1cd7e0deb7', '346', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Tambak'),
      ('711456c0-a4d1-11eb-887d-3d1cd7e0deb7', '347', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Manggis'),
      ('7115eb02-a4d1-11eb-887d-3d1cd7e0deb7', '348', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Jurug'),
      ('71177e22-a4d1-11eb-887d-3d1cd7e0deb7', '349', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Karangnongko'),
      ('7119176e-a4d1-11eb-887d-3d1cd7e0deb7', '350', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Butuh'),
      ('711ab628-a4d1-11eb-887d-3d1cd7e0deb7', '351', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Kragilan'),
      ('711c4510-a4d1-11eb-887d-3d1cd7e0deb7', '352', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Brajan'),
      ('711dd470-a4d1-11eb-887d-3d1cd7e0deb7', '353', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Metuk'),
      ('711f6380-a4d1-11eb-887d-3d1cd7e0deb7', '354', NULL, NULL, '1657d032-a4ad-11eb-887d-3d1cd7e0deb7', 'Dlingo'),
      ('7120f0ce-a4d1-11eb-887d-3d1cd7e0deb7', '355', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Kopen'),
      ('71229064-a4d1-11eb-887d-3d1cd7e0deb7', '356', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Doplang'),
      ('71241f10-a4d1-11eb-887d-3d1cd7e0deb7', '357', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Kadireso'),
      ('7125aee8-a4d1-11eb-887d-3d1cd7e0deb7', '358', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Nepen'),
      ('712740be-a4d1-11eb-887d-3d1cd7e0deb7', '359', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Sudimoro'),
      ('7128daa0-a4d1-11eb-887d-3d1cd7e0deb7', '360', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Bangsalan'),
      ('712a8094-a4d1-11eb-887d-3d1cd7e0deb7', '361', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Salakan'),
      ('712c138c-a4d1-11eb-887d-3d1cd7e0deb7', '362', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Teras'),
      ('712da468-a4d1-11eb-887d-3d1cd7e0deb7', '363', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Randusari'),
      ('712f37f6-a4d1-11eb-887d-3d1cd7e0deb7', '364', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Majolegi'),
      ('7130da8e-a4d1-11eb-887d-3d1cd7e0deb7', '365', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Gumukrejo'),
      ('71326fb6-a4d1-11eb-887d-3d1cd7e0deb7', '366', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Tawangsari'),
      ('71341262-a4d1-11eb-887d-3d1cd7e0deb7', '367', NULL, NULL, '1657ddca-a4ad-11eb-887d-3d1cd7e0deb7', 'Krasak'),
      ('7135abcc-a4d1-11eb-887d-3d1cd7e0deb7', '368', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kateguhan'),
      ('713741c6-a4d1-11eb-887d-3d1cd7e0deb7', '369', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Manjung'),
      ('7138d69e-a4d1-11eb-887d-3d1cd7e0deb7', '370', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Gombang'),
      ('713a6c52-a4d1-11eb-887d-3d1cd7e0deb7', '371', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Tegalrejo'),
      ('713c01b6-a4d1-11eb-887d-3d1cd7e0deb7', '372', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Tlawong'),
      ('713d9864-a4d1-11eb-887d-3d1cd7e0deb7', '373', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Jenengan'),
      ('713f2986-a4d1-11eb-887d-3d1cd7e0deb7', '374', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Cepoko Sawit'),
      ('7140c12e-a4d1-11eb-887d-3d1cd7e0deb7', '375', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kemasan'),
      ('71425692-a4d1-11eb-887d-3d1cd7e0deb7', '376', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Jatirejo'),
      ('7143e926-a4d1-11eb-887d-3d1cd7e0deb7', '377', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Bendosari'),
      ('714581c8-a4d1-11eb-887d-3d1cd7e0deb7', '378', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Karangduren'),
      ('71473cfc-a4d1-11eb-887d-3d1cd7e0deb7', '379', NULL, NULL, '1657ec5c-a4ad-11eb-887d-3d1cd7e0deb7', 'Guwokajen'),
      ('7148db3e-a4d1-11eb-887d-3d1cd7e0deb7', '380', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Dukuh'),
      ('714a767e-a4d1-11eb-887d-3d1cd7e0deb7', '381', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Jipangan'),
      ('714c1dbc-a4d1-11eb-887d-3d1cd7e0deb7', '382', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Jembungan'),
      ('714db726-a4d1-11eb-887d-3d1cd7e0deb7', '383', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Sambon'),
      ('714f4ba4-a4d1-11eb-887d-3d1cd7e0deb7', '384', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Kuwiran'),
      ('7150e108-a4d1-11eb-887d-3d1cd7e0deb7', '385', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Cangkringan'),
      ('715285a8-a4d1-11eb-887d-3d1cd7e0deb7', '386', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngaru-aru'),
      ('71542372-a4d1-11eb-887d-3d1cd7e0deb7', '387', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Bendan'),
      ('7155be26-a4d1-11eb-887d-3d1cd7e0deb7', '388', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Ketaon'),
      ('7157554c-a4d1-11eb-887d-3d1cd7e0deb7', '389', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Banyudono'),
      ('7158ef10-a4d1-11eb-887d-3d1cd7e0deb7', '390', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Batan'),
      ('715a82a8-a4d1-11eb-887d-3d1cd7e0deb7', '391', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Denggungan'),
      ('715c18ac-a4d1-11eb-887d-3d1cd7e0deb7', '392', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Bangak'),
      ('715dabe0-a4d1-11eb-887d-3d1cd7e0deb7', '393', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Trayu'),
      ('715f5292-a4d1-11eb-887d-3d1cd7e0deb7', '394', NULL, NULL, '1657fe40-a4ad-11eb-887d-3d1cd7e0deb7', 'Tanjungsari'),
      ('7160ea6c-a4d1-11eb-887d-3d1cd7e0deb7', '395', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Canden'),
      ('7162817e-a4d1-11eb-887d-3d1cd7e0deb7', '396', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Senting'),
      ('716425f6-a4d1-11eb-887d-3d1cd7e0deb7', '397', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Tempursari'),
      ('7165ca46-a4d1-11eb-887d-3d1cd7e0deb7', '398', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Jatisari'),
      ('716762ca-a4d1-11eb-887d-3d1cd7e0deb7', '399', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Glintang'),
      ('7168f73e-a4d1-11eb-887d-3d1cd7e0deb7', '400', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Catur'),
      ('716aa296-a4d1-11eb-887d-3d1cd7e0deb7', '401', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Tawengan'),
      ('716c3a66-a4d1-11eb-887d-3d1cd7e0deb7', '402', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Sambi'),
      ('716ddb50-a4d1-11eb-887d-3d1cd7e0deb7', '403', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Demangan'),
      ('716f72ee-a4d1-11eb-887d-3d1cd7e0deb7', '404', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Kepoh'),
      ('71710ea6-a4d1-11eb-887d-3d1cd7e0deb7', '405', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Jagoan'),
      ('7172b6de-a4d1-11eb-887d-3d1cd7e0deb7', '406', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Babadan'),
      ('71744ee0-a4d1-11eb-887d-3d1cd7e0deb7', '407', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngaglik'),
      ('7175e9da-a4d1-11eb-887d-3d1cd7e0deb7', '408', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Trosobo'),
      ('71778790-a4d1-11eb-887d-3d1cd7e0deb7', '409', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Cermo'),
      ('71791ef2-a4d1-11eb-887d-3d1cd7e0deb7', '410', NULL, NULL, '1658134e-a4ad-11eb-887d-3d1cd7e0deb7', 'Nglembu'),
      ('717ab6f4-a4d1-11eb-887d-3d1cd7e0deb7', '411', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngargorejo'),
      ('717c5432-a4d1-11eb-887d-3d1cd7e0deb7', '412', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Sobokerto'),
      ('717df008-a4d1-11eb-887d-3d1cd7e0deb7', '413', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngesrep'),
      ('717f8eb8-a4d1-11eb-887d-3d1cd7e0deb7', '414', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Gagaksipat'),
      ('71812976-a4d1-11eb-887d-3d1cd7e0deb7', '415', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Donohudan'),
      ('7182c39e-a4d1-11eb-887d-3d1cd7e0deb7', '416', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Sawahan'),
      ('7184638e-a4d1-11eb-887d-3d1cd7e0deb7', '417', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Pandeyan'),
      ('718603d8-a4d1-11eb-887d-3d1cd7e0deb7', '418', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Kismoyoso'),
      ('71879f7c-a4d1-11eb-887d-3d1cd7e0deb7', '419', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Dibal'),
      ('71893aa8-a4d1-11eb-887d-3d1cd7e0deb7', '420', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Sindon'),
      ('718adb9c-a4d1-11eb-887d-3d1cd7e0deb7', '421', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Manggung'),
      ('718c7b5a-a4d1-11eb-887d-3d1cd7e0deb7', '422', NULL, NULL, '165825b4-a4ad-11eb-887d-3d1cd7e0deb7', 'Giriroto'),
      ('718e1690-a4d1-11eb-887d-3d1cd7e0deb7', '423', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kenteng'),
      ('718fb554-a4d1-11eb-887d-3d1cd7e0deb7', '424', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Potronayan'),
      ('71915698-a4d1-11eb-887d-3d1cd7e0deb7', '425', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Sembungan'),
      ('7192f5d4-a4d1-11eb-887d-3d1cd7e0deb7', '426', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Jeron'),
      ('71949420-a4d1-11eb-887d-3d1cd7e0deb7', '427', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Ketitang'),
      ('719635d2-a4d1-11eb-887d-3d1cd7e0deb7', '428', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Rembun'),
      ('7197d928-a4d1-11eb-887d-3d1cd7e0deb7', '429', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Guli'),
      ('71997576-a4d1-11eb-887d-3d1cd7e0deb7', '430', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Tegalgiri'),
      ('719b187c-a4d1-11eb-887d-3d1cd7e0deb7', '431', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Bendo'),
      ('719cb740-a4d1-11eb-887d-3d1cd7e0deb7', '432', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Keyongan'),
      ('719e6216-a4d1-11eb-887d-3d1cd7e0deb7', '433', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Pojok'),
      ('71a00c60-a4d1-11eb-887d-3d1cd7e0deb7', '434', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Glonggong'),
      ('71a1ab38-a4d1-11eb-887d-3d1cd7e0deb7', '435', NULL, NULL, '1658361c-a4ad-11eb-887d-3d1cd7e0deb7', 'Pulutan'),
      ('71a34c54-a4d1-11eb-887d-3d1cd7e0deb7', '436', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Pelem'),
      ('71a4f338-a4d1-11eb-887d-3d1cd7e0deb7', '437', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Bendungan'),
      ('71a6913e-a4d1-11eb-887d-3d1cd7e0deb7', '438', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Temon'),
      ('71a834f8-a4d1-11eb-887d-3d1cd7e0deb7', '439', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Teter'),
      ('71a9d47a-a4d1-11eb-887d-3d1cd7e0deb7', '440', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Simo'),
      ('71ab7654-a4d1-11eb-887d-3d1cd7e0deb7', '441', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Walen'),
      ('71ad297c-a4d1-11eb-887d-3d1cd7e0deb7', '442', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Pentur'),
      ('71aecb56-a4d1-11eb-887d-3d1cd7e0deb7', '443', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Gunung'),
      ('71b0787a-a4d1-11eb-887d-3d1cd7e0deb7', '444', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Talakbroto'),
      ('71b219fa-a4d1-11eb-887d-3d1cd7e0deb7', '445', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Kedunglengkong'),
      ('71b3c570-a4d1-11eb-887d-3d1cd7e0deb7', '446', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Blagung'),
      ('71b56510-a4d1-11eb-887d-3d1cd7e0deb7', '447', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Sumber'),
      ('71b7056e-a4d1-11eb-887d-3d1cd7e0deb7', '448', NULL, NULL, '165845e4-a4ad-11eb-887d-3d1cd7e0deb7', 'Wates'),
      ('71b8a874-a4d1-11eb-887d-3d1cd7e0deb7', '449', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Manyaran'),
      ('71ba4f80-a4d1-11eb-887d-3d1cd7e0deb7', '450', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Sempulur'),
      ('71bbf290-a4d1-11eb-887d-3d1cd7e0deb7', '451', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Klumpit'),
      ('71bd9848-a4d1-11eb-887d-3d1cd7e0deb7', '452', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Pinggir'),
      ('71bf398c-a4d1-11eb-887d-3d1cd7e0deb7', '453', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Bantengan'),
      ('71c0e26e-a4d1-11eb-887d-3d1cd7e0deb7', '454', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Tegalsari'),
      ('71c28934-a4d1-11eb-887d-3d1cd7e0deb7', '455', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Sranten'),
      ('71c443dc-a4d1-11eb-887d-3d1cd7e0deb7', '456', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Grogolan'),
      ('71c5e638-a4d1-11eb-887d-3d1cd7e0deb7', '457', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Mojosari'),
      ('71c786b4-a4d1-11eb-887d-3d1cd7e0deb7', '458', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Pengkol'),
      ('71c92bcc-a4d1-11eb-887d-3d1cd7e0deb7', '459', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Karangkepoh'),
      ('71cad382-a4d1-11eb-887d-3d1cd7e0deb7', '460', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Sendang'),
      ('71cc82cc-a4d1-11eb-887d-3d1cd7e0deb7', '461', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Kebonan'),
      ('71ce28e8-a4d1-11eb-887d-3d1cd7e0deb7', '462', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Klari'),
      ('71cfcb12-a4d1-11eb-887d-3d1cd7e0deb7', '463', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Bangkok'),
      ('71d21534-a4d1-11eb-887d-3d1cd7e0deb7', '464', NULL, NULL, '165853fe-a4ad-11eb-887d-3d1cd7e0deb7', 'Dologan'),
      ('71d3da4a-a4d1-11eb-887d-3d1cd7e0deb7', '465', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Kalangan'),
      ('71d57e40-a4d1-11eb-887d-3d1cd7e0deb7', '466', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Sendangrejo'),
      ('71d72588-a4d1-11eb-887d-3d1cd7e0deb7', '467', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Tanjung'),
      ('71d8c99c-a4d1-11eb-887d-3d1cd7e0deb7', '468', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Jaten'),
      ('71da6f0e-a4d1-11eb-887d-3d1cd7e0deb7', '469', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Blumbang'),
      ('71dc17dc-a4d1-11eb-887d-3d1cd7e0deb7', '470', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Sangge'),
      ('71ddbfba-a4d1-11eb-887d-3d1cd7e0deb7', '471', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Banyuurip'),
      ('71df6568-a4d1-11eb-887d-3d1cd7e0deb7', '472', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Bade'),
      ('71e10986-a4d1-11eb-887d-3d1cd7e0deb7', '473', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Klego'),
      ('71e2b056-a4d1-11eb-887d-3d1cd7e0deb7', '474', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Gondanglegi'),
      ('71e4550a-a4d1-11eb-887d-3d1cd7e0deb7', '475', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Karanggatak'),
      ('71e5fb76-a4d1-11eb-887d-3d1cd7e0deb7', '476', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Sumber Agung'),
      ('71e7ab2e-a4d1-11eb-887d-3d1cd7e0deb7', '477', NULL, NULL, '16586146-a4ad-11eb-887d-3d1cd7e0deb7', 'Karangmojo'),
      ('71e953e8-a4d1-11eb-887d-3d1cd7e0deb7', '478', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Pakel'),
      ('71eafff4-a4d1-11eb-887d-3d1cd7e0deb7', '479', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Gondangrawe'),
      ('71eca9c6-a4d1-11eb-887d-3d1cd7e0deb7', '480', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Sempu'),
      ('71ee535c-a4d1-11eb-887d-3d1cd7e0deb7', '481', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Beji'),
      ('71effac2-a4d1-11eb-887d-3d1cd7e0deb7', '482', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Mojo'),
      ('71f1a49e-a4d1-11eb-887d-3d1cd7e0deb7', '483', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Senggrong'),
      ('71f34c22-a4d1-11eb-887d-3d1cd7e0deb7', '484', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Kedungdowo'),
      ('71f4f4c8-a4d1-11eb-887d-3d1cd7e0deb7', '485', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Kacangan'),
      ('71f6a548-a4d1-11eb-887d-3d1cd7e0deb7', '486', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Andong'),
      ('71f84f10-a4d1-11eb-887d-3d1cd7e0deb7', '487', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Munggur'),
      ('71f9f662-a4d1-11eb-887d-3d1cd7e0deb7', '488', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Pakang'),
      ('71fb9d82-a4d1-11eb-887d-3d1cd7e0deb7', '489', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Pranggong'),
      ('71fd41aa-a4d1-11eb-887d-3d1cd7e0deb7', '490', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Kunti'),
      ('71fef176-a4d1-11eb-887d-3d1cd7e0deb7', '491', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Pelemrejo'),
      ('7200a480-a4d1-11eb-887d-3d1cd7e0deb7', '492', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Semawung'),
      ('720250a0-a4d1-11eb-887d-3d1cd7e0deb7', '493', NULL, NULL, '16586e52-a4ad-11eb-887d-3d1cd7e0deb7', 'Kadipaten'),
      ('7203fa22-a4d1-11eb-887d-3d1cd7e0deb7', '494', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Watugede'),
      ('7205a87c-a4d1-11eb-887d-3d1cd7e0deb7', '495', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kedungrejo'),
      ('720766da-a4d1-11eb-887d-3d1cd7e0deb7', '496', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Sarimulyo'),
      ('72090f12-a4d1-11eb-887d-3d1cd7e0deb7', '497', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Klewor'),
      ('720ace4c-a4d1-11eb-887d-3d1cd7e0deb7', '498', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Bawu'),
      ('720d0b80-a4d1-11eb-887d-3d1cd7e0deb7', '499', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kendel'),
      ('720efa4e-a4d1-11eb-887d-3d1cd7e0deb7', '500', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kauman'),
      ('7210e2be-a4d1-11eb-887d-3d1cd7e0deb7', '501', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Lemahireng'),
      ('7212a356-a4d1-11eb-887d-3d1cd7e0deb7', '502', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Guwo'),
      ('72146010-a4d1-11eb-887d-3d1cd7e0deb7', '503', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kemusu'),
      ('72161bb2-a4d1-11eb-887d-3d1cd7e0deb7', '504', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Genengsari'),
      ('7217e97e-a4d1-11eb-887d-3d1cd7e0deb7', '505', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Kedungmulyo'),
      ('7219aa48-a4d1-11eb-887d-3d1cd7e0deb7', '506', NULL, NULL, '16587b7c-a4ad-11eb-887d-3d1cd7e0deb7', 'Wanoharjo'),
      ('721b767a-a4d1-11eb-887d-3d1cd7e0deb7', '507', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngablak'),
      ('721d3a5a-a4d1-11eb-887d-3d1cd7e0deb7', '508', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Karangjati'),
      ('721f0df8-a4d1-11eb-887d-3d1cd7e0deb7', '509', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Ketoyan'),
      ('7220cefe-a4d1-11eb-887d-3d1cd7e0deb7', '510', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Bolo'),
      ('7222990a-a4d1-11eb-887d-3d1cd7e0deb7', '511', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Banyusri'),
      ('7224711c-a4d1-11eb-887d-3d1cd7e0deb7', '512', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Gosono'),
      ('72265cde-a4d1-11eb-887d-3d1cd7e0deb7', '513', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Wonosegoro'),
      ('72283860-a4d1-11eb-887d-3d1cd7e0deb7', '514', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Bandung'),
      ('722a2f8a-a4d1-11eb-887d-3d1cd7e0deb7', '515', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Kedungpilang'),
      ('722bfba8-a4d1-11eb-887d-3d1cd7e0deb7', '516', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Kalinanas'),
      ('722dc816-a4d1-11eb-887d-3d1cd7e0deb7', '517', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Gilirejo'),
      ('722f8e62-a4d1-11eb-887d-3d1cd7e0deb7', '518', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Jatilawang'),
      ('7231669c-a4d1-11eb-887d-3d1cd7e0deb7', '519', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Garangan'),
      ('723327d4-a4d1-11eb-887d-3d1cd7e0deb7', '520', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Bojong'),
      ('7234f208-a4d1-11eb-887d-3d1cd7e0deb7', '521', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Bercak'),
      ('7236a8d2-a4d1-11eb-887d-3d1cd7e0deb7', '522', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Bengle'),
      ('723873f6-a4d1-11eb-887d-3d1cd7e0deb7', '523', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Gunungsari'),
      ('723a2ab6-a4d1-11eb-887d-3d1cd7e0deb7', '524', NULL, NULL, '16588860-a4ad-11eb-887d-3d1cd7e0deb7', 'Repaking'),
      ('723be45a-a4d1-11eb-887d-3d1cd7e0deb7', '525', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Sambeng'),
      ('723d9476-a4d1-11eb-887d-3d1cd7e0deb7', '526', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Krobokan'),
      ('723f43b6-a4d1-11eb-887d-3d1cd7e0deb7', '527', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngaren'),
      ('7240f530-a4d1-11eb-887d-3d1cd7e0deb7', '528', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Kalimati'),
      ('7242a83a-a4d1-11eb-887d-3d1cd7e0deb7', '529', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Kayen'),
      ('72445cfc-a4d1-11eb-887d-3d1cd7e0deb7', '530', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Jerukan'),
      ('72462b7c-a4d1-11eb-887d-3d1cd7e0deb7', '531', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Pilangrejo'),
      ('7247df94-a4d1-11eb-887d-3d1cd7e0deb7', '532', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Cerme'),
      ('7249982a-a4d1-11eb-887d-3d1cd7e0deb7', '533', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Juwangi'),
      ('724b4f58-a4d1-11eb-887d-3d1cd7e0deb7', '534', NULL, NULL, '16589576-a4ad-11eb-887d-3d1cd7e0deb7', 'Ngleses')
    ");
  }

  function down()
  {
  }
}
