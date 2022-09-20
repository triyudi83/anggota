<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengurus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Pengurus');
        $this->load->model('M_Setting');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    /*
     * Listing of pengurus
     */
    public function index()
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Kepengurusan';
        $data['activeMenu'] = 'Level Pengurus';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['susunan'] = $this->db->get('tb_susunan')->result();

        $data['pengurus'] = $this->M_Pengurus->get_all();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('pengurus/index.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function create(){
        $data['actions'] = 'add';
        $data['action'] = site_url('pengurus/tambah');
        $data['modal_title'] = 'Tambah Data Pengurus';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['susunan'] = $this->db->get('tb_susunan')->result();
        
        $this->load->view('pengurus/create', $data);
    }
    function tambah()
    {
        $this->form_validation->set_rules('susunan', 'Susunan Penurus', 'trim|required');
        $this->form_validation->set_rules('level', 'Level', 'trim|required|callback_cek_susunan');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result= array(
                'susunan' => form_error('susunan'),
                'level' => form_error('level'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            
            $params = array(
                'susunan_id' => $this->input->post('susunan'),
                'level' => $this->input->post('level'),
                'created_by' => $this->session->userdata('id'),
                'update_at' => date('Y-m-d h:i:s')
            );

            $this->M_Setting->add('tb_pengurus', $params);

            $kat = 'Tambah Level Kepengurusan ' . $this->input->post('level');
            $this->M_Setting->addlog($kat);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
    }

    function remove($id_pengurus)
    {

        $row = $this->db->get_where('tb_pengurus', array('id_pengurus' => $id_pengurus))->row();
        if ($row) {
            $where = array('id_pengurus' => $id_pengurus);
            $this->M_Setting->delete($where, 'tb_pengurus');

            $kat = 'Hapus Level Kepengurusan ' . $row->level;
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


    function cek_leveledit()
    {
        $where = array(
            'level' => $this->input->post('level'),
            'id_pengurus !=' => $this->input->post('id')
        );
        $hasil_kode = $this->M_Setting->cek('tb_pengurus', $where);
        if (count($hasil_kode) != 0) {
            echo '1';
        } else {
            echo '2';
        }
    }

    function cek_level()
    {
        $where = array(
            'level' => $this->input->post('level')
        );
        $hasil_kode = $this->M_Setting->cek('tb_pengurus', $where);
        if (count($hasil_kode) != 0) {
            echo '1';
        } else {
            echo '2';
        }
    }

    public function update($id)
    {
        $data['actions'] = 'add';
        $data['action'] = site_url('Pengurus/update_action');
        $data['modal_title'] = 'Level Kepengurusan';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['susunan'] = $this->db->get('tb_susunan')->result();
        $data['key'] = $this->db->get_where('tb_pengurus', array('id_pengurus' => $id))->row();
        $this->load->view('pengurus/update', $data);
    }

    public function update_action()
    {
        $this->form_validation->set_rules('susunan', 'Susunan Penurus', 'trim|required');
        $this->form_validation->set_rules('level', 'Level', 'trim|required|callback_cek_susunanedit');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result= array(
                'susunan' => form_error('susunan'),
                'level' => form_error('level'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $params = array(
                'susunan_id' => $this->input->post('susunan'),
                'level' => $this->input->post('level'),
                'created_by' => $this->session->userdata('id'),
                'update_at' => date('Y-m-d h:i:s')
            );
            $id_pengurus = $this->input->post('id');
            $this->M_Pengurus->update_pengurus($id_pengurus, $params);
            $kat = 'Edit Level Kepengurusan ' . $this->input->post('id');
            $this->M_Setting->addlog($kat);

            $result['status'] = 'success';
            $result['message'] = 'Data berhasil diubah';
            $result['url'] = site_url('pengurus');
            echo json_encode($result);
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('level', 'level', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function cek_susunan()
    {
        $susunan = $this->input->post('susunan');
        $level = $this->input->post('level');
        $data = $this->db->get_where('tb_pengurus', array('susunan_id' => $susunan, 'level' => $level))->row();
        if ($data) {
            $this->form_validation->set_message('cek_susunan', '{field} Sudah Terdaftar');
            return false;
        } else {
            return true;
        }
        
    }

    function cek_susunanedit()
    {
        $susunan = $this->input->post('susunan');
        $level = $this->input->post('level');
        $id = $this->input->post('id');
        $data = $this->db->get_where('tb_pengurus', array('susunan_id' => $susunan, 'level' => $level, 'id_pengurus !=' => $id))->row();
        if ($data) {
            $this->form_validation->set_message('cek_susunanedit', '{field} Sudah Terdaftar');
            return false;
        } else {
            return true;
        }
        
    }

    public function itemdelete(){
        $ids = $this->input->post('ids');

        $this->db->where_in('id_pengurus', explode(",", $ids));
        $this->db->delete('tb_pengurus');
        echo json_encode(['success' => "Item Deleted successfully."]);
    }

}
