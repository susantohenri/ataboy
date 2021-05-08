<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_blog extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `blog` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `judul` varchar(255) NOT NULL,
        `isi` varchar(255) NOT NULL,
        `gambar` varchar(255) NOT NULL,
        `status` TINYINT(1) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `blog`");
  }

}