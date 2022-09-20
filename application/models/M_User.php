<?php
class M_User extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get user by id_user
     */
    function get_user($id_user)
    {
        $this->db->get_where('users', array('id_user' => $id_user))->result_array();
    }

    /*
     * function to update user
     */
    function update_user($id_user, $params)
    {
        $this->db->where('id', $id_user);
        return $this->db->update('users', $params);
    }

    /*
     * function to delete user
     */
    function delete_user($id_user)
    {
        return $this->db->delete('users', array('id_user' => $id_user));
    }

    public function allakses()
    {
        $this->db->join('users', 'users.id=tb_akses.id');
        $this->db->group_by('tb_akses.id', 'DESC');
        return $this->db->get('tb_akses')->result_array();
    }

    public function tambahakses($params)
    {
        $data = $this->db->get_where('tb_akses', array('id' => $params))->result();
        
        $this->db->get_where('tb_submenu', ['statusmenu' => 'aktif']);

    }

    public function get_all(){
        $this->db->select('users.*, role_users.nama_role');
        $this->db->from('users');
        $this->db->join('role_users', 'role_users.id = users.role_user','left');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
