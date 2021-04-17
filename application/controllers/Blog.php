<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Blogs';
		parent::__construct();
	}

}