<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdminWarehouse extends MY_Controller {

	function __construct ()
	{
		$this->model = 'AdminWarehouses';
		parent::__construct();
	}

}