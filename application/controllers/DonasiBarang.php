<?php defined('BASEPATH') or exit('No direct script access allowed');

class DonasiBarang extends MY_Controller
{

	function __construct()
	{
		$this->model = 'DonasiBarangs';
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
		$this->loadview('subform-donasibarang', $data);
	}

	function getUuidByDonasi($donasi)
	{
		$uuids = array_map(function ($rec) {
			return $rec->uuid;
		}, $this->{$this->model}->find(array('donasi' => $donasi)));
		echo json_encode($uuids);
	}
}
