<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BarangKeluars extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'barangkeluar';
        $this->thead = array(
            (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
            (object) array('mData' => 'barang', 'sTitle' => 'Barang'),
        );
        $this->form = array(
            array(
                'name' => 'barang',
                'label' => 'Barang',
                'options' => array(),
                'width' => 4,
                'attributes' => array(
                    array('data-autocomplete' => 'true'),
                    array('data-model' => 'Barangs'),
                    array('data-field' => 'nama'),
                    array('required' => 'required')
                )
            ),
            array(
                'name' => 'jumlah',
                'label' => 'Jumlah',
                'width' => 2,
                'attributes' => array(
                    array('data-number' => 'true'),
                    array('required' => 'required')
                )
            ),
            array(
                'name' => 'satuan',
                'label' => 'Satuan',
                'options' => array(),
                'width' => 2,
                'attributes' => array(
                    array('data-autocomplete' => 'true'),
                    array('data-model' => 'BarangSatuans'),
                    array('data-field' => 'nama'),
                    array('required' => 'required')
                )
            ),
            array(
                'name' => 'keterangan',
                'width' => 3,
                'label' => 'Keterangan',
            )
        );
        $this->childs = array();
    }

    function dt()
    {
        $this->datatables
            ->select("{$this->table}.uuid")
            ->select("{$this->table}.orders")
            ->select('barangkeluar.barang');
        return parent::dt();
    }

    function create($data)
    {
        $result = parent::create($data);
        $this->load->model('RiwayatBarangs');
        $this->RiwayatBarangs->create(array(
            'barangKeluar' => $result,
            'barang' => $data['barang'],
            'jumlah' => $data['jumlah'] * -1,
            'satuan' => $data['satuan']
        ));
        return $result;
    }

    function update($data)
    {
        $result = parent::update($data);
        $this->load->model('RiwayatBarangs');
        $found = $this->RiwayatBarangs->findOne(array('barangKeluar' => $result));
        $this->RiwayatBarangs->update(array(
            'uuid' => $found['uuid'],
            'barangKeluar' => $result,
            'barang' => $data['barang'],
            'jumlah' => $data['jumlah'] * -1,
            'satuan' => $data['satuan']
        ));
        return $result;
    }

    function delete($uuid)
    {
        $this->load->model('RiwayatBarangs');
        $found = $this->RiwayatBarangs->findOne(array('barangKeluar' => $uuid));
        $result = parent::delete($uuid);
        $this->RiwayatBarangs->delete($found['uuid']);
        return $result;
    }

    function setPengajuan($bulkId, $pengajuanId)
    {
        return $this->db
            ->set('pengajuan', $pengajuanId)
            ->where('barangKeluarBulk', $bulkId)
            ->update($this->table);
    }
}
