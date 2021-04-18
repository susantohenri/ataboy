<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_barangkeluar extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `barangkeluar` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `barang` varchar(36) NOT NULL,
        `jumlah` INT(11) NOT NULL,
        `satuan` varchar(36) NOT NULL,
        `keterangan` varchar(255) NOT NULL,
        `pengajuan` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `barang` (`barang`),
        KEY `satuan` (`satuan`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `barangkeluar`");
  }

}