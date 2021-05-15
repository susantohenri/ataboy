<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Pengajuans';
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
				if (!isset ($post['uuid']))
				{
					$created = $this->$model->findOne($uuid);
					$vars['tiket_id'] = $created['tiket_id'];
				}
			}
		}
		$vars['page_name'] = 'table-pengajuan';
		$vars['js'] = array(
			'jquery.dataTables.min.js',
			'dataTables.bootstrap4.js',
			'table.js'
		);
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
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'leaflet.js',
			'form-pengajuan.js'
		);
		$vars['css'] = array ('leaflet.css');
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
			'leaflet.js',
			'form-pengajuan.js'
		);
		$vars['css'] = array ('leaflet.css');
		$this->loadview('index', $vars);
	}

	function select2($model, $field)
	{
		$this->load->model($model);
		if ('Desas' === $model) echo '{"results":' . json_encode($this->$model->select2WithKec($field, $this->input->post('term'), $this->input->post('kecamatan'))) . '}';
		else echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
	}
}
