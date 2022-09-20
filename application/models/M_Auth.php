<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{

    function get($nama, $password)
    {
        $this->db->where('email', $nama);
        $this->db->where('password', md5($password));
        return $this->db->get('users')->row();
    }
}
