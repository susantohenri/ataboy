<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kelurahans extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = 'user';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'nama', 'sTitle' => 'Nama'),
			(object) array('mData' => 'status', 'sTitle' => 'Status'),
		);
		$this->form = array(
			array(
				'name' => 'username',
				'label' => 'Alamat Email'
			),
			array(
				'name' => 'nama',
				'width' => 2,
				'label' => 'Nama',
			),
			array(
				'name' => 'desa',
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
				'name' => 'nohp',
				'label' => 'No. Handphone'
			),
			array(
				'name' => 'status',
				'width' => 2,
				'label' => 'Status',
				'options' => array(
					array('value' => 1, 'text' => 'active'),
					array('value' => 0, 'text' => 'inactive')
				)
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'label' => 'Password'
			),
			array(
				'type' => 'password',
				'name' => 'confirm_password',
				'label' => 'Confirm Password'
			)
		);
		$this->childs = array();
	}

	function save($data)
	{
		if (strlen($data['password']) > 0) {
			if ($data['password'] !== $data['confirm_password']) return array('error' => array('message' => 'Password tidak sesuai'));
			else $data['password'] = md5($data['password']);
		} else unset($data['password']);
		unset($data['confirm_password']);

		$this->load->model('Roles');
		$superadmin = $this->Roles->findOne(array('name' => 'Kelurahan'));
		$data['role'] = $superadmin['uuid'];

		return parent::save($data);
	}

	function findOne($param)
	{
		$record = parent::findOne($param);
		$record['confirm_password'] = '';
		return $record;
	}

	function dt()
	{
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select('nama')
			->select("IF(1=status, 'active', 'inactive') status")
			->join('role', 'user.role = role.uuid', 'left')
			->where('role.name', 'Kelurahan');
		return parent::dt();
	}
}
