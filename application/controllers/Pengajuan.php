<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Pengajuans';
		parent::__construct();
	}

	function create()
	{
		$model = $this->model;
		$vars = array();
		$vars['page_name'] = 'form';
		$vars['form']     = $this->$model->getForm();
		$vars['subform'] = $this->$model->getFormChild();
		$vars['uuid'] = '';
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'form-pengajuan.js'
		);
		$this->loadview('index', $vars);
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
			'form-pengajuan.js'
		);
		$this->loadview('index', $vars);
	}

	function select2($model, $field)
	{
		$this->load->model($model);
		if ('Desas' === $model) echo '{"results":' . json_encode($this->$model->select2WithKec($field, $this->input->post('term'), $this->input->post('kecamatan'))) . '}';
		else echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
	}
}
