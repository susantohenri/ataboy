<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_riwayatbarang extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `riwayatbarang` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `barangMasuk` varchar(36) NOT NULL,
        `barangKeluar` varchar(36) NOT NULL,
        `barang` varchar(36) NOT NULL,
        `jumlah` double NOT NULL DEFAULT '0',
        `satuan` varchar(36) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `riwayatbarang`");
  }

}