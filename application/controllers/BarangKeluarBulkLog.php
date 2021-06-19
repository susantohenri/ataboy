<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluarBulkLog extends MY_Controller {

	function __construct ()
	{
		$this->model = 'BarangKeluarBulkLogs';
		parent::__construct();
	}

}