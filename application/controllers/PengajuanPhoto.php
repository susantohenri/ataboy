<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PengajuanPhoto extends MY_Controller {

	function __construct ()
	{
		$this->model = 'PengajuanPhotos';
		parent::__construct();
	}

}