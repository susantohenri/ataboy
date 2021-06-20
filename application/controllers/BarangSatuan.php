<?php defined('BASEPATH') or exit('No direct script access allowed');

class BarangSatuan extends MY_Controller
{

	function __construct()
	{
		$this->model = 'BarangSatuans';
		parent::__construct();
	}

	function subformread($uuid)
	{
		$data = array();
		$model = $this->model;
		$data['form'] = $this->$model->getForm($uuid, true);
		$data['subformlabel'] = $this->subformlabel;
		$data['controller'] = $this->controller;
		$data['uuid'] = $uuid;
		$data['item'] = $this->{$this->model}->findOne($uuid);

		$deletable = true;
		$relateds = array('BarangMasuks', 'BarangKeluars', 'DonasiBarangs', 'PengajuanBarangs');
		$this->load->model($relateds);
		foreach ($relateds as $relmod) {
			$anyrelation = $this->{$relmod}->find(array('satuan' => $uuid));
			if (count($anyrelation) > 0) $deletable = false;
		}

		if (!$deletable) {
			$this->load->model('Permissions');
			$data['permission'] = array_filter($this->Permissions->getPermissions(), function ($perm) {
				return $perm !== 'delete_BarangSatuan';
			});
		}

		$this->loadview('subform', $data);
	}
}
