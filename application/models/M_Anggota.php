<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Anggota extends CI_Model
{
    function get_by_status($status1, $status2)
    {
       
        $this->db->select('*');
        $this->db->from('tb_pendaftaran');
        $this->db->where(['status' => $status1, 'status_anggota' => $status2]);
        return $this->db->get()->result();
    }

    //get_by_id
    function get_by_id($detail)
    {
        $this->db->select('*');
        $this->db->from('tb_pendaftaran');
        $this->db->where('tb_pendaftaran.id', $detail);
        return $this->db->get()->row();
    }

    function get_keterangan($detail, $keterangan)
    {
        $this->db->select('*');
        $this->db->from('tb_pendaftaran');
        $this->db->where(['id' => $detail, 'status_anggota' => $keterangan]);
        return $this->db->get()->row();
    }

    public function update($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_pendaftaran', $params);
    }


    function dashboard($bulan, $status_anggota, $status)
    {
        $this->db->select('*');
        $this->db->from('tb_pendaftaran');
        if ($status_anggota == 'Aktif') {
            $this->db->where(['MONTH(created_at)' => $bulan, 'YEAR(created_at)' => date('Y'), 'status_anggota' => $status_anggota, 'status' => $status]);
        } else {
            $this->db->where(['MONTH(tgl_nonaktif)' => $bulan, 'YEAR(tgl_nonaktif)' => date('Y'), 'status_anggota' => $status_anggota, 'status' => $status]);
        }
        $query = $this->db->count_all_results();
        return $query;
    }

    function kecamatan($id_kecamatan)
    {
        $this->db->select('*');
        $this->db->from('tb_pendaftaran');
        $this->db->where(['id_kecamatan' => $id_kecamatan, 'status' => 'Verifikasi', 'status_anggota' => 'Aktif']);
        return $this->db->count_all_results();
    }

    function jk($id_kecamatan, $jk)
    {
        $this->db->select('*');
        $this->db->from('tb_pendaftaran');
        $this->db->where(['id_kecamatan' => $id_kecamatan, 'jk' => $jk, 'status' => 'Verifikasi', 'status_anggota' => 'Aktif']);
        return $this->db->count_all_results();
    }

    function search($detail)
    {
        $this->db->from('tb_pendaftaran');
        $this->db->like('nama', $detail);
        $this->db->or_like('nik', $detail);
        $this->db->where(['status' => 'Verifikasi', 'status_anggota' => 'Aktif']);
        return $this->db->get()->result();
    }

    function get_by_nik($id)
    {
        $this->db->select('tb_pendaftaran.*,tb_provinsi.name_prov,tb_kota.name_kota,tb_kecamatan.kecamatan,tb_kelurahan.kelurahan');
        $this->db->from('tb_pendaftaran');
        $this->db->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_pendaftaran.id_provinsi');
        $this->db->join('tb_kota', 'tb_kota.id_kota = tb_pendaftaran.id_kota');
        $this->db->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan = tb_pendaftaran.id_kecamatan');
        $this->db->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan = tb_pendaftaran.id_kelurahan');
        $this->db->where(['id' => $id]);
        return $this->db->get()->row();
    
    
    }
    function get_export($where)
    {
        $this->db->select('tb_pendaftaran.*,tb_provinsi.name_prov,tb_kota.name_kota,tb_kecamatan.kecamatan,tb_kelurahan.kelurahan');
        $this->db->from('tb_pendaftaran');
        $this->db->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_pendaftaran.id_provinsi');
        $this->db->join('tb_kota', 'tb_kota.id_kota = tb_pendaftaran.id_kota');
        $this->db->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan = tb_pendaftaran.id_kecamatan');
        $this->db->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan = tb_pendaftaran.id_kelurahan');
        $this->db->where($where);
        return $this->db->get()->result();
    }
}
