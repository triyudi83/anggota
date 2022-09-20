<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Slide extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Setting');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('Login');
        }
    }

    //index
    public function index()
    {
        $id = $this->session->userdata('id');
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Slider';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['key'] = $this->db->get('slider')->result_array();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('setting/slide/index.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Simpan',
            'action' => base_url('Slide/store'),
            'method' => 'POST',
            'modal_title' => 'Tambah Slide',
            'kd_gambar' => set_value('kd_gambar'),
            'gambar' => set_value('gambar'),
            'caption_1' => set_value('caption_1'),
        );
        $this->load->view('setting/slide/form.php', $data);
    }

    public function store()
    {
        $config['upload_path'] = './assets/images/'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->upload->initialize($config);
        if (!empty($_FILES['filefoto']['name'])) {
            if ($this->upload->do_upload('filefoto')) {
                $gbr = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/images/' . $gbr['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '60%';
                $config['width'] = 700;
                $config['height'] = 700;
                $config['new_image'] = './assets/images/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $gambar = $gbr['file_name'];
                $caption1 = strip_tags(htmlspecialchars($this->input->post('caption1', TRUE), ENT_QUOTES));
                $caption2 = strip_tags(htmlspecialchars($this->input->post('caption2', TRUE), ENT_QUOTES));
                $caption3 = strip_tags(htmlspecialchars($this->input->post('caption3', TRUE), ENT_QUOTES));

                $data = array(
                    'gambar' => $gambar,
                    'caption_1' => $caption1,
                );

                $this->db->insert('slider', $data);
                echo $this->session->set_flashdata('msg', 'success');
                redirect('Slide');
            } else {
                echo $this->session->set_flashdata('msg', 'warning');
                redirect('Slide');
            }
        } else {
            redirect('Slide');
        }
    }

    public function show($id)
    {
        $slider = $this->db->get_where('slider', array('kd_gambar' => $id))->row();
        $data = array(
            'button' => 'Ubah',
            'action' => base_url('Slide/update'),
            'method' => 'POST',
            'modal_title' => 'Ubah Slide',
            'kd_gambar' => set_value('kd_gambar', $slider->kd_gambar),
            'gambar' => set_value('gambar', $slider->gambar),
            'caption_1' => set_value('caption_1', $slider->caption_1),
        );
        $this->load->view('setting/slide/view.php', $data);
    }

    public function edit($id)
    {
        $slider = $this->db->get_where('slider', array('kd_gambar' => $id))->row();
        $data = array(
            'button' => 'Update',
            'action' => base_url('Slide/update'),
            'method' => 'POST',
            'modal_title' => 'Ubah Slide',
            'kd_gambar' => set_value('kd_gambar', $slider->kd_gambar),
            'gambar' => set_value('gambar', $slider->gambar),
            'caption_1' => set_value('caption_1', $slider->caption_1),
        );
        $this->load->view('setting/slide/form.php', $data);
    }

    public function update()
    {
        $config['upload_path'] = './assets/images/'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->upload->initialize($config);
        if (!empty($_FILES['filefoto']['name'])) {

            if ($this->upload->do_upload('filefoto')) {
                $data = $this->db->get_where('slider', array('kd_gambar' => $this->input->post('kd_gambar')))->row();
                $path = './assets/images/' . $data->gambar;
                unlink($path);

                $gbr = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/images/' . $gbr['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '60%';
                $config['width'] = 700;
                $config['height'] = 700;
                $config['new_image'] = './assets/images/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $gambar = $gbr['file_name'];
                $kode = $this->input->post('kd_gambar');
                $caption1 = strip_tags(htmlspecialchars($this->input->post('caption1', TRUE), ENT_QUOTES));
                $caption2 = strip_tags(htmlspecialchars($this->input->post('caption2', TRUE), ENT_QUOTES));
                $caption3 = strip_tags(htmlspecialchars($this->input->post('caption3', TRUE), ENT_QUOTES));

                $this->db->update('slider', array('gambar' => $gambar, 'caption_1' => $caption1, 'caption_2' => $caption2, 'caption_3' => $caption3), array('kd_gambar' => $kode));
                echo $this->session->set_flashdata('msg', 'success');
                redirect('Slide');
            } else {
                echo $this->session->set_flashdata('msg', 'warning');
                redirect('Slide');
            }
        } else {
            $kode = $this->input->post('kd_gambar');
            $caption1 = strip_tags(htmlspecialchars($this->input->post('caption1', TRUE), ENT_QUOTES));
            $caption2 = strip_tags(htmlspecialchars($this->input->post('caption2', TRUE), ENT_QUOTES));
            $caption3 = strip_tags(htmlspecialchars($this->input->post('caption3', TRUE), ENT_QUOTES));
            $this->db->update('slider', array('caption_1' => $caption1, 'caption_2' => $caption2, 'caption_3' => $caption3), array('kd_gambar' => $kode));
            echo $this->session->set_flashdata('msg', 'success');
            redirect('Slide');
        }
    }

    public function delete($id)
    {
        $data = $this->db->get_where('slider', array('kd_gambar' => $id))->row();
        if ($data) {
            $path = './assets/images/' . $data->gambar;
            unlink($path);
            $this->M_Setting->delete(array('kd_gambar' => $id), 'slider');

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
}
