<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_barangsatuan extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `barangsatuan` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `barang` varchar(36) NOT NULL,
        `nama` varchar(100) NOT NULL,
        `skala` double NOT NULL DEFAULT '0',
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `barangsatuan`");
  }

}