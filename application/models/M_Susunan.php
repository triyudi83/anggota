<?php
class M_Susunan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get user by id_user
     */
    function get_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_susunan')->row();
    }

    function get_jabatan($id_jabatan)
    {
        $this->db->get_where('tb_jabatan', array('id_jabatan' => $id_jabatan))->result_array();
    }

    // get_all_susunan//

    function get_all()
    {
        $this->db->select('*');
        $this->db->from('tb_susunan');
        $this->db->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_susunan.provinsi_id');
        $this->db->join('tb_kota', 'tb_kota.id_kota = tb_susunan.kota_id');
        $this->db->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan = tb_susunan.kecamatan_id');
        $this->db->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan = tb_susunan.desa_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_by_join($id_jabatan)
    {
        $this->db->select('*');
        $this->db->from('tb_susunan');
        $this->db->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_susunan.provinsi_id');
        $this->db->join('tb_kota', 'tb_kota.id_kota = tb_susunan.kota_id');
        $this->db->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan = tb_susunan.kecamatan_id');
        $this->db->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan = tb_susunan.desa_id');
        $this->db->where('tb_susunan.id', $id_jabatan);
        $query = $this->db->get();
        return $query;
    }

    function get_byperson($nik)
    {
        $this->db->select('list_pengurus.*, tb_pendaftaran.nama namaorang, tb_pendaftaran.foto, tb_susunan.*, tb_pengurus.level, tb_jabatan.jabatan, tb_kelurahan.kelurahan, 
        tb_kecamatan.kecamatan, tb_kota.name_kota, tb_provinsi.name_prov');
        $this->db->from('list_pengurus');
        $this->db->join('tb_pendaftaran', 'tb_pendaftaran.nik = list_pengurus.member_id');
        $this->db->join('tb_susunan', 'tb_susunan.id = list_pengurus.susunan_id');
        $this->db->join('tb_pengurus', 'tb_pengurus.id_pengurus = list_pengurus.pengurus_id');
        $this->db->join('tb_jabatan', 'tb_jabatan.id_jabatan = list_pengurus.jabatan_id');
        $this->db->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_susunan.provinsi_id');
        $this->db->join('tb_kota', 'tb_kota.id_kota = tb_susunan.kota_id');
        $this->db->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan = tb_susunan.kecamatan_id');
        $this->db->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan = tb_susunan.desa_id');
        $this->db->where('list_pengurus.member_id', $nik);
        $query = $this->db->get();
        return $query;
    }

    function jabatan($id)
    {
        $this->db->select('list_pengurus.*,  tb_susunan.nama as susunan, tb_pengurus.level, tb_jabatan.jabatan');
        $this->db->from('list_pengurus');
        $this->db->join('tb_susunan', 'tb_susunan.id = list_pengurus.susunan_id');
        $this->db->join('tb_pengurus', 'tb_pengurus.id_pengurus = list_pengurus.pengurus_id');
        $this->db->join('tb_jabatan', 'tb_jabatan.id_jabatan = list_pengurus.jabatan_id');
        $this->db->where(['list_pengurus.member_id' => $id]);
        $query = $this->db->get();
        return $query->result();
    }

    function get_list()
    {
        $this->db->select('*');
        $this->db->join('tb_pendaftaran', 'tb_pendaftaran.nik = list_pengurus.member_id');
        $this->db->group_by('member_id');
        $query = $this->db->get('list_pengurus');
        return $query;
    }

    /*
     * function to update user
     */
    function update_Jabatan($id_jabatan, $params)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        return $this->db->update('tb_jabatan', $params);
    }
    function insert($params)
    {
        $this->db->insert('tb_susunan', $params);
        return $this->db->insert_id();
    }

    function update($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('tb_susunan', $params);
    }

    function pengurus($where)
    {
        $this->db->select('list_pengurus.*,  tb_susunan.nama as susunan, tb_pengurus.level, tb_jabatan.jabatan, tb_pendaftaran.nama as nama_pengurus');
        $this->db->from('list_pengurus');
        $this->db->join('tb_susunan', 'tb_susunan.id = list_pengurus.susunan_id');
        $this->db->join('tb_pengurus', 'tb_pengurus.id_pengurus = list_pengurus.pengurus_id');
        $this->db->join('tb_jabatan', 'tb_jabatan.id_jabatan = list_pengurus.jabatan_id');
        $this->db->join('tb_pendaftaran', 'tb_pendaftaran.nik = list_pengurus.member_id');
        $this->db->where($where);
        $this->db->order_by('tb_jabatan.jabatan', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
}
