<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Jabatan');
        $this->load->model('M_Pengurus');
        $this->load->model('M_Setting');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    /*
     * Listing of Jabatan
     */
    public function index()
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Kepengurusan';
        $data['activeMenu'] = 'Jabatan';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);

        $data['jabatan'] = $this->M_Jabatan->get_all();
        $data['susunan'] = $this->db->get('tb_susunan')->result();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('jabatan/index.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function create()
    {
        $data['actions'] = 'add';
        $data['action'] = site_url('jabatan/tambah');
        $data['modal_title'] = 'Tambah Data Jabatan';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['susunan'] = $this->db->get('tb_susunan')->result();

        $this->load->view('jabatan/create', $data);
    }

    function tambah()
    {
        $this->form_validation->set_rules('susunan', 'Susunan', 'trim|required');
        $this->form_validation->set_rules('level', 'Level', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required|callback_cek_jabatan');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'jabatan' => form_error('jabatan'),
                'susunan' => form_error('susunan'),
                'level' => form_error('level'),
                'keterangan' => form_error('keterangan'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $params = array(
                'susunan_id' => $this->input->post('susunan'),
                'pengurus_id' => $this->input->post('level'),
                'jabatan' => $this->input->post('jabatan'),
                'keterangan' => $this->input->post('keterangan'),
                'created_by' => $this->session->userdata('id'),
                'update_at' => date('Y-m-d h:i:s')
            );

            $this->M_Setting->add('tb_jabatan', $params);
            $kat = 'Tambah data Jabatan ' . $this->input->post('jabatan');
            $this->M_Setting->addlog($kat);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
    }

    function remove($id_Jabatan)
    {

        $row = $this->db->get_where('tb_jabatan', array('id_jabatan' => $id_Jabatan))->row();
        if ($row) {
            $where = array('id_jabatan' => $id_Jabatan);
            $this->M_Setting->delete($where, 'tb_jabatan');

            $kat = 'Hapus data Jabatan ' . $row->jabatan;
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



    public function update($id)
    {
        $data['actions'] = 'add';
        $data['action'] = site_url('jabatan/update_action');
        $data['modal_title'] = 'Edit Data Jabatan';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['key'] = $this->M_Jabatan->get_by_id($id);
        $data['susunan'] = $this->db->get('tb_susunan')->result();
        $data['level'] = $this->db->get_where('tb_pengurus', ['susunan_id' => $data['key']->susunan_id])->result();

        $this->load->view('jabatan/update', $data);
    }

    public function update_action()
    {

        $this->form_validation->set_rules('susunan', 'Susunan', 'trim|required');
        $this->form_validation->set_rules('level', 'Level', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required|callback_cek_jabatanedit');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'jabatan' => form_error('jabatan'),
                'susunan' => form_error('susunan'),
                'level' => form_error('level'),
                'keterangan' => form_error('keterangan'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $params = array(
                'jabatan' => $this->input->post('jabatan'),
                'keterangan' => $this->input->post('keterangan'),
                'created_by' => $this->session->userdata('id'),
                'update_at' => date('Y-m-d h:i:s')
            );
            $id_Jabatan = $this->input->post('id');
            $this->M_Jabatan->update_Jabatan($id_Jabatan, $params);
            $kat = 'Edit data Jabatan ' . $this->input->post('id');
            $this->M_Setting->addlog($kat);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diubah']);
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function cek_jabatan()
    {
        $level = $this->input->post('level');
        $jabatan = $this->input->post('jabatan');
        $susunan = $this->input->post('susunan');

        $data = $this->db->get_where('tb_jabatan', array('jabatan' => $jabatan, 'pengurus_id' => $level, 'susunan_id' => $susunan))->row();
        if ($data) {
            $this->form_validation->set_message('cek_jabatan', 'Jabatan sudah ada');
            return false;
        } else {
            return true;
        }
    }
    function cek_jabatanedit()
    {
        $level = $this->input->post('level');
        $jabatan = $this->input->post('jabatan');
        $susunan = $this->input->post('susunan');
        $id = $this->input->post('id');
        $data = $this->db->get_where('tb_jabatan', array('jabatan' => $jabatan, 'pengurus_id' => $level, 'susunan_id' => $susunan, 'id_jabatan !=' => $id))->row();
        if ($data) {
            $this->form_validation->set_message('cek_jabatanedit', 'Jabatan sudah ada');
            return false;
        } else {
            return true;
        }
    }

    public function itemdelete()
    {
        $ids = $this->input->post('ids');

        $this->db->where_in('id_jabatan', explode(",", $ids));
        $this->db->delete('tb_jabatan');
        echo json_encode(['success' => "Item Deleted successfully."]);
    }
}
