<?php defined('BASEPATH') or exit('No direct script access allowed');

class DonasiBarangs extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'donasibarang';
		$this->file_location = 'foto-donasi';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'barang', 'sTitle' => 'Barang'),

		);
		$this->form = array(
			array(
				'name' => 'barang',
				'label' => 'Item',
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
				'label' => 'Unit',
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
				'name' => 'localFileName',
				'width' => 2,
				'label' => '',
				'type' => 'hidden',
				'value' => ''
			),
			array(
				'name' => 'gambar',
				'type' => 'file',
				'width' => 3,
				'label' => 'Pilih Foto',
			)
		);
		$this->childs = array();
	}

	function dt()
	{
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select('donasibarang.barang');
		return parent::dt();
	}

	function create($data)
	{
		$uuid = parent::create($data);

		// RECORD DONASILOG
		$this->load->model(array('DonasiLogs', 'Barangs', 'BarangSatuans'));
		$barang = $this->Barangs->findOne($data['barang']);
		$satuan = $this->BarangSatuans->findOne($data['satuan']);
		$this->DonasiLogs->create(array(
			'donasi' => $data['donasi'],
			'actor' => $this->session->userdata('uuid'),
			'field' => "INPUT BARANG",
			'next' => "{$barang['nama']} {$data['jumlah']} {$satuan['nama']}"
		));

		return $uuid;
	}

	function update($data)
	{
		$prev = parent::findOne($data['uuid']);
		$uuid = parent::update($data);
		$next = parent::findOne($uuid);

		// RECORD DONASILOG
		$this->load->model(array('Barangs', 'BarangSatuans', 'DonasiLogs'));
		$brgprev = $this->Barangs->findOne($prev['barang']);
		$brgnext = $this->Barangs->findOne($next['barang']);
		$satprev = $this->BarangSatuans->findOne($prev['satuan']);
		$satnext = $this->BarangSatuans->findOne($next['satuan']);
		if (
			$brgprev['nama'] !== $brgnext['nama'] ||
			$prev['jumlah'] !== $next['jumlah'] ||
			$satprev['nama'] !== $satnext['nama']
		) {
			$this->DonasiLogs->create(array(
				'donasi' => $data['donasi'],
				'actor' => $this->session->userdata('uuid'),
				'field' => "EDIT BARANG",
				'prev' => "{$brgprev['nama']} {$prev['jumlah']} {$satprev['nama']}",
				'next' => "{$brgnext['nama']} {$next['jumlah']} {$satnext['nama']}"
			));
		}

		return $uuid;
	}

	function save($record)
	{
		$this->load->model(array('Barangs', 'BarangSatuans'));
		$record['barang'] = $this->Barangs->getUuid($record['barang']);
		$record['satuan'] = $this->BarangSatuans->getUuid($record['satuan'], $record['barang']);
		$index = array_search($record['localFileName'], $_FILES['DonasiBarang_gambar']['name']);
		unset($record['localFileName']);
		foreach ($record as $field => &$value) {
			if (is_array($value)) $value = implode(',', $value);
			else if (strpos($value, '[comma-replacement]') > -1) $value = str_replace('[comma-replacement]', ',', $value);
		}
		if (strlen($_FILES['DonasiBarang_gambar']['name'][$index]) > 0) {
			$oldfile = null;
			if (isset($record['uuid'])) {
				$donasiBarang = self::findOne($record['uuid']);
				$oldfile = $donasiBarang['gambar'];
			}
			$record['gambar'] = $this->fileupload($this->file_location, $_FILES['DonasiBarang_gambar'], $oldfile, $index);
		}
		return isset($record['uuid']) ? $this->update($record) : $this->create($record);
	}

	function delete($uuid)
	{
		foreach ($this->childs as $child) {
			$childmodel = $child['model'];
			$this->load->model($childmodel);
			foreach ($this->$childmodel->find(array($this->table => $uuid)) as $childrecord)
				$this->$childmodel->delete($childrecord->uuid);
		}
		$donasiBarang = self::findOne($uuid);
		$this->fileupload('', null, $donasiBarang['gambar']);

		// RECORD DONASILOG
		$this->load->model(array('DonasiLogs', 'Barangs', 'BarangSatuans'));
		$barang = $this->Barangs->findOne($donasiBarang['barang']);
		$satuan = $this->BarangSatuans->findOne($donasiBarang['satuan']);
		$this->DonasiLogs->create(array(
			'donasi' => $donasiBarang['donasi'],
			'actor' => $this->session->userdata('uuid'),
			'field' => "HAPUS BARANG",
			'prev' => "{$barang['nama']} {$donasiBarang['jumlah']} {$satuan['nama']}"
		));

		return $this->db->where('uuid', $uuid)->delete($this->table);
	}

	function fileupload($location, $newfile = null, $oldfile = null, $index = 0)
	{
		$new_file_location = '';
		$unique = time();
		if (!is_null($newfile)) {
			$extension = pathinfo($newfile['name'][$index], PATHINFO_EXTENSION);
			$filename_without_ext = str_replace(".{$extension}", '', $newfile['name'][$index]);
			$extension = strtolower($extension);
			$new_file_location = "{$location}/{$filename_without_ext}_{$unique}.{$extension}";
			move_uploaded_file($newfile['tmp_name'][$index], $new_file_location);
		}
		if (!is_null($oldfile) && file_exists($oldfile)) unlink($oldfile);
		return $new_file_location;
	}

	function find($param = array())
	{
		$this->db->order_by('orders', 'desc');
		return parent::find($param);
	}
}
