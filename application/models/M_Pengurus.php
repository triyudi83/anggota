<?php
class M_Pengurus extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get user by id_user
     */
    function get_pengurus($id_pengurus)
    {
        $this->db->get_where('tb_pengurus', array('id_pengurus' => $id_pengurus))->result_array();
    }

    /*
     * function to update user
     */
    function update_pengurus($id_pengurus, $params)
    {
        $this->db->where('id_pengurus', $id_pengurus);
        return $this->db->update('tb_pengurus', $params);
    }

    function get_all(){
        $this->db->select('tb_pengurus.*, tb_susunan.nama as nama_susunan');
        $this->db->from('tb_pengurus');
        $this->db->join('tb_susunan', 'tb_susunan.id = tb_pengurus.susunan_id');
        $this->db->order_by('tb_pengurus.susunan_id', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_by_id($id){
        $this->db->select('tb_pengurus.*, tb_susunan.nama as nama_susunan');
        $this->db->from('tb_pengurus');
        $this->db->join('tb_susunan', 'tb_susunan.id = tb_pengurus.susunan_id');
        $this->db->where('tb_pengurus.id_pengurus', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_level($id){
        $this->db->select('tb_pengurus.*, tb_susunan.nama as nama_susunan');
        $this->db->from('tb_pengurus');
        $this->db->join('tb_susunan', 'tb_susunan.id = tb_pengurus.susunan_id');
        $this->db->order_by('tb_pengurus.susunan_id', 'asc');
        $this->db->where('tb_pengurus.susunan_id', $id);
        $query['list'] = $this->db->get()->result();

        foreach ($query['list'] as $key => $value) {
            $this->db->select('list_pengurus.*, tb_jabatan.jabatan, tb_pendaftaran.nama as nama_pengurus');
            $this->db->from('list_pengurus');
            $this->db->join('tb_jabatan', 'tb_jabatan.id_jabatan = list_pengurus.jabatan_id');
            $this->db->join('tb_pendaftaran', 'tb_pendaftaran.nik = list_pengurus.member_id');
            $this->db->where([
                'list_pengurus.pengurus_id' => $value->id_pengurus, 
                'list_pengurus.susunan_id' => $value->susunan_id, 
                'list_pengurus.status' => 'aktif',
            ]);
            $this->db->order_by('list_pengurus.id', 'asc');

            
            $query['list'][$key]->list_ketua = $this->db->get()->result();

        }

        return $query;
    }

  
}
