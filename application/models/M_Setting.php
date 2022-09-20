<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Setting extends CI_Model
{

    function getmenu($id)
    {
        $this->db->select('tb_menu.*');
        $this->db->join('tb_submenu', 'tb_submenu.id_menus = tb_menu.id_menu');
        $this->db->join('tb_akses', 'tb_akses.id_submenu = tb_submenu.id_submenu');
        $where = array(
            'tb_akses.id' => $id, 'tb_akses.view' => '1', 'tb_submenu.statusmenu' => 'aktif', 'tb_submenu.statusmenu' => 'aktif',
        );
        $this->db->group_by('tb_menu.id_menu');
        $this->db->order_by('tb_menu.urutan', 'ASC');
        $query = $this->db->get_where('tb_menu', $where);
        return $query->result();
    }

    function cekakses($tabel, $where)
    {
        $query = $this->db->get_where($tabel, $where);
        return $query->result();
    }

    function getsubmenu($id)
    {
        $this->db->select('tb_submenu.*');
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_submenu.id_menus');
        $this->db->join('tb_akses', 'tb_akses.id_submenu = tb_submenu.id_submenu');
        $where = array(
            'tb_akses.id' => $id, 'tb_akses.view' => '1', 'tb_submenu.statusmenu' => 'aktif', 'tb_submenu.statusmenu' => 'aktif',
        );
        $query = $this->db->get_where('tb_submenu', $where);
        return $query;
    }

    function log()
    {
        $this->db->join('users', 'users.id = tb_userlog.id');
        $this->db->order_by('tb_userlog.tgl_update', 'DESC');
        $query = $this->db->get('tb_userlog');
        return $query->result_array();
    }

    function json()
    {
        $this->serverside->select('*');
        $this->serverside->from('tb_userlog');
        $this->serverside->join('users', 'users.id = tb_userlog.id');
        return $this->serverside->generate();
    }
    function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
        $this->db->query("ALTER TABLE $table AUTO_INCREMENT 0");
    }

    function cek($tabel, $where)
    {
        $this->db->select('*');
        $query = $this->db->get_where($tabel, $where);
        return $query->result();
    }

    function cekarray($cek, $kode, $tabel)
    {
        $this->db->select('*');
        $where = array(
            $cek => $kode
        );
        $query = $this->db->get_where($tabel, $where);
        return $query->result_array();
    }

    function addlog($ket)
    {
        $user = array(
            'id_user' => $this->session->userdata('id'),
            'tgl_update' => date('Y-m-d G:i:s'),
            'jenislog' => 'aktivitas',
            'ket' => $ket
        );

        $this->db->insert('tb_userlog', $user);
    }

    function addlogin($ket, $jenislog)
    {
        $user = array(
            'id_user' => $this->session->userdata('id'),
            'tgl_update' => date('Y-m-d G:i:s'),
            'jenislog' => $jenislog,
            'ket' => $ket
        );

        $this->db->insert('tb_userlog', $user);
    }

    function getakses($ida)
    {
        $this->db->order_by('tb_menu.urutan', 'ASC');
        $this->db->select('*');
        $this->db->join('tb_submenu', 'tb_submenu.id_submenu = tb_akses.id_submenu');
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_submenu.id_menus');
        $where = array(
            'id' => $ida,
            'tb_submenu.statusmenu' => 'aktif'
        );
        $query = $this->db->get_where('tb_akses', $where);
        return $query->result();

        // return $this->db->get('tb_menu')->result();
    }


    function editv($iduser, $submenu, $view)
    {
        $where = array(
            'id' =>  $iduser,
            'id_submenu' => $view
        );

        $view = array(
            'view' =>  '1'
        );

        $this->db->where($where);
        $this->db->update('tb_akses', $view);
    }

    function edita($iduser, $submenu, $add)
    {
        $where = array(
            'id' =>  $iduser,
            'id_submenu' => $add
        );

        $add = array(
            'add' =>  '1'
        );

        $this->db->where($where);
        $this->db->update('tb_akses', $add);
    }

    function edite($iduser, $submenu, $edit)
    {
        $where = array(
            'id' =>  $iduser,
            'id_submenu' => $edit
        );

        $edit = array(
            'edit' =>  '1'
        );

        $this->db->where($where);
        $this->db->update('tb_akses', $edit);
    }


    function editd($iduser, $submenu, $delete)
    {
        $where = array(
            'id' =>  $iduser,
            'id_submenu' => $delete
        );

        $delete = array(
            'delete' =>  '1'
        );

        $this->db->where($where);
        $this->db->update('tb_akses', $delete);
    }

    function refresh($iduser)
    {
        $user = array(
            'view' => '0',
            'add' => '0',
            'edit' => '0',
            'delete' => '0'
        );

        $where = array(
            'id' =>  $iduser
        );

        $this->db->where($where);
        $this->db->update('tb_akses', $user);
    }

    public function get_log_login_all()
    {
        $this->db->select('kar.id, kar.name, tb_userlog.*');
        $this->db->join('users kar', 'kar.id=tb_userlog.id_user');
        $this->db->order_by('tb_userlog.id_log', 'DESC');
        $this->db->where('jenislog !=', 'aktivitas');
        $this->db->limit(2000);
        $data = $this->db->get('tb_userlog')->result_array();
        return $data;
    }

    public function get_log_login_last()
    {
        $this->db->order_by('id_log', 'DESC');
        $this->db->where('jenislog', 'login');
        $this->db->or_where('jenislog', 'logout');
        $this->db->limit(5);
        $data = $this->db->get('tb_userlog')->result_array();
        return $data;
    }

    public function get_log_aktivitas_all()
    {
        $this->db->select('kar.id, kar.name, tb_userlog.*');
        $this->db->join('users kar', 'kar.id=tb_userlog.id_user');
        $this->db->order_by('tb_userlog.id_log', 'DESC');
        // $this->db->where('tb_userlog.jenislog', 'aktivitas');
        $this->db->limit(2000);
        $data = $this->db->get('tb_userlog')->result_array();
        return $data;
    }

    public function get_log_aktivitas_last()
    {
        $this->db->select('kar.id, kar.name, tb_userlog.*');
        $this->db->join('users kar', 'kar.id=tb_userlog.id_user');
        $this->db->order_by('tb_userlog.id_log', 'DESC');
        $this->db->where('tb_userlog.jenislog', 'aktivitas');
        $this->db->limit(5);
        $data = $this->db->get('tb_userlog')->result_array();
        return $data;
    }

    function add($table, $params)
    {
        $this->db->insert($table, $params);
    }
}
