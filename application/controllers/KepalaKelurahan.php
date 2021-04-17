<?php defined('BASEPATH') OR exit('No direct script access allowed');

class KepalaKelurahan extends MY_Controller {

	function __construct ()
	{
		$this->model = 'KepalaKelurahans';
		parent::__construct();
	}

}