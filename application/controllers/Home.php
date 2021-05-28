<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function index () {
		if ($post = $this->input->post()) {
			switch ($post['action'])
			{
				case 'login':
					$this->load->model('Users');
					$login = $this->Users->findOne(array(
						'username' => $post['username'],
						'password' => md5($post['password'])
					));
					if (isset ($login['uuid'])) {
						if ('1' === $login['status'])
						{
							$this->load->library('session');
							$this->session->set_userdata($login);
							redirect(base_url());
						} else {
							$params['error_message'] = 'Akun Anda Belum Aktif';
						}
					}
					break;
				case 'registrasi-donatur':
					$this->load->model('Donaturs');
					unset($post['action']);
					$post['confirm_password'] = $post['password'];
					$this->Donaturs->save($post);
					$params['error_message'] = 'Pendaftaran Sukses';
					break;
				case 'registrasi-kelurahan':
					$this->load->model('Kelurahans');
					unset($post['action']);
					$post['confirm_password'] = $post['password'];
					$this->Kelurahans->save($post);
					$params['error_message'] = 'Pendaftaran Sukses, Silakan Tunggu Proses Validasi Selesai';
					break;
			}
		}
		$this->load->model(array('Blogs', 'Pengajuans', 'Desas'));
		$params['blogs'] = $this->Blogs->find(array('status' => 1));
		$params['mapMarkers'] = array_map(function ($pengajuan) {
			return array (
				'lat' => $pengajuan->latitude,
				'lng' => $pengajuan->longitude
			);
		}, $this->Pengajuans->find(array('status' => 'DITERIMA')));
		$params['desas'] = array_map(function ($desa) {
			return array('uuid' => $desa->uuid, 'nama' => $desa->nama);
		}, $this->Desas->find());
		$this->load->view('home', $params);
	}

	function Migrate ($version = null) {
		$this->load->library('migration');
	    $success = !is_null ($version) ? $this->migration->version($version) : $this->migration->latest();
	    if (!$success) show_error($this->migration->error_string());
	}

	function Logout() {
	  	$this->load->library('session');
	    $this->session->sess_destroy();
	    redirect(base_url());
	}

}