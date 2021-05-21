<?php defined('BASEPATH') or exit('No direct script access allowed');

class Donasis extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'donasi';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'tiket_id', 'sTitle' => 'ID'),
      (object) array('mData' => 'status', 'sTitle' => 'Status'),
    );
    $this->form = array(
      array(
        'name' => 'status',
        'width' => 2,
        'label' => 'Status',
      ),
      array(
        'name' => 'metode',
        'width' => 2,
        'label' => 'Metode Donasi',
        'options' => array(
          array('value' => 'DIKIRIM', 'text' => 'Dikirim'),
          array('value' => 'DIAMBIL', 'text' => 'Diambil')
        )
      ),
      array(
        'name' => 'rekening_tujuan',
        'width' => 2,
        'label' => 'Rekening Tujuan (Optional)',
        'options' => array(
          array('value' => '--', 'text' => '--'),
          array('value' => 'MANDIRI Virtual Account - 8903980801206344', 'text' => 'MANDIRI Virtual Account - 8903980801206344'),
        )
      ),
      array(
        'name' => 'alamat_tujuan',
        'width' => 2,
        'label' => 'Alamat Tujuan (Optional)',
        'options' => array(
          array('value' => '--', 'text' => '--'),
          array('value' => 'BPBD Kabupaten Boyolali. Tegalmulyo, Mojosongo, Boyolali, Boyolali Regency, Central Java 57322', 'text' => 'BPBD Kabupaten Boyolali. Tegalmulyo, Mojosongo, Boyolali, Boyolali Regency, Central Java 57322'),
        )
      ),
      array(
        'name' => 'alamat_pengirim',
        'width' => 2,
        'label' => 'Alamat Pengirim / Pengambilan',
      ),
      array(
        'name' => 'no_resi',
        'width' => 2,
        'label' => 'Kurir / No. Resi (Optional)',
      ),
      array(
        'name' => 'updatedAt',
        'width' => 2,
        'label' => 'Terakhir Update',
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
        'label' => 'Item Donasi',
        'controller' => 'DonasiBarang',
        'model' => 'DonasiBarangs'
      )
    );
  }

  function dt()
  {
		$this->load->model('Roles');
		if ($this->Roles->getRole() === 'Donatur') {
			$this->datatables->where('createdBy', $this->session->userdata('uuid'));
		}

		foreach (array('status') as $filter) {
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
    $hide = array('status', 'tiket_id', 'updatedAt');
    $disabled = array('status', 'tiket_id', 'updatedAt');

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

  function create($record)
  {
    // $record['status'] = 'DIAJUKAN';
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
}
