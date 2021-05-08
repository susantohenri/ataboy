<?php defined('BASEPATH') or exit('No direct script access allowed');

class Blogs extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'blog';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'judul', 'sTitle' => 'Judul'),

    );
    $this->form = array(
      array(
        'name' => 'judul',
        'width' => 2,
        'label' => 'Judul',
      ),
      array(
        'name' => 'isi',
        'width' => 2,
        'label' => 'Isi',
        'type' => 'textarea'
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
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('blog.judul');
    return parent::dt();
  }
}
