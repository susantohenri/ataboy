<?php defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuks extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'barangmasuk';
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
			->select('barangmasuk.barang');
		return parent::dt();
	}

	function create($data)
	{
		$result = parent::create($data);

		// RECORD RIWAYAT BARANG
		$this->load->model('RiwayatBarangs');
		$this->RiwayatBarangs->create(array(
			'barangMasuk' => $result,
			'barang' => $data['barang'],
			'jumlah' => $data['jumlah'],
			'satuan' => $data['satuan']
		));

		// RECORD BARANGMASUKBULKLOG
		$this->load->model(array('BarangMasukBulkLogs', 'Barangs', 'BarangSatuans'));
		$barang = $this->Barangs->findOne($data['barang']);
		$satuan = $this->BarangSatuans->findOne($data['satuan']);
		$this->BarangMasukBulkLogs->create(array(
			'barangmasukbulk' => $data['barangmasukbulk'],
			'actor' => $this->session->userdata('uuid'),
			'field' => "INPUT BARANG",
			'next' => "{$barang['nama']} {$data['jumlah']} {$satuan['nama']}"
		));

		return $result;
	}

	function update($data)
	{
		$prev = parent::findOne($data['uuid']);
		$result = parent::update($data);
		$next = parent::findOne($result);

		// RECORD RIWAYAT BARANG
		$this->load->model('RiwayatBarangs');
		$found = $this->RiwayatBarangs->findOne(array('barangMasuk' => $result));
		$this->RiwayatBarangs->update(array(
			'uuid' => $found['uuid'],
			'barangMasuk' => $result,
			'barang' => $data['barang'],
			'jumlah' => $data['jumlah'],
			'satuan' => $data['satuan']
		));

		// RECORD BARANGMASUKBULKLOG
		$this->load->model(array('Barangs', 'BarangSatuans', 'BarangMasukBulkLogs'));
		$brgprev = $this->Barangs->findOne($prev['barang']);
		$brgnext = $this->Barangs->findOne($next['barang']);
		$satprev = $this->BarangSatuans->findOne($prev['satuan']);
		$satnext = $this->BarangSatuans->findOne($next['satuan']);
		if (
			$brgprev['nama'] !== $brgnext['nama'] ||
			$prev['jumlah'] !== $next['jumlah'] ||
			$satprev['nama'] !== $satnext['nama']
		) {
			$this->BarangMasukBulkLogs->create(array(
				'barangmasukbulk' => $data['barangmasukbulk'],
				'actor' => $this->session->userdata('uuid'),
				'field' => "EDIT BARANG",
				'prev' => "{$brgprev['nama']} {$prev['jumlah']} {$satprev['nama']}",
				'next' => "{$brgnext['nama']} {$next['jumlah']} {$satnext['nama']}"
			));
		}

		return $result;
	}

	function delete($uuid)
	{
		// RECORD RIWAYAT BARANG
		$this->load->model('RiwayatBarangs');
		$found = $this->RiwayatBarangs->findOne(array('barangMasuk' => $uuid));
		$prev = parent::findOne($uuid);
		$result = parent::delete($uuid);
		$this->RiwayatBarangs->delete($found['uuid']);

		// RECORD BARANGMASUKBULKLOG
		$this->load->model(array('BarangMasukBulkLogs', 'Barangs', 'BarangSatuans'));
		$barang = $this->Barangs->findOne($prev['barang']);
		$satuan = $this->BarangSatuans->findOne($prev['satuan']);
		$this->BarangMasukBulkLogs->create(array(
			'barangmasukbulk' => $prev['barangmasukbulk'],
			'actor' => $this->session->userdata('uuid'),
			'field' => "HAPUS BARANG",
			'prev' => "{$barang['nama']} {$prev['jumlah']} {$satuan['nama']}"
		));

		return $result;
	}

	function setDonasi($bulkId, $donasiId)
	{
		return $this->db
			->set('donasi', $donasiId)
			->where('barangMasukBulk', $bulkId)
			->update($this->table);
	}
}
