<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_pengajuan extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `pengajuan` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `status` enum('DIAJUKAN','DITERIMA','DITOLAK','SELESAI') NOT NULL,
        `kecamatan` varchar(36) NOT NULL,
        `kelurahan` varchar(36) NOT NULL,
        `latitude` varchar(255) NOT NULL,
        `longitude` varchar(255) NOT NULL,
        `bencana` varchar(36) NOT NULL,
        `jumlah_kk_jiwa` INT(11) NOT NULL,
        `tiket_id` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `kecamatan` (`kecamatan`),
        KEY `kelurahan` (`kelurahan`),
        KEY `bencana` (`bencana`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `pengajuan`");
  }

}