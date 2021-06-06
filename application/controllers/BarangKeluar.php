<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluar extends MY_Controller {

    function __construct() {
        $this->model = 'BarangKeluars';
        parent::__construct();
    }

    function subformcreate($pengajuanBarang = null) {
        $model = $this->model;
        $vars = array();
        $vars['form'] = $this->$model->getForm(false, true);
        if (null !== $pengajuanBarang) {
            $this->load->model('PengajuanBarangs');
            $pengbar = $this->PengajuanBarangs->findOne($pengajuanBarang);
            $vars['form'] = array_map(function ($field) use ($pengbar) {
                switch ($field['name']) {
                    case 'jumlah':
                        $field['value'] = $pengbar['jumlah'];
                        break;
                    case 'barang':
                        $this->load->model('Barangs');
                        $brg = $this->Barangs->findOne($pengbar['barang']);
                        $field['value'] = $brg['uuid'];
                        $field['options'] = array(
                            array('text' => $brg['nama'], 'value' => $brg['uuid'])
                        );
                        break;
                    case 'satuan':
                        $this->load->model('BarangSatuans');
                        $sat = $this->BarangSatuans->findOne($pengbar['satuan']);
                        $field['value'] = $sat['uuid'];
                        $field['options'] = array(
                            array('text' => $sat['nama'], 'value' => $sat['uuid'])
                        );
                        break;
                }
                return $field;
            }, $vars['form']);
        }
        $vars['subformlabel'] = $this->subformlabel;
        $vars['controller'] = $this->controller;
        $vars['uuid'] = '';
        $this->loadview('subform', $vars);
    }

}
