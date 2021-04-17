<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Kecamatans';
		parent::__construct();
	}

}