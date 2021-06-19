<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_barangmasukkeluarbulklog extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `barangmasukbulklog` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `barangmasukbulk` varchar(36) NOT NULL,
        `actor` varchar(36) NOT NULL,
        `field` varchar(255) NOT NULL,
        `prev` varchar(255) NOT NULL,
        `next` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

    $this->db->query("
      CREATE TABLE `barangkeluarbulklog` (
        `uuid` varchar(36) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `barangkeluarbulk` varchar(36) NOT NULL,
        `actor` varchar(36) NOT NULL,
        `field` varchar(255) NOT NULL,
        `prev` varchar(255) NOT NULL,
        `next` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `barangmasukbulklog`");
    $this->db->query("DROP TABLE IF EXISTS `barangkeluarbulklog`");
  }

}