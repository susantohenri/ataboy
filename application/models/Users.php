<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'user';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'username', 'sTitle' => 'Username'),
      (object) array('mData' => 'role_name', 'sTitle' => 'Role'),
    );
    $this->form  = array ();

    $this->form[]= array(
    	'name' => 'username',
    	'label'=> 'Username'
    );

    $this->form[]= array(
    	'name' => 'nama',
    	'label'=> 'Nama'
    );

    $this->form[]= array(
    	'type' => 'password',
    	'name' => 'password',
    	'label'=> 'Password'
    );

    $this->form[]= array(
        'type' => 'password',
        'name' => 'confirm_password',
        'label'=> 'Confirm Password'
    );
  }

  function delete ($uuid) {
    $user = $this->findOne($uuid);
    if ('admin' !== $user['username']) return parent::delete($uuid);
  }

  function save ($data) {
    if (strlen ($data['password']) > 0) {
      if ($data['password'] !== $data['confirm_password']) return array('error' => array('message' => 'Password tidak sesuai'));
      else $data['password'] = md5($data['password']);
    } else unset ($data['password']);
    unset ($data['confirm_password']);

    $this->load->model('Roles');
    $superadmin = $this->Roles->findOne(array('name' => 'Super Admin'));
    $data['role'] = $superadmin['uuid'];

    return parent::save ($data);
  }

  function findOne ($param) {
    $record = parent::findOne ($param);
    $record['confirm_password'] = '';
    return $record;
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select("{$this->table}.username")
      ->select('role.name as role_name', false)
      ->join('role', 'role.uuid = user.role', 'left');
    return parent::dt();
  }

}