<?php defined('BASEPATH') or exit('No direct script access allowed');

class Donasi extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Donasis';
		parent::__construct();
	}

	public function index()
	{
		$vars = array();
		$model = $this->model;
		if ($post = $this->$model->lastSubmit($this->input->post())) {
			if (isset($post['delete'])) $this->$model->delete($post['delete']);
			else {
				$uuid = $this->$model->save($post);
				if (!isset($post['uuid'])) {
					$created = $this->$model->findOne($uuid);
					$vars['tiket_id'] = $created['tiket_id'];
				}
			}
		}
		$vars['page_name'] = 'table-donasi';
		$vars['js'] = array(
			'jquery.dataTables.min.js',
			'dataTables.bootstrap4.js',
			'table.js'
		);
		$vars['css'] = array('select2.min.css');
		$vars['thead'] = $this->$model->thead;
		$this->loadview('index', $vars);
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
			'form-donasi.js'
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
			'form-donasi.js'
		);
		$this->loadview('index', $vars);
	}

	function select2($model, $field)
	{
		$this->load->model($model);
		if ('BarangSatuans' === $model) echo '{"results":' . json_encode($this->$model->select2WithBarang($field, $this->input->post('term'), $this->input->post('barang'))) . '}';
		else echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
	}
}
