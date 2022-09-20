<?php

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Anggota');
        $this->load->model('M_Setting');
        $this->load->model('M_Susunan');
        $this->load->model('M_Pengurus');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    public function calonanggota()
    {
        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Laporan';
        $data['activeMenu'] = 'Lap. Calon Anggota';
        $data['jenis_laporan'] = 'Calon Anggota';
        $data['register'] = $this->M_Anggota->get_by_status('Baru', 'Aktif');
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('laporan/calon_anggota.php', $data);
        $this->load->view('template/footer.php', $data);
    }
    public function anggota($anggota)
    {
        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Laporan';
        if ($anggota == 'aktif') {
            $data['activeMenu'] = 'Lap. Anggota Aktif';
            $data['jenis_laporan'] = 'Anggota Aktif';
            $data['register'] = $this->M_Anggota->get_by_status('Verifikasi', 'Aktif');
            $data['ket'] = 'Aktif';
            $data['anggota'] = 'aktif';
        } else if ($anggota == 'tidakaktif') {
            $data['activeMenu'] = 'Lap. Anggota Tidak Aktif';
            $data['jenis_laporan'] = 'Anggota Tidak Aktif';
            $data['register'] = $this->M_Anggota->get_by_status('Verifikasi', 'Tidak');
            $data['ket'] = 'Tidak';
            $data['anggota'] = 'tidakaktif';
        }
        $data['kecamatan'] = $this->db->get_where('tb_kecamatan', ['id_kota' => '3512'])->result();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('laporan/anggota.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function pengurus()
    {
        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Laporan';
        $data['activeMenu'] = 'Lap. Susunan Kepengurusan';
        $data['susunan'] = $this->M_Susunan->get_all();
        $data['pengurus'] = $this->M_Pengurus->get_all();
        $data['list'] = $this->M_Susunan->get_list()->result();
        $data['ajax'] = base_url('laporan/pengurus_ajax/');
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('laporan/pengurus.php', $data);
        $this->load->view('template/footer.php', $data);
    }


    public function pengurus_ajax()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('Select list_pengurus.id, tb_susunan.nama as susunan, tb_pendaftaran.nik as nik, tb_pendaftaran.nama as member,  tb_pengurus.level, tb_jabatan.jabatan, awal_jabatan, akhir_jabatan
            from list_pengurus
            join tb_susunan on tb_susunan.id = list_pengurus.susunan_id
            join tb_pendaftaran on tb_pendaftaran.nik = list_pengurus.member_id
            join tb_pengurus on tb_pengurus.id_pengurus = list_pengurus.pengurus_id
            join tb_jabatan on tb_jabatan.id_jabatan = list_pengurus.jabatan_id
            ');

        $datatables->edit('awal_jabatan', function ($data) {
            return date('d-m-Y', strtotime($data['awal_jabatan']));
        });
        $datatables->edit('akhir_jabatan', function ($data) {
            return date('d-m-Y', strtotime($data['akhir_jabatan']));
        });

        echo $datatables->generate();
    }

    public function download(){
        $id = $this->input->post('id');
     
        if($id == ''){
            $id = $this->session->userdata('role_user');
            $data['menu'] = $this->M_Setting->getmenu($id);
            $data['submenu'] = $this->M_Setting->getsubmenu($id);
            $data['katMenu'] = 'Laporan';
            $data['activeMenu'] = 'Lap. Susunan Kepengurusan';
            $data['susunan'] = $this->M_Susunan->get_all();
            $data['pengurus'] = $this->M_Pengurus->get_all();
            $data['ajax'] = base_url('laporan/pengurus_ajax/');
            $this->load->view('template/header.php', $data);
            $this->load->view('template/sidebar.php', $data);
            $this->load->view('laporan/pengurusa.php', $data);
            $this->load->view('template/footer.php', $data);
        }else{
            $pengurus = $this->M_Pengurus->get_level($id);
            $row = $this->M_Susunan->get_by_id($id);
    
           $mpdf = new \Mpdf\Mpdf();
           $data = $this->load->view('laporan/form', array(
            "pengurus" => $pengurus,
            ), TRUE);
            $mpdf->WriteHTML($data);
            $file_name = $row->nama.".pdf";
            $mpdf->Output($file_name, 'I');
        }
    }
    public function downloada(){

       

    }
}
