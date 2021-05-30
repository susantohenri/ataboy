<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_donasibarang extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `donasibarang` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `donasi` varchar(36) NOT NULL,
        `barang` varchar(36) NOT NULL,
        `jumlah` double NOT NULL DEFAULT '0',
        `satuan` varchar(36) NOT NULL,
        `gambar` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `barang` (`barang`),
        KEY `satuan` (`satuan`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `donasibarang`");
    $dir = 'foto-donasi';
    foreach (scandir($dir) as $file)
    {
      if (!in_array($file, array('.', '..'))) unlink("{$dir}/$file");
    }
  }

}