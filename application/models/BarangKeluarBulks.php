<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BarangKeluarBulks extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'barangkeluarbulk';
        $this->thead = array(
            (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
            (object) array('mData' => 'createdAt', 'sTitle' => 'Waktu Input', 'width' => '20%'),
            (object) array('mData' => 'admin', 'sTitle' => 'Admin'),
            (object) array('mData' => 'kelurahan', 'sTitle' => 'Kelurahan'),
        );
        $this->form = array(
            array(
                'name' => 'pengajuan',
                'label' => 'Pengajuan',
                'options' => array(),
                'width' => 2,
                'attributes' => array(
                    array('data-autocomplete' => 'true'),
                    array('data-model' => 'Pengajuans'),
                    array('data-field' => 'tiket_id')
                )
            ),
        );
        $this->childs = array(
            array(
                'label' => 'Item',
                'controller' => 'BarangKeluar',
                'model' => 'BarangKeluars'
            ),
            array(
                'label' => 'Log History',
                'controller' => 'BarangKeluarBulkLog',
                'model' => 'BarangKeluarBulkLogs'
            ),
        );
    }

    function dt()
    {
        return $this->datatables
            ->select('orders')
            ->select('uuid')
            ->select('createdAt')
            ->select('admin')
            ->select('kelurahan')
            ->from("
          (SELECT
            {$this->table}.orders
            , {$this->table}.uuid
            , {$this->table}.createdAt
            , admin.nama admin
            , kelurahan.nama kelurahan
          FROM {$this->table}
          LEFT JOIN user admin ON admin.uuid = {$this->table}.createdBy
          LEFT JOIN pengajuan ON pengajuan.uuid = {$this->table}.pengajuan
          LEFT JOIN user kelurahan ON pengajuan.createdBy = kelurahan.uuid) {$this->table}Adminkelurahan
        ")
            ->generate();
    }

    function getForm($uuid = false, $isSubform = false)
    {
        $form = parent::getForm($uuid, $isSubform);
        if (false !== $uuid) {
            $form = array_map(function ($field) {
                if ('pengajuan' === $field['name']) {
                    $field['attr'] .= ' disabled="disabled"';
                }
                return $field;
            }, $form);
        } else {
            unset($this->childs[1]); // HIDE LOG
        }
        return $form;
    }

    function save($data)
    {
        unset($this->childs[1]);
        return parent::save($data);
    }

    function create($data)
    {
        $data['createdBy'] = $this->session->userdata('uuid');
        if (isset($data['pengajuan']) && strlen($data['pengajuan']) > 0) {
            $this->load->model('Pengajuans');
            $this->Pengajuans->selesai($data['pengajuan']);
        }
        $uuid = parent::create($data);
        if (isset($data['pengajuan']) && strlen($data['pengajuan']) > 0) {
            $this->load->model('BarangKeluars');
            $this->BarangKeluars->setPengajuan($uuid, $data['pengajuan']);
        }
        return $uuid;
    }

    function delete($uuid)
    {
      $data = parent::findOne($uuid);
      $result = parent::delete($uuid);
      if (isset($data['pengajuan']) && strlen($data['pengajuan']) > 0) {
        $this->load->model('Pengajuans');
        $this->Pengajuans->rollBackToDiterima($data['pengajuan']);
      }
      return $result;
    }
}
