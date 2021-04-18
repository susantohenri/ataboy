<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bencana extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Bencanas';
		parent::__construct();
	}

}