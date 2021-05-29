<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_barangmasukbulk extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `barangmasukbulk` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `donasi` varchar(36) NOT NULL,
        `keterangan` text NOT NULL,
        `createdBy` varchar(36) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `donasi` (`donasi`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `barangmasukbulk`");
  }

}