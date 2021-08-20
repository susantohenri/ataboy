<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuans extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'pengajuan';
		$this->dir_dok_pengajuan = 'dokumen-pengajuan';
		$this->dir_photo_serter = 'photo-serah-terima';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'tiket_id', 'sTitle' => 'ID Tiket'),
			(object) array('mData' => 'status', 'sTitle' => 'Status'),
		);
		$this->form = array(
			array(
				'name' => 'tiket_id',
				'width' => 2,
				'label' => 'ID Tiket'
			),
			array(
				'name' => 'status',
				'width' => 2,
				'label' => 'Status',
				'options' => array(
					array('text' => 'DIAJUKAN', 'value' => 'DIAJUKAN'),
					array('text' => 'DIVERIFIKASI', 'value' => 'DIVERIFIKASI'),
					array('text' => 'DITERIMA', 'value' => 'DITERIMA'),
					array('text' => 'DITOLAK', 'value' => 'DITOLAK'),
					array('text' => 'SELESAI', 'value' => 'SELESAI')
				)
			),
			array(
				'name' => 'propinsi',
				'width' => 2,
				'label' => 'Propinsi',
				'value' => 'Jawa Tengah',
				'options' => array(
					array('value' => 'Jawa Tengah', 'text' => 'Jawa Tengah')
				)
			),
			array(
				'name' => 'kabupaten',
				'width' => 2,
				'label' => 'Kabupaten',
				'value' => 'Boyolali',
				'options' => array(
					array('value' => 'Boyolali', 'text' => 'Boyolali')
				)
			),
			array(
				'name' => 'kecamatan',
				'label' => 'Kecamatan',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Kecamatans'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
			array(
				'name' => 'kelurahan',
				'label' => 'Kelurahan',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Desas'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
			array(
				'name' => 'latlng',
				'width' => 2,
				'label' => 'Peta Lokasi',
				'value' => ''
			),
			array(
				'name' => 'latitude',
				'type' => 'hidden',
				'width' => 2,
				'label' => 'Latitude',
			),
			array(
				'name' => 'longitude',
				'type' => 'hidden',
				'width' => 2,
				'label' => 'Longitude',
			),
			array(
				'name' => 'bencana',
				'label' => 'Jenis Bencana',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Bencanas'),
					array('data-field' => 'nama'),
					array('required' => 'required')
				)
			),
			array(
				'name' => 'jumlah_kk_jiwa',
				'label' => 'Jumlah KK / Jiwa',
				'width' => 2,
				'attributes' => array(
					array('data-number' => 'true')
				)
			),
			array(
				'name' => 'keterangan',
				'width' => 2,
				'label' => 'Keterangan',
				'type' => 'textarea'
			),
			array(
				'name' => 'dokumen_pengajuan',
				'width' => 2,
				'label' => 'Dokumen Pengajuan',
				'type' => 'file',
				'attributes' => array(
					array('accept' => 'application/pdf')
				)
			),
			array(
				'name' => 'photo_serah_terima',
				'width' => 2,
				'label' => 'Photo Serah Terima',
				'type' => 'file',
				'attributes' => array(
					array('accept' => 'image/*')
				)
			)
		);
		$this->childs = array(
			array(
				'label' => 'Bukti Foto',
				'controller' => 'PengajuanPhoto',
				'model' => 'PengajuanPhotos'
			),
			array(
				'label' => 'Kebutuhan',
				'controller' => 'PengajuanBarang',
				'model' => 'PengajuanBarangs'
			),
			array(
				'label' => 'Item Disalurkan',
				'controller' => 'BarangKeluar',
				'model' => 'BarangKeluars'
			),
			array(
				'label' => 'Log History',
				'controller' => 'PengajuanLog',
				'model' => 'PengajuanLogs'
			)
		);
	}

	function dt()
	{
		$this->load->model('Roles');
		if ($this->Roles->getRole() === 'Kelurahan') {
			$this->datatables->where('createdBy', $this->session->userdata('uuid'));
		}

		foreach (array('kecamatan', 'kelurahan', 'tiket_id', 'status') as $filter) {
			if ($parameter = $this->input->get($filter)) {
				if (strlen($parameter) > 0) {
					$this->datatables->where($filter, $parameter);
				}
			}
		}
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select("{$this->table}.tiket_id")
			->select("{$this->table}.status");
		return parent::dt();
	}

	function getForm($uuid = false, $isSubform = false)
	{
		// SHOW PHOTO SERAH TERIMA ON SELESAI ONLY
		$pengajuan = $this->findOne($uuid);
		if ($pengajuan['status'] !== 'SELESAI') {
			$this->form = array_filter($this->form, function ($field) {
				return $field['name'] !== 'photo_serah_terima';
			});
		}

		$form = parent::getForm($uuid, $isSubform);
		$hide = array('status', 'tiket_id');
		$this->load->model('Roles');

		if (strpos($this->Roles->getRole(), 'Admin') > -1) {
			$disabled = array('tiket_id');
			$hide = array('tiket_id');
		} else $disabled = array('status', 'tiket_id');

		if (false === $uuid) {
			unset($this->childs[2]); // HIDE BARANGKELUAR
			unset($this->childs[3]); // HIDE PENGAJUANLOG
			$form = array_filter(
				$form,
				function ($field) use ($hide) {
					return !in_array($field['name'], $hide);
				}
			);
		} else {
                    $form = array_map(function ($field) use($pengajuan){
                        switch ($field['name']) {
                            case 'bencana':
                                $this->load->model('Bencanas');
                                $bencana = $this->Bencanas->findOne($pengajuan['bencana']);
                                $jn_bencana = $bencana['jenis'] === 'free-text' ? "{$bencana['nama']} (free-text)": $bencana['nama'];
                                $field['value'] = $bencana['uuid'];
                                $field['options'] = array(
                                    array('text' => $jn_bencana, 'value' => $bencana['uuid'])
                                );
                                break;
                        }
                        return $field;
                    }, $form);
                }

		$form = array_map(function ($field) use ($disabled) {
			if (in_array($field['name'], $disabled)) {
				$field['attr'] .= ' disabled="disabled"';
			}
			return $field;
		}, $form);

		return $form;
	}

	function save($record)
	{
		unset($this->childs[2]); // HIDE BARANGKELUAR
		unset($this->childs[3]); // HIDE PENGAJUANLOG
		unset($record['propinsi']);
		unset($record['kabupaten']);
                $this->load->model('Bencanas');
                $record['bencana'] = $this->Bencanas->getUuid($record['bencana']);

		// UPLOAD DOKUMEN PENGAJUAN
		if (strlen($_FILES['dokumen_pengajuan']['name']) > 0) {
			$oldfile = null;
			if (isset($record['uuid'])) {
				$prev = parent::findOne($record['uuid']);
				$oldfile = $prev['dokumen_pengajuan'];
			}
			$record['dokumen_pengajuan'] = $this->fileupload($this->dir_dok_pengajuan, $_FILES['dokumen_pengajuan'], $oldfile);
		}

		return parent::save($record);
	}

	function create($record)
	{
		if (!isset($record['status'])) $record['status'] = 'DIAJUKAN';
		$record['tiket_id'] = $this->generate_tiket_id();
		$record['createdBy'] = $this->session->userdata('uuid');
		$uuid = parent::create($record);
		$this->load->model('PengajuanLogs');
		$this->PengajuanLogs->create(array(
			'pengajuan' => $uuid,
			'actor' => $this->session->userdata('uuid'),
			'field' => 'SUBMIT PENGAJUAN'
		));
		return $uuid;
	}

	function update($next)
	{
		$this->load->model('PengajuanLogs');
		$prev = parent::findOne($next['uuid']);

		// UPLOAD PHOTO SERAH TERIMA
		if ($prev['status'] === 'SELESAI' && strlen($_FILES['photo_serah_terima']['name']) > 0) {
			$oldfile = $prev['photo_serah_terima'];
			$next['photo_serah_terima'] = $this->fileupload($this->dir_photo_serter, $_FILES['photo_serah_terima'], $oldfile);
		}

		$uuid = parent::update($next);

		// AUTOMATICALLY RELEASE GOODS FROM WAREHOUSE
		if ('SELESAI' === $next['status'] && 'SELESAI' !== $prev['status']) {
			$this->load->model(array('BarangKeluarBulks', 'PengajuanBarangs'));
			$pengbars = $this->PengajuanBarangs->find(array('pengajuan' => $uuid));
			if (count($pengbars) > 0) $this->BarangKeluarBulks->create(array(
				'pengajuan' => $uuid,
				'BarangKeluar_barang' => implode(',', array_map(function ($pengbar) {
					return $pengbar->barang;
				}, $pengbars)),
				'BarangKeluar_jumlah' => implode(',', array_map(function ($pengbar) {
					return $pengbar->jumlah;
				}, $pengbars)),
				'BarangKeluar_satuan' => implode(',', array_map(function ($pengbar) {
					return $pengbar->satuan;
				}, $pengbars))
			));
		}

		$this->load->model('PengajuanLogs');
		$fieldToScan = array_map(function ($field) {
			return $field['name'];
		}, parent::getForm());
		foreach ($fieldToScan as $field) {
			if (isset($next[$field]) && $prev[$field] !== $next[$field]) {
				switch ($field) {
					case 'kecamatan':
						$this->load->model('Kecamatans');
						$prevkec = $this->Kecamatans->findOne($prev[$field]);
						$nextkec = $this->Kecamatans->findOne($next[$field]);
						$prev[$field] = $prevkec['nama'];
						$next[$field] = $nextkec['nama'];
						break;
					case 'kelurahan':
						$this->load->model('Desas');
						$prevkel = $this->Desas->findOne($prev[$field]);
						$nextkel = $this->Desas->findOne($next[$field]);
						$prev[$field] = $prevkel['nama'];
						$next[$field] = $nextkel['nama'];
						break;
					case 'bencana':
						$this->load->model('Bencanas');
						$prevbcn = $this->Bencanas->findOne($prev[$field]);
						$nextbcn = $this->Bencanas->findOne($next[$field]);
						$prev[$field] = $prevbcn['nama'];
						$next[$field] = $nextbcn['nama'];
						break;
				}
				$this->PengajuanLogs->create(array(
					'pengajuan' => $next['uuid'],
					'actor' => $this->session->userdata('uuid'),
					'field' => $field,
					'prev' => $prev[$field],
					'next' => $next[$field]
				));
			}
		}
		return $uuid;
	}

	private function generate_tiket_id()
	{
		$tiket_id = $this->generate_random_alphanumeric();
		while ($this->is_tiket_id_exists($tiket_id)) {
			$tiket_id = $this->generate_random_alphanumeric();
		}
		return $tiket_id;
	}

	private function generate_random_alphanumeric()
	{
		return strtoupper(substr(uniqid(), 0, 11));
	}

	function is_tiket_id_exists($tiket_id)
	{
		$found = $this->findOne(array('tiket_id' => $tiket_id));
		return isset($found['uuid']);
	}

	function select2forBarangKeluarBulk($field, $term)
	{
		$this->db->where("$this->table.status", 'DITERIMA');
		return $this->db
			->select("$this->table.uuid as id", false)
			->select("CONCAT($field, ' - ', desa.nama, ' - ', bencana.nama) as text", false)
			->join("desa", "$this->table.kelurahan = desa.uuid", "left")
			->join("bencana", "$this->table.bencana = bencana.uuid", "left")
			->limit(10)
			->like($field, $term)->get($this->table)->result();
	}

	function selesai($uuid)
	{
		$prev = parent::findOne($uuid);
		$done =  $this->db->set('status', 'SELESAI')->where('uuid', $uuid)->update($this->table);
		$this->load->model('PengajuanLogs');
		$this->PengajuanLogs->create(array(
			'pengajuan' => $uuid,
			'actor' => $this->session->userdata('uuid'),
			'field' => 'status',
			'prev' => $prev['status'],
			'next' => 'SELESAI'
		));
		return $done;
	}

	function rollBackToDiterima($uuid)
	{
		$prev = parent::findOne($uuid);
		$done = $this->db->set('status', 'DITERIMA')->where('uuid', $uuid)->update($this->table);
		$this->load->model('PengajuanLogs');
		$this->PengajuanLogs->create(array(
			'pengajuan' => $uuid,
			'actor' => $this->session->userdata('uuid'),
			'field' => 'status',
			'prev' => $prev['status'],
			'next' => 'DITERIMA'
		));
		return $done;
	}

	function delete($uuid)
	{
		// DELETE DOKUMEN PENGAJUAN IF EXISTS
		$record = parent::findOne($uuid);
		$this->fileupload('', null, $record['dokumen_pengajuan']);
		$this->fileupload('', null, $record['photo_serah_terima']);

		parent::delete($uuid);

		// DELETE BARANG-RELATED RECORDS
		$this->load->model('BarangKeluarBulks');
		foreach ($this->BarangKeluarBulks->find(array('pengajuan' => $uuid)) as $record) {
			$this->BarangKeluarBulks->delete($record->uuid);
		}
	}

	function getMap()
	{
		return $this
			->db
			->select('latitude as lat', false)
			->select('longitude as lng', false)
			->select('pengajuan.status')
			->select('jumlah_kk_jiwa as korban', false)
			->select('bencana.nama as bencana', false)
			->select('GROUP_CONCAT(barang.nama SEPARATOR ", ") as kebutuhan', false)
			->where_in('pengajuan.status', array(
				'DIAJUKAN',
				'DIVERIFIKASI',
				'DITERIMA'
			))
			->join('bencana', 'pengajuan.bencana = bencana.uuid', 'left')
			->join('pengajuanbarang', 'pengajuan.uuid = pengajuanbarang.pengajuan', 'left')
			->join('barang', 'barang.uuid = pengajuanbarang.barang', 'left')
			->group_by('pengajuan.uuid')
			->get($this->table)
			->result_array();
	}

	function getDTDiverifikasi()
	{
		return $this
			->datatables
			->select('desa.nama as desa', false)
			->select('bencana.nama as bencana', false)
			->select('GROUP_CONCAT(barang.nama SEPARATOR ", ") as kebutuhan', false)
			->from('pengajuan')
			->join('desa', 'pengajuan.kelurahan = desa.uuid', 'left')
			->join('bencana', 'pengajuan.bencana = bencana.uuid', 'left')
			->join('pengajuanbarang', 'pengajuanbarang.pengajuan = pengajuan.uuid', 'left')
			->join('barang', 'pengajuanbarang.barang = barang.uuid', 'left')
			->where('pengajuan.status', 'DIVERIFIKASI')
			->group_by('pengajuan.uuid')
			->generate();
	}

	function getDTDiajukan()
	{
		return $this
			->datatables
			->select('desa.nama as desa', false)
			->select('bencana.nama as bencana', false)
			->select('GROUP_CONCAT(barang.nama SEPARATOR ", ") as kebutuhan', false)
			->from('pengajuan')
			->join('desa', 'pengajuan.kelurahan = desa.uuid', 'left')
			->join('bencana', 'pengajuan.bencana = bencana.uuid', 'left')
			->join('pengajuanbarang', 'pengajuanbarang.pengajuan = pengajuan.uuid', 'left')
			->join('barang', 'pengajuanbarang.barang = barang.uuid', 'left')
			->where('pengajuan.status', 'DIAJUKAN')
			->group_by('pengajuan.uuid')
			->generate();
	}

	function getDTPenyaluran()
	{
		$base_url = base_url();
		return $this
			->datatables
			->select('desa.nama as desa', false)
			->select('bencana.nama as bencana', false)
			->select('jumlah_kk_jiwa as korban', false)
			->select('GROUP_CONCAT(barang.nama SEPARATOR ", ") as bantuan', false)
			->select("CONCAT('<a class=\"btn btn-sm btn-warning\" data-img=\"', '{$base_url}', photo_serah_terima, '\">preview</a>') as button", false)
			->from('pengajuan')
			->join('desa', 'pengajuan.kelurahan = desa.uuid', 'left')
			->join('bencana', 'pengajuan.bencana = bencana.uuid', 'left')
			->join('barangkeluarbulk', 'barangkeluarbulk.pengajuan = pengajuan.uuid', 'left')
			->join('barangkeluar', 'barangkeluar.barangkeluarbulk = barangkeluarbulk.uuid', 'left')
			->join('barang', 'barangkeluar.barang = barang.uuid', 'left')
			->where('pengajuan.status', 'SELESAI')
			->group_by('pengajuan.uuid')
			->generate();
	}

	function getSlideShowSerahTerima()
	{
		return array_map(
			function ($record) {
				return base_url($record->photo_serah_terima);
			},
			$this
				->db
				->select('photo_serah_terima')
				->where('photo_serah_terima <>', '')
				->get($this->table)
				->result()
		);
	}
}
