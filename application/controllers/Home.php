<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	function index($uuid = null, $password = null)
	{
		if (null !== $uuid && null !== $password) {
			$this->load->model('Users');
			$resetUser = $this->Users->findOne(array(
				'uuid' => $uuid,
				'password' => $password
			));
			if (!$resetUser) $params['error_message'] = 'Link Reset Password Tidak Valid';
			else $params['reset_password'] = $uuid;
		}

		if ($post = $this->input->post()) {
			switch ($post['action']) {
				case 'login':
					$this->load->model('Users');
					$login = $this->Users->findOne(array(
						'username' => $post['username']
					));
					if (!isset($login['uuid'])) {
						$params['error_message'] = 'Akun Tidak Ditemukan';
					} else if ($login['password'] !== md5($post['password'])) {
						$params['error_message'] = 'Password Tidak Sesuai';
					} else {
						switch ($login['status']) {
							case '-1':
								$params['error_message'] = "
									Akun Anda Belum Diverifikasi
									<br> Silakan Hubungi Admin di Nomor 081xxxxxxx
								";
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
					$already = $this->Donaturs->findOne(array('username' => $post['username']));
					if (isset($already['uuid'])) $params['error_message'] = 'Pendaftaran Ditolak, Email Telah Terdaftar Sebelumnya';
					else {
						unset($post['action']);
						$this->Donaturs->save($post);
						$params['error_message'] = 'Pendaftaran Sukses';
					}
					break;
				case 'registrasi-kelurahan':
					$this->load->model('Kelurahans');
					$already = $this->Kelurahans->findOne(array('username' => $post['username']));
					if (isset($already['uuid'])) $params['error_message'] = 'Pendaftaran Ditolak, Email Telah Terdaftar Sebelumnya';
					else {
						unset($post['action']);
						$this->Kelurahans->save($post);
						$params['error_message'] = 'Pendaftaran Sukses, Silakan Tunggu Proses Validasi Selesai';
					}
					break;
				case 'forgot-password':
					$this->load->model(array('Users', 'Emails'));
					$user = $this->Users->findOne(array('username' => $post['username']));
					if (!$user) $params['error_message'] = 'Alamat Email Tidak Ditemukan, Silakan Melakukan Registrasi';
					else {
						$link = site_url("Home/index/{$user['uuid']}/{$user['password']}");
						$subject = 'ATAboy Reset Password';
						$body = 'Untuk Memperbaharui Password, Silakan Ikuti Link Berikut <br> <a href="' . $link . '">' . $link . '</a>';
						$this->Emails->sendmail($subject, $body, $user['username']);
						$params['error_message'] = 'Email Terkirim, Silakan Ganti Password Anda Melalui Link yang Kami Kirim';
					}
					break;
				case 'reset-password':
					$this->load->model('Users');
					$this->Users->ChangePassword($post['uuid'], $post['password']);
					$params['error_message'] = 'Reset Password Berhasil, Silakan Login';
					break;
			}
		}
		$this->load->model(array('Blogs', 'Pengajuans', 'Desas'));
		$params['blogs'] = $this->Blogs->find(array('status' => 1));
		$params['mapMarkers'] = $this->Pengajuans->getMap();
		$params['desas'] = array_map(function ($desa) {
			return array('uuid' => $desa->uuid, 'nama' => $desa->nama);
		}, $this->Desas->find());
		$this->load->view('home', $params);
	}

	function dtPenyaluran()
	{
		$this->load->model('Pengajuans');
		echo $this->Pengajuans->getDTPenyaluran();
	}

	function dtDonatur()
	{
		$this->load->model('Donaturs');
		echo $this->Donaturs->getDTDonatur();
	}

	function Migrate($version = null)
	{
		$this->load->library('migration');
		$success = !is_null($version) ? $this->migration->version($version) : $this->migration->latest();
		if (!$success) show_error($this->migration->error_string());
	}

	function Logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect(base_url());
	}

	function LoginWithGoogle()
	{
		$this->load->model('Users');
		$email = $this->input->post('email');
		$user = $this->Users->findOne(array('username' => $email));
		if ($user) {
			$this->load->library('session');
			$this->session->set_userdata($user);
			echo true;
		} else {
			echo false;
		}
	}
}
