<?php

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

defined('BASEPATH') or exit('No direct script access allowed');

class Susunan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Susunan');
        $this->load->model('M_Setting');
        $this->load->model('M_Anggota');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    /*
     * Listing of Jabatan
     */
    public function index()
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Kepengurusan';
        $data['activeMenu'] = 'Susunan Pengurus';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);

        $data['susunan'] = $this->M_Susunan->get_all();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('susunan/index.php', $data);
        $this->load->view('template/footer.php', $data);

        $this->nonaktif();
    }

    public function create()
    {

        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Kepengurusan';
        $data['activeMenu'] = 'Susunan Pengurus';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['provinsi'] = $this->db->get('tb_provinsi')->result();
        $data['kabupaten'] = '';
        $data['kecamatan'] = '';
        $data['desa'] = '';

        $data['id'] = set_value('id');
        $data['nama'] = set_value('nama');
        $data['alamat'] = set_value('alamat');
        $data['provinsi_id'] = set_value('provinsi_id');
        $data['kota_id'] = set_value('kota_id');
        $data['kecamatan_id'] = set_value('kecamatan_id');
        $data['desa_id'] = set_value('desa_id');
        $data['no_hp'] = set_value('no_hp');
        $data['email'] = set_value('email');


        $data['title'] = 'Tambah Data Susunan Pengurus';
        $data['action'] = site_url('susunan/store');
        $data['button'] = 'Tambah';

        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('susunan/form.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|is_unique[tb_susunan.nama]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp', 'No Telp', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|required');
        $this->form_validation->set_rules('desa', 'Desa', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nama' => form_error('nama'),
                'alamat' => form_error('alamat'),
                'no_telp' => form_error('no_telp'),
                'email' => form_error('email'),
                'provinsi' => form_error('provinsi'),
                'kabupaten' => form_error('kabupaten'),
                'kecamatan' => form_error('kecamatan'),
                'desa' => form_error('desa'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'phone' => $this->input->post('no_telp'),
                'email' => $this->input->post('email'),
                'provinsi_id' => $this->input->post('provinsi'),
                'kota_id' => $this->input->post('kabupaten'),
                'kecamatan_id' => $this->input->post('kecamatan'),
                'desa_id' => $this->input->post('desa'),
            );
            $this->db->insert('tb_susunan', $data);

            $kat = 'Tambah data Susunan Pengurus ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);

            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
    }

    public function edit($id_susunan)
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Kepengurusan';
        $data['activeMenu'] = 'Susunan Pengurus';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['provinsi'] = $this->db->get('tb_provinsi')->result();

        $row = $this->M_Susunan->get_by_id($id_susunan);
        if ($row) {
            $data['id'] = $id_susunan;
            $data['nama'] = $row->nama;
            $data['alamat'] = $row->alamat;
            $data['provinsi_id'] = $row->provinsi_id;
            $data['kota_id'] = $row->kota_id;
            $data['kecamatan_id'] = $row->kecamatan_id;
            $data['desa_id'] = $row->desa_id;
            $data['no_hp'] = $row->phone;
            $data['email'] = $row->email;

            $data['kabupaten'] = $this->db->get_where('tb_kota', ['id_provinsi' => $row->provinsi_id])->result();
            $data['kecamatan'] = $this->db->get_where('tb_kecamatan', ['id_kota' => $row->kota_id])->result();
            $data['desa'] = $this->db->get_where('tb_kelurahan', ['id_kecamatan' => $row->kecamatan_id])->result();

            $data['title'] = 'Edit Data Susunan Pengurus';
            $data['action'] = site_url('susunan/update');
            $data['button'] = 'Update';
            $this->load->view('template/header.php', $data);
            $this->load->view('template/sidebar.php', $data);
            $this->load->view('susunan/form.php', $data);
            $this->load->view('template/footer.php', $data);
        } else {
            return show_404();
        }
    }


    public function detail($id_susunan)
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Kepengurusan';
        $data['activeMenu'] = 'Susunan Pengurus';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['provinsi'] = $this->db->get('tb_provinsi')->result();

        $row = $this->M_Susunan->get_by_join($id_susunan)->row();
        if ($row) {
            $data['title'] = 'Data Susunan Pengurus';
            $data['action'] = site_url('susunan/update');
            $data['button'] = 'Update';
            $data['database'] = $row;
            $data['ajax'] = base_url('susunan/ajax/' . $row->id);
            $this->load->view('template/header.php', $data);
            $this->load->view('template/sidebar.php', $data);
            $this->load->view('susunan/detail.php', $data);
            $this->load->view('template/footer.php', $data);
        } else {
            return show_404();
        }
    }




    function hapus($id_Jabatan)
    {

        $row = $this->db->get_where('tb_susunan', array('id' => $id_Jabatan))->row();
        if ($row) {
            $where = array('id' => $id_Jabatan);
            $this->M_Setting->delete($where, 'tb_susunan');

            $kat = 'Hapus data Susunan Pengurus ' . $row->nama;
            $this->M_Setting->addlog($kat);

            $result['success'] = 'Data Berhasil Dihapus';
            $result['icon'] = 'success';
            $result['title'] = 'Berhasil';
        } else {
            $result['error'] = 'Record Not Found';
            $result['icon'] = 'error';
            $result['title'] = 'Oops...';
        }
        echo json_encode($result);
    }



    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|callback_cek_namaedit');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp', 'No Telp', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|required');
        $this->form_validation->set_rules('desa', 'Desa', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nama' => form_error('nama'),
                'alamat' => form_error('alamat'),
                'no_telp' => form_error('no_telp'),
                'email' => form_error('email'),
                'provinsi' => form_error('provinsi'),
                'kabupaten' => form_error('kabupaten'),
                'kecamatan' => form_error('kecamatan'),
                'desa' => form_error('desa'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'phone' => $this->input->post('no_telp'),
                'email' => $this->input->post('email'),
                'provinsi_id' => $this->input->post('provinsi'),
                'kota_id' => $this->input->post('kabupaten'),
                'kecamatan_id' => $this->input->post('kecamatan'),
                'desa_id' => $this->input->post('desa'),
            );
            $this->M_Susunan->update($this->input->post('id'), $data);

            $kat = 'Edit data Susunan Pengurus ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|callback_nama_check');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp', 'No Telp', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|required');
        $this->form_validation->set_rules('desa', 'Desa', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
    }


    public function cek_namaedit()
    {
        $where = array(
            'nama' => $this->input->post('nama'),
            'id !=' => $this->input->post('id')
        );
        $data = $this->db->get_where('tb_susunan', $where)->row();
        if ($data) {
            $this->form_validation->set_message('cek_namaedit', 'Nama sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function pengurus($id)
    {
        $row = $this->M_Susunan->get_by_join($id)->row();
        $data = array(
            'button' => 'Simpan',
            'action' => base_url('susunan/pengurus_store'),
            'method' => 'POST',
            'modal_title' => 'Tambah Susunan Pengurus',
            'anggota' => $this->M_Anggota->get_by_status('Verifikasi', 'Aktif'),
            'level' => $this->db->get_where('tb_pengurus', ['susunan_id' => $id])->result(),
            'jabatan' => '',
            'id' => set_value('id'),
            'susunan_id' => $row->id,
            'nama' => $row->nama,
            'member_id' => set_value('member_id'),
            'pengurus_id' => set_value('pengurus_id'),
            'jabatan_id' => set_value('jabatan_id'),
            'awal_jabatan' => date('d-m-Y'),
            'akhir_jabatan' => date('d-m-Y'),
        );

        $this->load->view('susunan/pengurus.php', $data);
    }

    public function pengurus_store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('anggota', 'Anggota', 'trim|required|callback_cek_anggota');
        $this->form_validation->set_rules('level', 'Level', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required|callback_cek_jabatan');
        $this->form_validation->set_rules('awal_jabatan', 'Awal Menjabat', 'trim|required');
        $this->form_validation->set_rules('akhir_jabatan', 'Akhir Menjabat', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nama' => form_error('nama'),
                'jabatan' => form_error('jabatan'),
                'level' => form_error('level'),
                'anggota' => form_error('anggota'),
                'awal_jabatan' => form_error('awal_jabatan'),
                'akhir_jabatan' => form_error('akhir_jabatan'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {

            //susunan_id
            $data = array(
                'susunan_id' => $this->input->post('susunan_id'),
                'member_id' => $this->input->post('anggota'),
                'pengurus_id' => $this->input->post('level'),
                'jabatan_id' => $this->input->post('jabatan'),
                'awal_jabatan' => date('Y-m-d', strtotime($this->input->post('awal_jabatan'))),
                'akhir_jabatan' => date('Y-m-d', strtotime($this->input->post('akhir_jabatan'))),
                'status' => 'aktif'
            );
            $this->db->insert('list_pengurus', $data);

            $kat = 'Tambah data Susunan Pengurus ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
    }

    public function pengurus_edit($id)
    {
        $row = $this->db->get_where('list_pengurus', ['id' => $id])->row();
        $susunan = $this->M_Susunan->get_by_join($row->susunan_id)->row();
        $data = array(
            'button' => 'Update',
            'action' => base_url('susunan/pengurus_update'),
            'method' => 'POST',
            'modal_title' => 'Edit Susunan Pengurus',
            'anggota' => $this->M_Anggota->get_by_status('Verifikasi', 'Aktif'),
            'level' => $this->db->get_where('tb_pengurus', ['susunan_id' => $row->susunan_id])->result(),
            'jabatan' => $this->db->get_where('tb_jabatan', ['pengurus_id' => $row->pengurus_id])->result(),
            'id' => $row->id,
            'susunan_id' => $row->susunan_id,
            'nama' => $susunan->nama,
            'member_id' => $row->member_id,
            'pengurus_id' => $row->pengurus_id,
            'jabatan_id' => $row->jabatan_id,
            'awal_jabatan' => date('d-m-Y', strtotime($row->awal_jabatan)),
            'akhir_jabatan' => date('d-m-Y', strtotime($row->akhir_jabatan)),

        );

        $this->load->view('susunan/pengurus.php', $data);
    }

    public function pengurus_update()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('anggota', 'Anggota', 'trim|required|callback_cek_anggota_edit');
        $this->form_validation->set_rules('level', 'Level', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required|callback_cek_jabatan_edit');
        $this->form_validation->set_rules('awal_jabatan', 'Awal Menjabat', 'trim|required');
        $this->form_validation->set_rules('akhir_jabatan', 'Akhir Menjabat', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nama' => form_error('nama'),
                'jabatan' => form_error('jabatan'),
                'level' => form_error('level'),
                'anggota' => form_error('anggota'),
                'awal_jabatan' => form_error('awal_jabatan'),
                'akhir_jabatan' => form_error('akhir_jabatan'),
            );
            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $data = array(
                'member_id' => $this->input->post('anggota'),
                'pengurus_id' => $this->input->post('level'),
                'jabatan_id' => $this->input->post('jabatan'),
                'awal_jabatan' => date('Y-m-d', strtotime($this->input->post('awal_jabatan'))),
                'akhir_jabatan' => date('Y-m-d', strtotime($this->input->post('akhir_jabatan')))
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('list_pengurus', $data);

            $kat = 'Edit data Susunan Pengurus ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diubah']);
        }
    }

    public function pengurus_delete($id)
    {
        $row = $this->db->get_where('list_pengurus', array('id' => $id))->row();
        if ($row) {
            $where = array('id' => $id);
            $this->M_Setting->delete($where, 'list_pengurus');

            $kat = 'Hapus data Susunan Pengurus ' . $row->member_id;
            $this->M_Setting->addlog($kat);

            $result['success'] = 'Data Berhasil Dihapus';
            $result['icon'] = 'success';
            $result['title'] = 'Berhasil';
        } else {
            $result['error'] = 'Record Not Found';
            $result['icon'] = 'error';
            $result['title'] = 'Oops...';
        }
        echo json_encode($result);
    }



    public function cek_anggota()
    {
        $data = $this->db->get_where('list_pengurus', [
            'susunan_id' => $this->input->post('susunan_id'),
            'member_id' => $this->input->post('anggota'),
            'status' => 'aktif'
        ])->row();
        if ($data) {
            $this->form_validation->set_message('cek_anggota', 'Anggota sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function cek_jabatan()
    {
        $cek_jabatan = $this->db->get_where('tb_jabatan', ['id_jabatan' => $this->input->post('jabatan')])->row();
        $data = $this->db->get_where('list_pengurus', [
            'susunan_id' => $this->input->post('susunan_id'),
            'pengurus_id' => $this->input->post('level'),
            'jabatan_id' => $this->input->post('jabatan'),
            'status' => 'aktif'
        ])->row();
        
        if ($data && $cek_jabatan->keterangan == '1') {
            $jabatan = $this->db->get_where('tb_jabatan', ['id_jabatan' => $this->input->post('jabatan')])->row();
            $pengurus = $this->db->get_where('tb_pengurus', ['id_pengurus' => $this->input->post('level')])->row();
            $this->form_validation->set_message('cek_jabatan', 'Jabatan ' . $jabatan->jabatan . ' di Level ' . $pengurus->level . ' sudah ada. Mohon pilih jabatan lain');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function cek_jabatan_edit()
    {

        $cek_jabatan = $this->db->get_where('tb_jabatan', ['id_jabatan' => $this->input->post('jabatan')])->row();
        $data = $this->db->get_where('list_pengurus', [
            'id !=' => $this->input->post('id'),
            'susunan_id' => $this->input->post('susunan_id'),
            'pengurus_id' => $this->input->post('level'),
            'jabatan_id' => $this->input->post('jabatan'),
            'status' => 'aktif'
        ])->row();
        

        if ($data && $cek_jabatan->keterangan == '1') {
            $jabatan = $this->db->get_where('tb_jabatan', ['id_jabatan' => $this->input->post('jabatan')])->row();
            $pengurus = $this->db->get_where('tb_pengurus', ['id_pengurus' => $this->input->post('level')])->row();
            $this->form_validation->set_message('cek_jabatan_edit', 'Jabatan ' . $jabatan->jabatan . ' di Level ' . $pengurus->level . ' sudah ada. Mohon pilih jabatan lain');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function cek_anggota_edit()
    {

        $data = $this->db->get_where('list_pengurus', [
            'id !=' => $this->input->post('id'),
            'susunan_id' => $this->input->post('susunan_id'),
            'member_id' => $this->input->post('anggota'),
            'status' => 'aktif'
        ])->row();
        if ($data) {
            $this->form_validation->set_message('cek_anggota_edit', 'Anggota sudah menjabat');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function ajax($id)
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('Select list_pengurus.id, tb_pendaftaran.id as id_pendaftar, tb_pendaftaran.nik as nik, tb_pendaftaran.nama as member, tb_susunan.nama as susunan, tb_pengurus.level, tb_jabatan.jabatan, awal_jabatan, akhir_jabatan, list_pengurus.status
         from list_pengurus
            join tb_susunan on tb_susunan.id = list_pengurus.susunan_id
            join tb_pendaftaran on tb_pendaftaran.nik = list_pengurus.member_id
            join tb_pengurus on tb_pengurus.id_pengurus = list_pengurus.pengurus_id
            join tb_jabatan on tb_jabatan.id_jabatan = list_pengurus.jabatan_id
            where list_pengurus.susunan_id = '.$id.'
            order by list_pengurus.status asc'
        );
        $datatables->add('action', function ($data) {
            $html = '<a href="' . base_url('anggota/aktif/detail/' . $data['id_pendaftar']) . '" class="btn btn-success btn-xs"><i class="fa fa-search"></i> Lihat</a>&nbsp';

            $html .= '<a href="' . base_url('susunan/pengurus_edit/' . $data['id']) . '" class="btn btn-primary btn-xs ActView"><i class="fa fa-edit"></i> Edit</a>';
            $html .= ' <a href="' . base_url('susunan/pengurus_delete/' . $data['id']) . '" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i> Hapus</a>';
            return $html;
        });

        $datatables->hide('nik');
        $datatables->edit('awal_jabatan', function ($data) {
            return date('d-m-Y', strtotime($data['awal_jabatan']));
        });
        $datatables->edit('akhir_jabatan', function ($data) {
            return date('d-m-Y', strtotime($data['akhir_jabatan']));
        });
        $datatables->edit('status', function ($data) {
            if ($data['status'] == 'aktif') {
                return '<span class="badge bg-green">Aktif</span>';
            } else {
                return '<span class="badge bg-red">Tidak Aktif</label>';
            }
        });
        echo $datatables->generate();
    }

    public function itemdelete()
    {
        $ids = $this->input->post('ids');

        $this->db->where_in('id', explode(",", $ids));
        $this->db->delete('tb_susunan');
        echo json_encode(['success' => "Item Deleted successfully."]);
    }

    public function nonaktif()
    {
        $get = $this->db->get_where('list_pengurus', ['akhir_jabatan <' => date('Y-m-d'), 'status' => 'aktif'])->result();
        if ($get) {
            foreach ($get as $get) {
                $data = array(
                    'status' => 'tidak'
                );
                $this->db->where('id', $get->id);
                $this->db->update('list_pengurus', $data);
            }
        }
    }
}
