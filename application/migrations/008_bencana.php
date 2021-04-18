<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_bencana extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `bencana` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `nama` varchar(255) NOT NULL,
        `status` TINYINT(1) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `bencana`");
  }

}