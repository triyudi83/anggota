<?php
    if (!function_exists('tomboltambah')) {
        function tomboltambah($submenu)
        {   

            $CI =& get_instance();

            $id=$CI->session->userdata('role_user');
            
            $idsubmenu = $CI->db->get_where('tb_submenu', array('submenu' => $submenu))->row_array();
            $tambah = array(
                'id' => $id,
                'add' => '1',
                'id_submenu' => $idsubmenu['id_submenu']
            );

            $hasiltambah = $CI->db->get_where('tb_akses', $tambah)->result();
            if (count($hasiltambah) != 0) {
                $tomboltambah = 'aktif';
            } else {
                $tomboltambah = 'tidak';
            }


            return $tomboltambah;
        }
    }

    if (!function_exists('tomboledit')) {
        function tomboledit($submenu)
        {   

            $CI =& get_instance();

            $id=$CI->session->userdata('role_user');
            
            $idsubmenu = $CI->db->get_where('tb_submenu', array('submenu' => $submenu))->row_array();
            $tambah = array(
                'id' => $id,
                'edit' => '1',
                'id_submenu' => $idsubmenu['id_submenu']
            );

            $hasiltambah = $CI->db->get_where('tb_akses', $tambah)->result();
            if (count($hasiltambah) != 0) {
                $tomboledit = 'aktif';
            } else {
                $tomboledit = 'tidak';
            }


            return $tomboledit;
        }
    }

    if (!function_exists('tombolhapus')) {
        function tombolhapus($submenu)
        {   

            $CI =& get_instance();

            $id=$CI->session->userdata('role_user');
            
            $idsubmenu = $CI->db->get_where('tb_submenu', array('submenu' => $submenu))->row_array();
            $tambah = array(
                'id' => $id,
                'delete' => '1',
                'id_submenu' => $idsubmenu['id_submenu']
            );

            $hasiltambah = $CI->db->get_where('tb_akses', $tambah)->result();
            if (count($hasiltambah) != 0) {
                $tombolhapus = 'aktif';
            } else {
                $tombolhapus = 'tidak';
            }


            return $tombolhapus;
        }
    }

    if (!function_exists('tombolview')) {
        function tombolview($submenu)
        {   

            $CI =& get_instance();

            $id=$CI->session->userdata('role_user');
            
            $idsubmenu = $CI->db->get_where('tb_submenu', array('submenu' => $submenu))->row_array();
            $tambah = array(
                'id' => $id,
                'view' => '1',
                'id_submenu' => $idsubmenu['id_submenu']
            );

            $hasiltambah = $CI->db->get_where('tb_akses', $tambah)->result();
            if (count($hasiltambah) != 0) {
                $tombolview = 'aktif';
            } else {
                $tombolview = 'tidak';
            }


            return $tombolview;
        }
    }

    if (! function_exists('hitung_umur')) {
        function hitung_umur($tgl)
        {
            $tanggal = new DateTime($tgl);
            $today = new DateTime('today');
            $y = $today->diff($tanggal)->y;
            $m = $today->diff($tanggal)->m;
            $d = $today->diff($tanggal)->d;
            return $y;
        }
    }
?>