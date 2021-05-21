<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_donasi extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `donasi` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `createdBy` varchar(36) NOT NULL,
        `status` enum('MENUNGGU PEMBAYARAN', 'MENUNGGU PENGIRIMAN', 'MENUNGGU PENGAMBILAN', 'PROSES PENGIRIMAN', 'SAMPAI TUJUAN', 'VERIFIKASI', 'SELESAI') NOT NULL,
        `metode` enum('DIKIRIM', 'DIAMBIL') NOT NULL,
        `rekening_tujuan` varchar(255) NOT NULL,
        `alamat_tujuan` varchar(255) NOT NULL,
        `alamat_pengirim` varchar(255) NOT NULL,
        `no_resi` varchar(50) NOT NULL,
        `tiket_id` varchar(12) NOT NULL,
        `keterangan` text NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `donasi`");
  }

}