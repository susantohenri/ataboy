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
        'name' => 'donatur',
        'width' => 2,
        'label' => 'Donatur',
        'value' => '',
        'attributes' => array(
          array('disabled' => 'disabled')
        )
      ),
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
          array('text' => 'MENUNGGU PEMBAYARAN', 'value' => 'MENUNGGU PEMBAYARAN'),
          array('text' => 'MENUNGGU PENGIRIMAN', 'value' => 'MENUNGGU PENGIRIMAN'),
          array('text' => 'MENUNGGU PENGAMBILAN', 'value' => 'MENUNGGU PENGAMBILAN'),
          array('text' => 'PROSES PENGIRIMAN', 'value' => 'PROSES PENGIRIMAN'),
          array('text' => 'SAMPAI TUJUAN', 'value' => 'SAMPAI TUJUAN'),
          array('text' => 'DIVERIFIKASI', 'value' => 'DIVERIFIKASI'),
          array('text' => 'SELESAI', 'value' => 'SELESAI')
        )
      ),
      array(
        'name' => 'metode',
        'width' => 2,
        'label' => 'Metode Donasi',
        'options' => array(
          array('value' => 'DIKIRIM', 'text' => 'DIKIRIM'),
          array('value' => 'DIAMBIL', 'text' => 'DIAMBIL')
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
      ),
      array(
        'label' => 'Item Diterima',
        'controller' => 'BarangMasuk',
        'model' => 'BarangMasuks'
      ),
      array(
        'label' => 'Log History',
        'controller' => 'DonasiLog',
        'model' => 'DonasiLogs'
      )
    );
  }

  function dt()
  {
    $this->load->model('Roles');
    if ($this->Roles->getRole() === 'Donatur') {
      $this->datatables->where('createdBy', $this->session->userdata('uuid'));
    }

    foreach (array('status', 'tiket_id') as $filter) {
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
    // PREVENT CREATE DONASI DIVERIFIKASI/SELESAI CONTAINS BARANG FREE-TEXT
    if (false === $uuid) {
      $this->form = array_map(function ($field) {
        if ('status' === $field['name']) {
          $field['options'] = array_filter($field['options'], function ($option) {
            return !in_array($option['value'], array(
              'DIVERIFIKASI',
              'SELESAI'
            ));
          });
        }
        return $field;
      }, $this->form);
    }

    $form = parent::getForm($uuid, $isSubform);

    $this->load->model('Roles');
    if (strpos($this->Roles->getRole(), 'Admin') > -1) {
      $hide = array('donatur', 'tiket_id', 'updatedAt');
      $disabled = array('tiket_id', 'updatedAt');
    } else {
      $hide = array('donatur', 'status', 'tiket_id', 'updatedAt');
      $disabled = array('status', 'tiket_id', 'updatedAt');
    }

		// DONNASI SELESAI CANNOT GO BACK
    $donasi = $this->findOne($uuid);
		if ($donasi['status'] === 'SELESAI') {
			$disabled[] = 'status';
		}

    if (false === $uuid) {
      unset($this->childs[1]); // HIDE BARANGMASUK
      unset($this->childs[2]); // HIDE DONASILOG
      $form = array_filter(
        $form,
        function ($field) use ($hide) {
          return !in_array($field['name'], $hide);
        }
      );
    } else {
      $form = array_map(function ($field) use ($uuid) {
        if ('donatur' === $field['name']) {
          $donasi = parent::findOne($uuid);
          $this->load->model('Donaturs');
          $donatur = $this->Donaturs->findOne($donasi['createdBy']);
          $field['value'] = "{$donatur['nama']} {$donatur['nohp']}";
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

  function create($record)
  {
    if (!isset($record['status'])) {
      if ('DIAMBIL' === $record['metode']) {
        $record['status'] = 'MENUNGGU PENGAMBILAN';
      } else if ('DIKIRIM' === $record['metode']) {
        if (strlen($record['no_resi']) < 1) {
          $record['status'] = '--' === $record['rekening_tujuan'] ? 'MENUNGGU PENGIRIMAN' : 'MENUNGGU PEMBAYARAN';
        } else {
          $record['status'] = 'PROSES PENGIRIMAN';
        }
      }
    }

    $record['tiket_id'] = $this->generate_tiket_id();
    $record['createdBy'] = $this->session->userdata('uuid');

    $uuid = parent::create($record);
    $this->load->model('DonasiLogs');
    $this->DonasiLogs->create(array(
      'donasi' => $uuid,
      'actor' => $this->session->userdata('uuid'),
      'field' => 'SUBMIT DONASI'
    ));
    return $uuid;
  }

  function update($next)
  {
    unset($this->childs[1]); // HIDE BARANGMASUK
    unset($this->childs[2]); // HIDE DONASILOG
    $prev = parent::findOne($next['uuid']);
    if (!isset($next['status'])) {
      if ('DIKIRIM' === $prev['metode'] && 'DIAMBIL' === $next['metode']) {
        $next['status'] = 'MENUNGGU PENGAMBILAN';
      }
      if ('DIAMBIL' === $prev['metode'] && 'DIKIRIM' === $next['metode']) {
        $next['status'] = strlen($next['no_resi']) < 1 ? 'MENUNGGU PENGIRIMAN' : 'PROSES PENGIRIMAN';
      }

      if (strlen($next['no_resi']) > 0 && 'MENUNGGU PENGIRIMAN' === $prev['status'] && strlen($prev['no_resi']) < 1) {
        $next['status'] = 'PROSES PENGIRIMAN';
      }
    }

    $uuid = parent::update($next);

    // AUTOMATICALLY INSERT GOODS INTO WAREHOUSE
    if ('SELESAI' === $next['status'] && 'SELESAI' !== $prev['status']) {
      $this->load->model(array('BarangMasukBulks', 'DonasiBarangs'));
      $donbars = $this->DonasiBarangs->find(array('donasi' => $uuid));
      if (count($donbars) > 0) $this->BarangMasukBulks->create(array(
        'donasi' => $uuid,
        'BarangMasuk_barang' => implode(',', array_map(function ($donbar) {
            return $donbar->barang;
          }, $donbars)),
        'BarangMasuk_jumlah' => implode(',', array_map(function ($donbar) {
            return $donbar->jumlah;
          }, $donbars)),
        'BarangMasuk_satuan' => implode(',', array_map(function ($donbar) {
            return $donbar->satuan;
          }, $donbars))
      ));
    }

    $this->load->model('DonasiLogs');
    $fieldToScan = array_map(function ($field) {
      return $field['name'];
    }, parent::getForm());
    foreach ($fieldToScan as $field) {
      if (isset($next[$field]) && $prev[$field] !== $next[$field]) {
        $this->DonasiLogs->create(array(
          'donasi' => $next['uuid'],
          'actor' => $this->session->userdata('uuid'),
          'field' => $field,
          'prev' => $prev[$field],
          'next' => $next[$field]
        ));
      }
    }

    return $uuid;
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

  function select2forBarangMasukBulk($field, $term)
  {
    $this->db->where("$this->table.status", 'DIVERIFIKASI');
    return $this->db
      ->select("$this->table.uuid as id", false)
      ->select("CONCAT($field, ' - ', user.nama) as text", false)
      ->join("user", "$this->table.createdBy = user.uuid", "left")
      ->limit(10)
      ->like($field, $term)->get($this->table)->result();
  }

  function selesai($uuid)
  {
    $prev = parent::findOne($uuid);
    $done = $this->db->set('status', 'SELESAI')->where('uuid', $uuid)->update($this->table);
    $this->load->model('DonasiLogs');
    $this->DonasiLogs->create(array(
      'donasi' => $uuid,
      'actor' => $this->session->userdata('uuid'),
      'field' => 'status',
      'prev' => $prev['status'],
      'next' => 'SELESAI'
    ));
    return $done;
  }

  function rollBackToDiverfifikasi($uuid)
  {
    $prev = parent::findOne($uuid);
		if (!$prev) return false;
    $done = $this->db->set('status', 'DIVERIFIKASI')->where('uuid', $uuid)->update($this->table);
    $this->load->model('DonasiLogs');
    $this->DonasiLogs->create(array(
      'donasi' => $uuid,
      'actor' => $this->session->userdata('uuid'),
      'field' => 'status',
      'prev' => $prev['status'],
      'next' => 'DIVERIFIKASI'
    ));
    return $done;
  }

  function delete($uuid)
  {
    parent::delete($uuid);

    // DELETE BARANG-RELATED RECORDS
    $this->load->model('BarangMasukBulks');
    foreach ($this->BarangMasukBulks->find(array('donasi' => $uuid)) as $record) {
      $this->BarangMasukBulks->delete($record->uuid);
    }
  }
}
