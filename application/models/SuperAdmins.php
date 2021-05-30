<?php defined('BASEPATH') or exit('No direct script access allowed');

class SuperAdmins extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'user';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),
    );
    $this->form = array(
      array(
        'name' => 'username',
        'label' => 'Alamat Email',
        'attributes' => array(
          array('required' => 'required')
        )
      ),
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
        'attributes' => array(
          array('required' => 'required')
        )
      ),
      array(
        'type' => 'password',
        'name' => 'password',
        'label' => 'Password',
        'attributes' => array(
          array('required' => 'required')
        ),
        array(
          'name' => 'status',
          'width' => 2,
          'label' => 'Status',
          'options' => array(
            array('value' => '1', 'text' => 'ACTIVE'),
            array('value' => '0', 'text' => 'INACTIVE')
          )
        )
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
    $superadmin = $this->Roles->findOne(array('name' => 'Super Admin'));
    $data['role'] = $superadmin['uuid'];

    return parent::save($data);
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
      ->join('role', 'user.role = role.uuid', 'left')
      ->where('role.name', 'Super Admin');
    return parent::dt();
  }
}
