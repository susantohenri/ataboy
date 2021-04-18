<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Donasi extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Donasis';
		parent::__construct();
	}

}