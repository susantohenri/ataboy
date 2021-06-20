<?php defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Barangs';
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
		$relateds = array('BarangMasuks', 'BarangKeluars', 'DonasiBarangs', 'PengajuanBarangs');
		$this->load->model($relateds);
		foreach ($relateds as $relmod) {
			$anyrelation = $this->{$relmod}->find(array('barang' => $id));
			if (count($anyrelation) > 0) $deletable = false;
		}

		if (!$deletable) {
			$this->load->model('Permissions');
			$vars['permission'] = array_filter($this->Permissions->getPermissions(), function ($perm) {
				return $perm !== 'delete_Barang';
			});
		}

		$this->loadview('index', $vars);
	}
}
