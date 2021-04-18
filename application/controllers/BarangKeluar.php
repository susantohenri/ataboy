<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluar extends MY_Controller {

	function __construct ()
	{
		$this->model = 'BarangKeluars';
		parent::__construct();
	}

}