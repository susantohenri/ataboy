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
		$this->load->model('Roles');
		if (strpos($this->Roles->getRole(), 'Admin') > -1) {
			$status = '';
		} else if (!$status = $this->input->get('status')) {
			$status = 'Saya';
		}
		$this->page_title = "Pengajuan {$status}";
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
			'select2.full.min.js',
			'table-pengajuan.js'
		);
		$vars['css'] = array ('select2.min.css');
		$vars['thead'] = $this->$model->thead;
		$this->loadview('index', $vars);
	}

	function create()
	{
		$this->page_title = 'Formulir Pengajuan';
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
			'summernote.min.js',
			'form-pengajuan.js'
		);
		$vars['css'] = array(
			'summernote.min.css',
			'leaflet.css'
		);
		$this->loadview('index', $vars);
	}

	function read($id)
	{
		$this->page_title = 'Detail Pengajuan';
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
			'summernote.min.js',
			'form-pengajuan.js'
		);
		$vars['css'] = array(
			'summernote.min.css',
			'leaflet.css'
		);

		$pengajuan = $this->{$this->model}->findOne($id);
		if ($pengajuan['status'] !== 'DIAJUKAN') {
			$this->load->model(array('Permissions', 'Roles'));
			if (!strpos($this->Roles->getRole(), 'Admin')) {
				$vars['permission'] = array_filter($this->Permissions->getPermissions(), function ($perm) {
					return !in_array($perm, array('update_Pengajuan', 'delete_Pengajuan'));
				});
			}
		}

		$this->loadview('index', $vars);
	}

	function select2($model, $field)
	{
		$this->load->model($model);
		if ('Desas' === $model) echo '{"results":' . json_encode($this->$model->select2WithKec($field, $this->input->post('term'), $this->input->post('kecamatan'))) . '}';
		else if ('BarangSatuans' === $model) echo '{"results":' . json_encode($this->$model->select2WithBarang($field, $this->input->post('term'), $this->input->post('barang'))) . '}';
		else echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
	}
}
