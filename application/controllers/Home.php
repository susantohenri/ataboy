<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function index () {
		if ($post = $this->input->post()) {
			switch ($post['action'])
			{
				case 'login':
					$this->load->model('Users');
					$login = $this->Users->findOne(array(
						'username' => $post['username']
					));
					if (!isset ($login['uuid'])) {
						$params['error_message'] = 'Akun Tidak Ditemukan';
					} else if ($login['password'] !== md5($post['password'])) {
						$params['error_message'] = 'Password Tidak Sesuai';
					} else {
						switch ($login['status'])
						{
							case '-1':
								$params['error_message'] = 'Akun Anda Belum Diverifikasi';
								break;
							case '0':
								$params['error_message'] = 'Akun Anda Diblokir';
								break;
							case '1':
								$this->load->library('session');
								$this->session->set_userdata($login);
								redirect(base_url());
								break;
						}
					}
					break;
				case 'registrasi-donatur':
					$this->load->model('Donaturs');
					unset($post['action']);
					$this->Donaturs->save($post);
					$params['error_message'] = 'Pendaftaran Sukses';
					break;
				case 'registrasi-kelurahan':
					$this->load->model('Kelurahans');
					unset($post['action']);
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

	function loginWithGoogle ()
	{
		$this->load->model('Users');
		$email = $this->input->post('email');
		$user = $this->Users->findOne(array('username' => $email));
		if ($user)
		{
			$this->load->library('session');
			$this->session->set_userdata($user);
			echo true;
		}
		else
		{
			echo false;
		}
	}
}