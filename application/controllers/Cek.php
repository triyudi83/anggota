<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cek extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Anggota');
        $this->load->model('M_Susunan');
        $this->load->model('M_Setting');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view('auth/cek');
    }

    function search()
    {
        $lists = '<div class="box-footer no-padding">
        <ul class="nav nav-stacked">';
        $id = $this->input->post('cek');
        if($id == ''){
            $lists .= '<li></li>';
        }
            else{
            $data = $this->M_Anggota->search($id);
            if($data){
                foreach ($data as $t) {
                    $lists .= "<li><a href='" . base_url() . "CekAnggota/show/" . $t->id  . "' class='ActView' ><i class='fa fa-folder-open-o' aria-hidden='true'> </i> " . $t->nama . "<span class='pull-right badge bg-blue'>Lihat</span></a></li>";
                }
            }else{
                $lists .= "<li><a href='#'><i class='fa fa-folder-open-o' aria-hidden='true'> </i> Data tidak ditemukan<span class='pull-right badge bg-blue'>Lihat</span></a></li>";
            }

        } 
        $lists .= "</ul></div>";
        $callback = array('list_user' => $lists); 
        echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }


    public function show($id)
    {

        $data['actions'] = 'add';
        $data['modal_title'] = 'Profil';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['key'] = $this->M_Anggota->get_by_id($id);
        $this->load->view('auth/profil', $data);
    }
}
