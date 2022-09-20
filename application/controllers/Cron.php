<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
       
    }

    public function cron_job(){
        $date = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('list_pengurus');
        $this->db->where('akhir_jabatan < date("'.$date.'")');
        $this->db->where('status', 'aktif');
        $query = $this->db->get()->result();
       
        foreach ($query as $key) {
            $this->db->where('id', $key->id);
            $this->db->update('list_pengurus', ['status' => 'tidak']);
        }

    }
}
