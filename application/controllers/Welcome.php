<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Setting');
		$this->load->model('M_Anggota');
		if (!$this->session->userdata('id')) {
			redirect('auth');
		}
	}

	public function index()
	{
		$id = $this->session->userdata('role_user');
		$data['katMenu'] = 'dashboard';
		$data['activeMenu'] = 'dashboard';
		$data['menu'] = $this->M_Setting->getmenu($id);
		$data['submenu'] = $this->M_Setting->getsubmenu($id);
		$data['baru'] = $this->M_Anggota->get_by_status('Baru', 'Aktif');
		$data['aktif'] = $this->M_Anggota->get_by_status('Verifikasi', 'Aktif');
		$data['nonaktif'] = $this->M_Anggota->get_by_status('Verifikasi', 'Tidak');
		
		$data['diagram_aktif'] = '';
		$data['diagram_nonaktif'] = '';
		$data['kecamatan'] = '';
		$data['diagram_batang'] = '';
		$data['diagram_laki'] = '';
		$data['diagram_perempuan'] = '';

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('welcome_message', $data);
		$this->load->view('template/footer', $data);
	}
}
