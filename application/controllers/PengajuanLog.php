<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PengajuanLog extends MY_Controller {

	function __construct ()
	{
		$this->model = 'PengajuanLogs';
		parent::__construct();
	}

}