<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluarBulk extends MY_Controller {

    function __construct() {
        $this->model = 'BarangKeluarBulks';
        parent::__construct();
    }

    function create() {
        $model = $this->model;
        $vars = array();
        $vars['page_name'] = 'form';
        $vars['form'] = $this->$model->getForm();
        $vars['subform'] = $this->$model->getFormChild();
        $vars['uuid'] = '';
        $vars['css'] = array(
//            'summernote.min.css'
        );
        $vars['js'] = array(
            'moment.min.js',
            'bootstrap-datepicker.js',
            'daterangepicker.min.js',
            'select2.full.min.js',
//            'summernote.min.js',
            'form-barangkeluarbulk.js'
        );
        $this->loadview('index', $vars);
    }

    function read($id) {
        $vars = array();
        $vars['page_name'] = 'form';
        $model = $this->model;
        $vars['form'] = $this->$model->getForm($id);
        $vars['subform'] = $this->$model->getFormChild($id);
        $vars['uuid'] = $id;
        $vars['css'] = array(
//            'summernote.min.css'
        );
        $vars['js'] = array(
            'moment.min.js',
            'bootstrap-datepicker.js',
            'daterangepicker.min.js',
            'select2.full.min.js',
//            'summernote.min.js',
            'form-barangkeluarbulk.js'
        );
        $this->loadview('index', $vars);
    }

    function select2($model, $field) {
        $this->load->model($model);
        if ('BarangSatuans' === $model)
            echo '{"results":' . json_encode($this->$model->select2WithBarang($field, $this->input->post('term'), $this->input->post('barang'))) . '}';
        else if ('Pengajuans' === $model)
            echo '{"results":' . json_encode($this->$model->select2forBarangKeluarBulk($field, $this->input->post('term'))) . '}';
        else
            echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
    }

}
