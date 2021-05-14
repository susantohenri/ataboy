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
				'name' => 'propinsi',
				'width' => 2,
				'label' => 'Propinsi',
				'value' => 'Jawa Tengah'
			),
			array(
				'name' => 'kabupaten',
				'width' => 2,
				'label' => 'Kabupaten',
				'value' => 'Boyolali'
			),
			array(
				'name' => 'kecamatan',
				'label' => 'Kecamatan',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Kecamatans'),
					array('data-field' => 'nama')
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
					array('data-field' => 'nama')
				)
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
					array('data-field' => 'nama')
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
				'name' => 'tiket_id',
				'width' => 2,
				'label' => 'ID Tiket',
				'value' => strtoupper(substr(uniqid(), 0, 8))
			),
			array(
				'name' => 'status',
				'width' => 2,
				'label' => 'Status',
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
		$hide = array('status');
		$disabled = array('status', 'tiket_id', 'propinsi', 'kabupaten');

		if (false === $uuid) {
			$form = array_filter(
				$form,
				function ($field) use ($hide) {
					return !in_array($field['name'], $hide);
				}
			);
		} else {
			$form = array_map(function ($field) use ($hide) {
				if ('jumlah_kk_jiwa' === $field['name']) {
					$field['value'] = number_format($field['value'], 0);
				}
				return $field;
			}, $form);
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
		return parent::create($record);
	}
}
