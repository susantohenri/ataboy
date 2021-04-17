<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Barangs';
		parent::__construct();
	}

}