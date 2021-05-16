<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_pengajuanphoto extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `pengajuanphoto` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `pengajuan` varchar(36) NOT NULL,
        `gambar` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `pengajuanphoto`");
    $dir = 'foto-bencana';
    foreach (scandir($dir) as $file)
    {
      if (!in_array($file, array('.', '..'))) unlink("{$dir}/$file");
    }
  }

}