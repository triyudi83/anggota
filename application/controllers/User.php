<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User');
        $this->load->model('M_Setting');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    /*
     * Listing of user
     */
    public function index()
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Data Master';
        $data['activeMenu'] = 'User Akses Login';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);

        $data['anggota'] = $this->db->get_where('tb_pendaftaran',['status' => 'Verifikasi', 'status_anggota' =>'Aktif'])->result();
        $data['user'] = $this->M_User->get_all();
        $data['role_user'] = $this->db->get('role_users')->result();
        $data['kecamatan'] = $this->db->get_where('tb_kecamatan', ['id_kota' => '3512'])->result();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('user/index.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    function tambah()
    {
        $nik = $this->input->post('nik');
        $user = $this->db->get_where('users', ['member_id' => $nik])->row();
        if($user){
            $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">NIK sudah terdaftar!</div>');
            redirect('user');
        }else{
            
            $kecamatan = $this->input->post('kecamatan');
            if($kecamatan==''){
                $kecamatan_str = '';
            }else{
                $kecamatan_str = implode(',', $kecamatan);
            }
            $data = $this->db->get_where('tb_pendaftaran', ['nik' => $nik])->row();
            $params = array(
                'email' => $this->input->post('email'),
                'name' => $data->nama,
                'member_id' => $nik,
                'password' => md5($this->input->post('password')),
                'role_user' => $this->input->post('level'),
                'kecamatan' => $kecamatan_str,
                'active' => date('Y-m-d', strtotime($this->input->post('active'))),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            );
    
            $this->M_Setting->add('users', $params);
            $kat = 'Tambah data User ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);
            $this->session->set_flashdata('flash', '
                    <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                    Data Berhasil di Tambahkan
                    </div>      
                    ');
            redirect('user');
        }
        
    }

    function aksestambahuser()
    {
        $id = $this->input->post('iduser');
        $data = $this->db->get_where('tb_akses', array('id' => $id))->result();
        if($data){
            $this->session->set_flashdata('flash', '
                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-check"></i> Gagal!</h5>
                Data User Sudah Ada
                </div>      
                ');
            redirect('hakakses');
        }else{
            $submenu = $this->db->get_where('tb_submenu', ['statusmenu' => 'aktif'])->result();
            foreach ($submenu as $key) {
                $params = array(
                    'id' => $id,
                    'id_submenu' => $key->id_submenu,
                    'view' => 0,
                    'add' => 0,
                    'edit' => 0,
                    'delete' => 0,
                );
                $this->M_Setting->add('tb_akses', $params);
            }
            $kat = 'Tambah data User ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);
            $this->session->set_flashdata('flash', '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                Data Berhasil di Tambahkan
                </div>      
                ');

                redirect('hakakses');
        }
    }

    function password()
    {
        $params = array(
            'password' => md5($this->input->post('password'))
        );
        $id_user = $this->input->post('id');
        $this->M_User->update_user($id_user, $params);
        $kat = 'Edit Password user dengan id ' . $this->input->post('id');
        $this->M_Setting->addlog($kat);
        $this->session->set_flashdata('flash', '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                Password Berhasil Di Rubah
                </div>      
                ');
        redirect('hakakses');
    }

    function remove($id_user)
    {

        $row = $this->db->get_where('users', array('id' => $id_user))->row();
        if ($row) {
            $where = array('id' => $id_user);
            $this->M_Setting->delete($where, 'users');

            $kat = 'Delete Password user dengan id ' . $id_user;
            $this->M_Setting->addlog($kat);

            $result['success'] = 'Data Berhasil Dihapus';
            $result['icon'] = 'success';
            $result['title'] = 'Berhasil';
        } else {
            $result['error'] = 'Record Not Found';
            $result['icon'] = 'error';
            $result['title'] = 'Oops...';
        }
        echo json_encode($result);
    }

    function cek_email()
    {
        $where = array(
            'email' => $this->input->post('email')
        );
        $hasil_kode = $this->M_Setting->cek('users', $where);
        if (count($hasil_kode) != 0) {
            echo '1';
        } else {
            echo '2';
        }
    }

    public function update($id)
    {
        $data['actions'] = 'add';
        $data['action'] = site_url('user/update_action');
        $data['modal_title'] = 'User Akses Login';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['role_user'] = $this->db->get('role_users')->result();
        $data['kecamatan'] = $this->db->get_where('tb_kecamatan', ['id_kota' => '3512'])->result();
        $data['key'] = $this->db->get_where('users', array('id' => $id))->row();
        $this->load->view('user/update', $data);
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $result['error'] = validation_errors();
        } else {
            $kecamatan = $this->input->post('kecamatan');
            if($kecamatan==''){
                $kecamatan_str = '';
            }else{
                $kecamatan_str = implode(',', $kecamatan);
            }

            $params = array(
                'email' => $this->input->post('email'),
                'name' => $this->input->post('nama'),
                'role_user' => $this->input->post('level'),
                'kecamatan' => $kecamatan_str,
                'active' => date('Y-m-d', strtotime($this->input->post('masa_aktif'))),
                'updated_at' => date('Y-m-d h:i:s')
            );
            if($this->input->post('password') != ''){
                $params['password'] = md5($this->input->post('password'));
            }
            $id_user = $this->input->post('id');
            $this->M_User->update_user($id_user, $params);
            $kat = 'Edit data user ' . $this->input->post('id');
            $this->M_Setting->addlog($kat);

            $result['success'] = 'Update Record Success';
            $result['url'] = site_url('user');
        }
        echo json_encode($result);
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
