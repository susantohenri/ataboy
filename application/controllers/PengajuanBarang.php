<?php defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanBarang extends MY_Controller
{

	function __construct()
	{
		$this->model = 'PengajuanBarangs';
		parent::__construct();
	}

	function getKebutuhan($barang)
	{
		$kebutuhan = $this->{$this->model}->getKebutuhan($barang);
		$this->load->model('BarangSatuans');
		$satuan = $this->BarangSatuans->getSmallest($barang);
		echo "{$kebutuhan} {$satuan}";
	}
}
