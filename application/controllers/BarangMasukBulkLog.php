<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangMasukBulkLog extends MY_Controller {

	function __construct ()
	{
		$this->model = 'BarangMasukBulkLogs';
		parent::__construct();
	}

}