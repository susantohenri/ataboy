<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DonasiLog extends MY_Controller {

	function __construct ()
	{
		$this->model = 'DonasiLogs';
		parent::__construct();
	}

}