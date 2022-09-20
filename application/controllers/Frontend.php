<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Setting');
        $this->load->model('M_Anggota');
    }

    public function index()
    {
        $data['slide'] = $this->db->get('slider')->result();
        $data['prov'] = $this->db->get('tb_provinsi')->result_array();
        $this->load->view('frontend/index', $data);
    }

    public function get_kota()
    {
        $kota = $this->db->get_where('tb_kota', ['id_provinsi' => $this->input->post('id_provinsi')])->result();
        $lists = "<option value=''>Pilih Kota / Kabupaten</option>";
        foreach ($kota as $data) {
            $lists .= "<option value='" . $data->id_kota . "'>" . $data->name_kota . "</option>";
        }
        $callback = array('list_kota' => $lists);
        echo json_encode($callback);
    }

    public function get_kec()
    {
        $kota = $this->db->get_where('tb_kecamatan', ['id_kota' => $this->input->post('id_kota')])->result();
        $lists = "<option value=''>Pilih Kecamatan</option>";
        foreach ($kota as $data) {
            $lists .= "<option value='" . $data->id_kecamatan . "'>" . $data->kecamatan . "</option>";
        }
        $callback = array('list_kec' => $lists);
        echo json_encode($callback);
    }

    public function get_kel()
    {
        $kota = $this->db->get_where('tb_kelurahan', ['id_kecamatan' => $this->input->post('id_kecamatan')])->result();
        $lists = "<option value=''>Pilih Kelurahan</option>";
        foreach ($kota as $data) {
            $lists .= "<option value='" . $data->id_kelurahan . "'>" . $data->kelurahan . "</option>";
        }
        $callback = array('list_kel' => $lists);
        echo json_encode($callback);
    }

    function save()
    {
        $this->form_validation->set_rules('nik', 'nik', 'trim|required|callback_nik_check');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('bagian', 'Bagian', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nik' => form_error('nik'),
                'nama' => form_error('nama'),
                'bagian' => form_error('bagian'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        }else{
           //filefoto upload
            $config['upload_path'] = './assets/ktp/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 5000;
            $config['file_name'] = 'anggota-' . time();
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('filefoto')) {
                $result = array('filefoto' => $this->upload->display_errors());
                echo json_encode(['status' => 'error', 'message' => $result]);

                return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => $result]));
            } else {
                $filefoto = $this->upload->data();
                
                $data = [
                    'nik' => $this->input->post('nik'),
                    'nama' => $this->input->post('nama'),
                    'bagian' => $this->input->post('bagian'),
                    'foto' => 'assets/ktp/'.$filefoto['file_name'],
                    'status'  => 'Verifikasi',
                    'status_anggota'  => 'Aktif',
                ];

                $this->db->insert('tb_pendaftaran', $data);

                return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Data Berhasil Disimpan']));
            }


           
        }
    }

    function cek_nik()
    {
        $where = array(
            'nik' => $this->input->post('nik'),
            'status_anggota' => 'aktif'
        );
        $hasil_kode = $this->M_Setting->cek('tb_pendaftaran', $where);
        if (count($hasil_kode) != 0) {
            echo '1';
        } else {
            echo '2';
        }
    }

    public function email($email)
    {
        error_reporting(0);
        $config = array(
            'mail_from_mail' => 'petigakita@gmail.com',
            'mail_from_name' => 'DPC PPP Situbondo',
            'mail_bcc' => 'my_email@example.com',
            'mail_setBcc' => true
        );
        $data = array(
            "NAME"       => 'DPC PPP Situbondo',
        );

        $template_html = 'sample-2.html';

        $mail = new Mail($config);
        $mail->AddEmbeddedImage('assets/ktp/Logo.png', 'logo', 'Logo.png');
        $mail->IsHTML(true);
        $mail->setMailBody($data, $template_html);
        return $mail->sendMail('KONFIRMASI PENDAFTARAN CALON ANGGOTA KELUARGA BESAR PPP SITUBONDO', $email);
    }

    public function nik_check()
    {
       $nik = $this->input->post('nik');
       $cek = $this->db->get_where('tb_pendaftaran', array('nik' => $nik,'status_anggota' => 'aktif'))->row();
       if($cek){
        $this->form_validation->set_message('nik_check', 'NIK sudah terdaftar');
        return false;
       }else{
        return true;
       }
    }
}
