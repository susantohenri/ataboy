<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DonasiPhoto extends MY_Controller {

	function __construct ()
	{
		$this->model = 'DonasiPhotos';
		parent::__construct();
	}

}