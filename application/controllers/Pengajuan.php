<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Pengajuans';
		parent::__construct();
	}

}