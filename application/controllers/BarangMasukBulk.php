<?php defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasukBulk extends MY_Controller
{

	function __construct()
	{
		$this->model = 'BarangMasukBulks';
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
		$vars['css'] = array(
			'summernote.min.css'
		);
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'summernote.min.js',
			'form-barangmasukbulk.js'
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
		$vars['css'] = array(
			'summernote.min.css'
		);
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'summernote.min.js',
			'form-barangmasukbulk.js'
		);
		$this->loadview('index', $vars);
	}

	function select2($model, $field)
	{
		$this->load->model($model);
		if ('BarangSatuans' === $model) echo '{"results":' . json_encode($this->$model->select2WithBarang($field, $this->input->post('term'), $this->input->post('barang'))) . '}';
		else if ('Donasis' === $model) echo '{"results":' . json_encode($this->$model->select2forBarangMasukBulk($field, $this->input->post('term'))) . '}';
		else echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
	}
}
