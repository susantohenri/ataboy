<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bencana extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Bencanas';
		parent::__construct();
	}

	function read($id)
	{
		$vars = array();
		$vars['page_name'] = 'form';
		$model = $this->model;
		$vars['form'] = $this->$model->getForm($id);
		$vars['subform'] = $this->$model->getFormChild($id);
		$vars['uuid'] = $id;
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'form.js'
		);

		$deletable = true;
		$relateds = array('Pengajuans');
		$this->load->model($relateds);
		foreach ($relateds as $relmod) {
			$anyrelation = $this->{$relmod}->find(array('bencana' => $id));
			if (count($anyrelation) > 0) $deletable = false;
		}

		if (!$deletable) {
			$this->load->model('Permissions');
			$vars['permission'] = array_filter($this->Permissions->getPermissions(), function ($perm) {
				return $perm !== 'delete_Bencana';
			});
		}

		$this->loadview('index', $vars);
	}
}
