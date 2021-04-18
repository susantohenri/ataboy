<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SuperAdmin extends MY_Controller {

	function __construct ()
	{
		$this->model = 'SuperAdmins';
		parent::__construct();
	}

}