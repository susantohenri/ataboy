<?php defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanBarangs extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'pengajuanbarang';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'barang', 'sTitle' => 'Barang'),

		);
		$this->form = array(
			array(
				'name' => 'barang',
				'label' => 'Item',
				'options' => array(),
				'width' => 6,
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
				'label' => 'Unit',
				'options' => array(),
				'width' => 3,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'BarangSatuans'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
		);
		$this->childs = array();
	}

	function dt()
	{
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select('pengajuanbarang.barang');
		return parent::dt();
	}

	function getKebutuhan($barang)
	{
		$kebutuhan = $this->db
			->select('SUM(pengajuanbarang.jumlah * barangsatuan.skala) jumlah', false)
			->from('pengajuanbarang')
			->join('pengajuan', 'pengajuan.uuid = pengajuanbarang.pengajuan', 'right')
			->join('barang', 'barang.uuid = pengajuanbarang.barang', 'right')
			->join('barangsatuan', 'barangsatuan.uuid = pengajuanbarang.satuan', 'right')
			->where('pengajuan.status', 'DITERIMA')
			->where('barang.uuid', $barang)
			->get()->row_array();
		return $kebutuhan['jumlah'] ? $kebutuhan['jumlah'] : 0;
	}
}
