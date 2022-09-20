<?php

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Setting');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');

        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    /*
     * Listing of satuan
     */
    public function index()
    {

        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Role User';
        $data['role'] = $this->db->get('role_users')->result();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('role_user/index.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function create(){
        $data['id'] = set_value('id');
        $data['nama_role'] = set_value('nama_role');
        $data['keterangan'] = set_value('keterangan');
        $data['title'] = 'Tambah Data Role User';
        $data['action'] = base_url('role/store');

        $data['button'] = 'Simpan';
        $data['method'] = 'POST';
        $this->load->view('role_user/form.php', $data);
    }
    
    public function view($id){
        $row = $this->db->get_where('role_users', array('id' => $id))->row();
        if($row){
            $data['id'] = $row->id;
            $data['nama_role'] = $row->nama_role;
            $data['keterangan'] = $row->keterangan;
            $data['title'] = 'Lihat Data Role User';
            $data['action'] = '';
            $data['method'] = '';
            $this->load->view('role_user/view.php', $data);
        }else{
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('role');
        }
    }

    public function store(){
        
        $this->form_validation->set_rules('nama_role', 'Nama', 'required|is_unique[role_users.nama_role]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
        
        if ($this->form_validation->run() == FALSE) {
            $result= array(
				'nama_role' => form_error('nama_role'),
                'keterangan' => form_error('keterangan'),
			);
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $data = array(
                'nama_role' => $this->input->post('nama_role'),
                'keterangan' => $this->input->post('keterangan'),
            );
            $this->db->insert('role_users', $data);
            $role_id = $this->db->insert_id();

            $sub_menu = $this->db->get('tb_submenu')->result();
           $akses = [];
           foreach($sub_menu as $sm){
                $akses[] = [
                    'id_submenu' => $sm->id_submenu,
                    'id' => $role_id,
                ];
           }
            $this->db->insert_batch('tb_akses', $akses);

            $kat = 'Tambah data Role ' . $this->input->post('nama_role');
            $this->M_Setting->addlog($kat);

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
    }

    public function edit($id){
        $row = $this->db->get_where('role_users', array('id' => $id))->row();
        if($row){
            $data['id'] = $row->id;
            $data['button'] = 'Update';
            $data['nama_role'] = $row->nama_role;
            $data['keterangan'] = $row->keterangan;
            $data['title'] = 'Edit Data Role User';
            $data['action'] = base_url('role/update');
            $data['method'] = 'POST';
            $this->load->view('role_user/form.php', $data);
        }else{
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('role');
        }
    }

    public function update(){
        $id = $this->input->post('id');
        $this->form_validation->set_rules('nama_role', 'Nama', 'required|callback_nama_role_check');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
        
        if ($this->form_validation->run() == FALSE) {
            $result= array(
                'nama_role' => form_error('nama_role'),
                'keterangan' => form_error('keterangan'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $data = array(
                'nama_role' => $this->input->post('nama_role'),
                'keterangan' => $this->input->post('keterangan'),
            );
            $this->db->where('id', $id);
            $this->db->update('role_users', $data);

            $kat = 'Edit data Role ' . $this->input->post('nama_role');
            $this->M_Setting->addlog($kat);

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diubah']);
        }
    }

    public function data(){
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('Select id, nama_role, keterangan from role_users');
        $datatables->add('action', function($data){
            $button = '<a href="'.base_url('role/view/'.$data['id']).'" class="btn btn-primary btn-xs ActView">Lihat</a> ';
            if (tomboledit('Role User') == 'aktif') {
                $button .= '<a href="'.base_url('role/edit/'.$data['id']).'" class="btn btn-warning btn-xs ActView">Edit</a> ';
                $button .= '<a href="'.base_url('role/hakakses/'.$data['id']).'" class="btn btn-success btn-xs">Hak Akses</a> ';
            }
            if (tombolhapus('Role User') == 'aktif') {
                $button .= '<a href="'.base_url('role/delete/'.$data['id']).'" class="btn btn-danger btn-xs ActDelete">Hapus</a>';
            }
            return $button;
        });
        
        echo $datatables->generate();
    }

    public function delete($id){
        $row = $this->db->get_where('role_users', array('id' => $id))->row();
        if($row && $row->id != 1){
            $this->db->delete('role_users', array('id' => $id));
            $this->db->delete('tb_akses', array('id' => $id));
            $kat = 'Hapus data Role ' . $row->nama_role;
            $this->M_Setting->addlog($kat);   
			$result['success'] = 'Delete Record Success';
			$result['icon'] = 'success';
			$result['title'] = 'Berhasil';
        } else {
            $result['error'] = 'Data Gagal Dihapus';
			$result['icon'] = 'error';
			$result['title'] = 'Oops...';
        }
        echo json_encode($result);
    }

    public function nama_role_check(){
        $id = $this->input->post('id');
        $nama_role = $this->input->post('nama_role');
        $row = $this->db->get_where('role_users', ['id !=' => $id, 'nama_role' => $nama_role])->row();
        if($row){
            $this->form_validation->set_message('nama_role_check', 'Nama role sudah ada');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function hakakses($ida){
        
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Role User';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $akses['akses'] = $this->M_Setting->getakses($ida);
        $akses['karyawan'] = $this->db->get_where('role_users',['id' => $ida])->row();
        $this->load->view('template/header' , $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('role_user/v_vakses', $akses);
        $this->load->view('template/footer');
    }

    public function store_hakakses(){
        if (isset($_POST['save'])) {

            $iduser = $this->input->post('nip');
            $this->M_Setting->refresh($iduser); //Call the modal

            $submenu = $this->input->post('submenu'); //Pass the userid here
            $checkbox = $this->input->post('view');
            for ($i = 0; $i < count($checkbox); $i++) {
                $sub = $submenu[$i];
                $view = $checkbox[$i];
                $this->M_Setting->editv($iduser, $sub, $view); //Call the modal

            }

            $addbox = $this->input->post('add');
            for ($i = 0; $i < count($addbox); $i++) {
                $sub = $submenu[$i];
                $add = $addbox[$i];
                $this->M_Setting->edita($iduser, $sub, $add); //Call the modal

            }

            $editbox = $this->input->post('edit');
            for ($i = 0; $i < count($editbox); $i++) {
                $sub = $submenu[$i];
                $edit = $editbox[$i];
                $this->M_Setting->edite($iduser, $sub, $edit); //Call the modal

            }

            $deletebox = $this->input->post('delete');
            for ($i = 0; $i < count($deletebox); $i++) {
                $sub = $submenu[$i];
                $delete = $deletebox[$i];
                $this->M_Setting->editd($iduser, $sub, $delete); //Call the modal

            }
            $this->session->set_flashdata('SUCCESS', "Record Added Successfully!!");
            redirect('role');
        }
    }

}
