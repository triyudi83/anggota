<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth');
		$this->load->model('M_Setting');
		$this->load->library('session');
		$this->load->helper('string');
	}

	public function index()
	{
		if (isset($_SESSION['login'])) {
			redirect('welcome');
		}
		$this->load->view('auth/login');
	}

	public function login()
	{
		//validation email
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/login');
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$user = $this->M_Auth->get($email, $password);
			if (empty($user)) {
				$this->session->set_flashdata('error', 'Email atau Password salah');
				redirect('auth/login');
			}else {
				if($user->active <= date('Y-m-d')){
					$this->session->set_flashdata('error', 'Masa Aktif Akun Anda Telah Berakhir, Hubungi Administrator untuk mengaktifkan Akun anda kembali.');
					redirect('auth/login');
				}
				else{
				$session = array(
					'authenticated' => true, // Buat session authenticated dengan value true
					'name' => $user->name,
					'id' => $user->id, // Buat session authenticated
					'email' => $user->email,
					'role_user' => $user->role_user,
					'kecamatan' => $user->kecamatan,
					'login' => true
				);
				$this->session->set_userdata($session); // Buat session sesuai $session

				$kat = $user->name . ' Login';
				$this->M_Setting->addlogin($kat, 'login');
				redirect('welcome');
				}
			}
		}
	}

	public function logout()
	{
		$name = $this->session->userdata('name');
		$kat =  $name . ' Log Out';
		$this->M_Setting->addlogin($kat, 'logout');
		$this->session->sess_destroy();
		redirect('welcome');
	}

	public function reset(){
		$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/reset');
		}else{
			$random = random_string('sha1');
			$email = $this->input->post('email');
			$this->db->update('users', ['remember_token' => $random], ['email' => $email]);
			$this->email($email);
			$this->session->set_flashdata('success', 'Kami telah mengirimkan email reset password ke '.$email.'. Silahkan klik tautan reset ulang password untuk mengatur kata sandi baru anda.');
			redirect('auth/reset');
		}

	}

	public function check_email(){
		$user = $this->db->get_where('users', array('email' => $this->input->post('email')))->row();
		if (empty($user)) {
			$this->form_validation->set_message('check_email', 'Maaf email tidak ditemukan');
			return false;
		}else{
			return true;
		}
	}

	public function email($email)
    {
        error_reporting(0);
		$user = $this->db->get_where('users', array('email' => $email))->row();
        $config = array(
            'mail_from_mail' => 'petigakita@gmail.com',
            'mail_from_name' => 'DPC PPP Situbondo',
            'mail_bcc' => 'my_email@example.com',
            'mail_setBcc' => true
        );
        $data = array(
            "NAME"       => 'DPC PPP Situbondo',
			'LINK'       => base_url('auth/reset_password/'.$user->remember_token),
			'USER_NAME' => $user->name,
        );

        $template_html = 'email.html';

        $mail = new Mail($config);
        $mail->AddEmbeddedImage('assets/ktp/Logo.png', 'logo', 'Logo.png');
        $mail->IsHTML(true);
        $mail->setMailBody($data, $template_html);
        return $mail->sendMail('KONFIRMASI RESET PASSWORD', $email);
    }

	public function reset_password($random){
		$user = $this->db->get_where('users', array('remember_token' => $random))->row();
		if (empty($user)) {
			$this->session->set_flashdata('error', 'Maaf token tidak ditemukan');
			redirect('auth/reset');
		}else{
			$data['user'] = $user;
			$this->load->view('auth/reset_password', $data);
		}
	}

	public function update_password(){
			$password = $this->input->post('password');
			$id = $this->input->post('id');
			$this->db->update('users', ['password' => md5($password), 'remember_token' => NULL], ['id' => $id]);
			$this->session->set_flashdata('success', 'Password berhasil diubah');
			redirect('auth/login');
	}
}
