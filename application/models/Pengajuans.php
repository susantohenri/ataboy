<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuans extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'pengajuan';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'tiket_id', 'sTitle' => 'ID Tiket'),
			(object) array('mData' => 'status', 'sTitle' => 'Status'),
		);
		$this->form = array(
			array(
				'name' => 'tiket_id',
				'width' => 2,
				'label' => 'ID Tiket'
			),
			array(
				'name' => 'status',
				'width' => 2,
				'label' => 'Status',
				'options' => array(
					array('text' => 'DIAJUKAN', 'value' => 'DIAJUKAN'),
					array('text' => 'DIVERIFIKASI', 'value' => 'DIVERIFIKASI'),
					array('text' => 'DITERIMA', 'value' => 'DITERIMA'),
					array('text' => 'DITOLAK', 'value' => 'DITOLAK'),
					array('text' => 'SELESAI', 'value' => 'SELESAI')
				)
			),
			array(
				'name' => 'propinsi',
				'width' => 2,
				'label' => 'Propinsi',
				'value' => 'Jawa Tengah',
				'options' => array(
					array('value' => 'Jawa Tengah', 'text' => 'Jawa Tengah')
				)
			),
			array(
				'name' => 'kabupaten',
				'width' => 2,
				'label' => 'Kabupaten',
				'value' => 'Boyolali',
				'options' => array(
					array('value' => 'Boyolali', 'text' => 'Boyolali')
				)
			),
			array(
				'name' => 'kecamatan',
				'label' => 'Kecamatan',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Kecamatans'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
			array(
				'name' => 'kelurahan',
				'label' => 'Kelurahan',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Desas'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
			array(
				'name' => 'latlng',
				'width' => 2,
				'label' => 'Peta Lokasi',
				'value' => ''
			),
			array(
				'name' => 'latitude',
				'type' => 'hidden',
				'width' => 2,
				'label' => 'Latitude',
			),
			array(
				'name' => 'longitude',
				'type' => 'hidden',
				'width' => 2,
				'label' => 'Longitude',
			),
			array(
				'name' => 'bencana',
				'label' => 'Jenis Bencana',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Bencanas'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
			array(
				'name' => 'jumlah_kk_jiwa',
				'label' => 'Jumlah KK / Jiwa',
				'width' => 2,
				'attributes' => array(
					array('data-number' => 'true')
				)
			),
			array(
				'name' => 'keterangan',
				'width' => 2,
				'label' => 'Keterangan',
				'type' => 'textarea'
			),
		);
		$this->childs = array(
			array(
				'label' => 'Kebutuhan',
				'controller' => 'PengajuanBarang',
				'model' => 'PengajuanBarangs'
			),
			array(
				'label' => 'Bukti Foto',
				'controller' => 'PengajuanPhoto',
				'model' => 'PengajuanPhotos'
			),
		);
	}

	function dt()
	{
		$this->load->model('Roles');
		if ($this->Roles->getRole() === 'Kelurahan') {
			$this->datatables->where('createdBy', $this->session->userdata('uuid'));
		}

		foreach (array('kecamatan', 'kelurahan', 'tiket_id', 'status') as $filter) {
			if ($parameter = $this->input->get($filter)) {
				if (strlen($parameter) > 0) {
					$this->datatables->where($filter, $parameter);
				}
			}
		}
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select("{$this->table}.tiket_id")
			->select("{$this->table}.status");
		return parent::dt();
	}

	function getForm($uuid = false, $isSubform = false)
	{
		$form = parent::getForm($uuid, $isSubform);
		$hide = array('status', 'tiket_id');
		$this->load->model('Roles');
		if (strpos($this->Roles->getRole(), 'Admin') > -1) {
			$disabled = array('tiket_id');
		} else $disabled = array('status', 'tiket_id');

		if (false === $uuid) {
			$form = array_filter(
				$form,
				function ($field) use ($hide) {
					return !in_array($field['name'], $hide);
				}
			);
		}

		$form = array_map(function ($field) use ($disabled) {
			if (in_array($field['name'], $disabled)) {
				$field['attr'] .= ' disabled="disabled"';
			}
			return $field;
		}, $form);

		return $form;
	}

	function save($record)
	{
		unset($record['propinsi']);
		unset($record['kabupaten']);
		return parent::save($record);
	}

	function create($record)
	{
		$record['status'] = 'DIAJUKAN';
		$record['tiket_id'] = $this->generate_tiket_id();
		$record['createdBy'] = $this->session->userdata('uuid');
		return parent::create($record);
	}

	private function generate_tiket_id()
	{
		$tiket_id = $this->generate_random_alphanumeric();
		while ($this->is_tiket_id_exists($tiket_id)) {
			$tiket_id = $this->generate_random_alphanumeric();
		}
		return $tiket_id;
	}

	private function generate_random_alphanumeric()
	{
		return strtoupper(substr(uniqid(), 0, 11));
	}

	function is_tiket_id_exists($tiket_id)
	{
		$found = $this->findOne(array('tiket_id' => $tiket_id));
		return isset($found['uuid']);
	}

	function select2forBarangKeluarBulk($field, $term)
	{
		$this->db->where('status', 'DITERIMA');
		return parent::select2($field, $term);
	}

	function selesai($uuid)
	{
		return $this->db->set('status', 'SELESAI')->where('uuid', $uuid)->update($this->table);
	}
}
