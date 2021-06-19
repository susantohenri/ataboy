<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_barangmasuk extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `barangmasuk` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `barang` varchar(36) NOT NULL,
        `jumlah` double NOT NULL DEFAULT '0',
        `satuan` varchar(36) NOT NULL,
        `keterangan` text NOT NULL,
        `barangmasukbulk` varchar(36) NOT NULL,
        `donasi` varchar(36) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `barang` (`barang`),
        KEY `donasi` (`donasi`),
        KEY `satuan` (`satuan`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `barangmasuk`");
  }

}