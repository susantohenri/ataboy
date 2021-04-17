<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PengajuanBarang extends MY_Controller {

	function __construct ()
	{
		$this->model = 'PengajuanBarangs';
		parent::__construct();
	}

}