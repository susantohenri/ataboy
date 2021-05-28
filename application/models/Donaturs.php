<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Donaturs extends MY_Model {

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
        'name' => 'alamat',
        'label' => 'Alamat'
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
          array('value' => '1', 'text' => 'active'),
          array('value' => '0', 'text' => 'inactive')
        )
      ),
      array(
        'type' => 'password',
        'name' => 'password',
        'label' => 'Password'
      )
    );
    $this->childs = array();
  }

  function save($data)
  {
    if (strlen($data['password']) > 0) {
      $data['password'] = md5($data['password']);
    } else unset($data['password']);

    $this->load->model('Roles');
    $superadmin = $this->Roles->findOne(array('name' => 'Donatur'));
    $data['role'] = $superadmin['uuid'];

    return parent::save($data);
  }

  function create ($data)
  {
    if (!isset ($data['status'])) $data['status'] = 1;
    return parent::create($data);
  }

  function findOne($param)
  {
    $record = parent::findOne($param);
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
      ->where('role.name', 'Donatur');
    return parent::dt();
  }

}