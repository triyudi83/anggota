<?php
class M_Jabatan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get user by id_user
     */
    function get_jabatan($id_jabatan)
    {
        $this->db->get_where('tb_jabatan', array('id_jabatan' => $id_jabatan))->result_array();
    }

    /*
     * function to update user
     */
    function update_Jabatan($id_jabatan, $params)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        return $this->db->update('tb_jabatan', $params);
    }

    function get_all(){
        $this->db->select('tb_jabatan.*, tb_susunan.nama as nama_susunan,tb_pengurus.level as level_pengurus');
        $this->db->from('tb_jabatan');
        $this->db->join('tb_susunan', 'tb_susunan.id = tb_jabatan.susunan_id');
        $this->db->join('tb_pengurus', 'tb_pengurus.id_pengurus = tb_jabatan.pengurus_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_by_id($id){
        $this->db->select('tb_jabatan.*, tb_susunan.nama as nama_susunan,tb_pengurus.level as level_pengurus');
        $this->db->from('tb_jabatan');
        $this->db->join('tb_susunan', 'tb_susunan.id = tb_jabatan.susunan_id');
        $this->db->join('tb_pengurus', 'tb_pengurus.id_pengurus = tb_jabatan.pengurus_id');
        $this->db->where('tb_jabatan.id_jabatan', $id);
        $query = $this->db->get();
        return $query->row();
    }
}
