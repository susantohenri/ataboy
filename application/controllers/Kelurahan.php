<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahan extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Kelurahans';
		parent::__construct();
	}

}