<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Dompdf\Dompdf;

class Barang extends MY_Controller {

    function __construct() {
        $this->model = 'Barangs';
        parent::__construct();
    }

    function read($id) {
        $vars = array();
        $vars['page_name'] = 'form';
        $model = $this->model;
        $vars['form'] = $this->$model->getForm($id);
        $vars['subform'] = $this->$model->getFormChild($id);
        $vars['uuid'] = $id;
        $vars['js'] = array(
            'moment.min.js',
            'bootstrap-datepicker.js',
            'daterangepicker.min.js',
            'select2.full.min.js',
            'form.js'
        );

        $deletable = true;
        $relateds = array('BarangMasuks', 'BarangKeluars', 'DonasiBarangs', 'PengajuanBarangs');
        $this->load->model($relateds);
        foreach ($relateds as $relmod) {
            $anyrelation = $this->{$relmod}->find(array('barang' => $id));
            if (count($anyrelation) > 0)
                $deletable = false;
        }

        if (!$deletable) {
            $this->load->model('Permissions');
            $vars['permission'] = array_filter($this->Permissions->getPermissions(), function ($perm) {
                return $perm !== 'delete_Barang';
            });
        }

        $this->loadview('index', $vars);
    }

    public function index() {
        $model = $this->model;
        if ($post = $this->$model->lastSubmit($this->input->post())) {
            if (isset($post['delete']))
                $this->$model->delete($post['delete']);
            else
                $this->$model->save($post);
        }
        $vars = array();
        $vars['page_name'] = 'table-barang';
        $vars['js'] = array(
            'jquery.dataTables.min.js',
            'dataTables.bootstrap4.js',
            'table.js'
        );
        $vars['thead'] = $this->$model->thead;
        $this->loadview('index', $vars);
    }

    function excel() {
        $rows = $this->{$this->model}->download();
        $colnames = array('NO', 'BARANG', 'STATUS', 'STOK');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
                ->setTitle('Daftar Barang ATAboy')
                ->setSubject('Daftar Barang ATAboy')
                ->setDescription('Daftar Barang ATAboy.')
                ->setKeywords('office 2007 openxml php')
                ->setCategory('Report result file');

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getDefaultStyle()->applyFromArray(array(
            'font' => array(
                'size' => 10,
            )
        ));

        $alphabet = range('A', 'Z');

        $rownum = 1;
        foreach ($colnames as $index => $content) {
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("{$alphabet[$index]}$rownum", $content);
        }
        
        $spreadsheet->getActiveSheet()->getStyle("A{$rownum}:{$alphabet[count($alphabet) - 1]}{$rownum}")->getFont()->setBold(true);

        $rownum = 2;
        foreach ($rows as $row) {
            foreach ($colnames as $index => $colname) {
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("{$alphabet[$index]}{$rownum}", $row[$colname]);
            }
            $rownum++;
        }

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Daftar Barang ATAboy.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    function pdf() {
        $data = array(
            'rows' => $this->{$this->model}->download()
        );
        $viewer = 'pdf-daftarbarang';
        $filename = 'Daftar Barang ATAboy';
        $html = $this->load->view($viewer, $data, TRUE);

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->render();
        $pdf->stream($filename, array("Attachment" => TRUE));
    }

}
