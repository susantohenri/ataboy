<?php defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanLogs extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'pengajuanlog';
        $this->thead = array(
            (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
            (object) array('mData' => 'nama', 'sTitle' => 'Nama'),
        );
        $this->form = array(
            array(
                'name' => 'createdAt',
                'width' => 2,
                'label' => '',
                'attributes' => array(
                    array('disabled' => 'disabled')
                )
            ),
            array(
                'name' => 'actor',
                'width' => 2,
                'label' => '',
                'attributes' => array(
                    array('disabled' => 'disabled')
                )
            ),
            array(
                'name' => 'field',
                'width' => 2,
                'label' => '',
                'attributes' => array(
                    array('disabled' => 'disabled')
                )
            ),
            array(
                'name' => 'prev',
                'width' => 3,
                'label' => '',
                'attributes' => array(
                    array('disabled' => 'disabled')
                )
            ),
            array(
                'name' => 'next',
                'width' => 3,
                'label' => '',
                'attributes' => array(
                    array('disabled' => 'disabled')
                )
            ),
        );
        $this->childs = array();
    }

    function getForm($uuid = false, $isSubform = false)
    {
        $form = parent::getForm($uuid, $isSubform);
        $form = array_map(function ($field) {
            switch ($field['name']) {
                case 'actor':
                    $this->load->model('Users');
                    $actor = $this->Users->findOne($field['value']);
                    $field['value'] = $actor['nama'];
                    return $field;
                    break;
                case 'field':
                    $this->load->model('Pengajuans');
                    $value = $field['value'];
                    $target = array_filter($this->Pengajuans->getForm(), function ($donfield) use ($value) {
                        return $donfield['name'] === $value;
                    });
                    $target = array_values($target);
                    if (isset($target[0])) $field['value'] = $target[0]['label'];
                    return $field;
                    break;
                default:
                    return $field;
                    break;
            }
        }, $form);

        // PREVENT SUBMITTING
        $form = array_filter($form, function ($field) {
            return $field['name'] !== 'uuid';
        });

        return $form;
    }
}
