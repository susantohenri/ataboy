<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_kelurahan extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `kelurahan` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `status` varchar(255) NOT NULL,
        `nama` varchar(255) NOT NULL,
        `alamat` varchar(255) NOT NULL,
        `desa` varchar(36) NOT NULL,
        `nohp` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `desa` (`desa`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `kelurahan`");
  }

}