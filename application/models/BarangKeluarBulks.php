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
            barangKeluarBulk.orders
            , barangKeluarBulk.uuid
            , barangKeluarBulk.createdAt
            , admin.nama admin
            , kelurahan.nama kelurahan
          FROM barangKeluarBulk
          LEFT JOIN user admin ON admin.uuid = barangKeluarBulk.createdBy
          LEFT JOIN pengajuan ON pengajuan.uuid = barangKeluarBulk.pengajuan
          LEFT JOIN user kelurahan ON pengajuan.createdBy = kelurahan.uuid) barangKeluarBulkAdminkelurahan
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
        }
        return $form;
    }

    function create($data)
    {
        $data['createdBy'] = $this->session->userdata('uuid');
        if (isset($data['pengajuan']) && strlen($data['pengajuan']) > 0) {
            $this->load->model('Pengajuans');
            $this->Pengajuans->selesai($data['pengajuan']);
        }
        return parent::create($data);
    }
}
