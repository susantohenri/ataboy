<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kecamatans extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'kecamatan';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
        'attributes' => array(
          array('required' => 'required')
        )
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('kecamatan.nama');
    return parent::dt();
  }
  
  function select2($field, $term)
  {
      $this->load->model('Roles');
      if (strpos($this->Roles->getRole(), 'Kelurahan') > -1){
          $kec[] = $this->db
                ->where("desa.uuid", $this->session->userdata('desa'))
                ->select("$this->table.uuid as id", false)
                ->select("$this->table.$field as text", false)
                ->join("desa", "$this->table.uuid = desa.kec", "left")
                ->get($this->table)->row();
          return $kec;
      }
      return parent::select2($field, $term);
  }
}
