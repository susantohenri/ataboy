<?php defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuk extends MY_Controller
{

	function __construct()
	{
		$this->model = 'BarangMasuks';
		parent::__construct();
	}

	function subformcreate($donasiBarang = null)
	{
		$model = $this->model;
		$vars = array();
		$vars['form'] = $this->$model->getForm(false, true);
		if (null !== $donasiBarang) {
			$this->load->model('DonasiBarangs');
			$donbar = $this->DonasiBarangs->findOne($donasiBarang);
			$vars['form'] = array_map(function ($field) use ($donbar) {
				switch ($field['name']) {
					case 'jumlah':
						$field['value'] = $donbar['jumlah'];
						break;
					case 'barang':
						$this->load->model('Barangs');
						$brg = $this->Barangs->findOne($donbar['barang']);
						$nm_brg = $brg['jenis'] === 'free-text' ? "{$brg['nama']} (free-text)": $brg['nama'];
						$field['value'] = $brg['uuid'];
						$field['options'] = array(
							array('text' => $nm_brg, 'value' => $brg['uuid'])
						);
						break;
					case 'satuan':
						$this->load->model('BarangSatuans');
						$sat = $this->BarangSatuans->findOne($donbar['satuan']);
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
