<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model & library
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('M_Setting');
        $this->load->model('Upload_model');
        $this->load->model('M_User');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('Login');
        }
    }

    public function index()
    {
        // Get setting
        $data['setting_data'] = $this->db->get('tb_setting')->row_array();

        // Set required data
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Setting';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);

        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('setting/v_setting', $data);
        $this->load->view('template/footer');
    }
    function backup()
    {
        date_default_timezone_set("Asia/Jakarta"); // set waktu sesuai lokasi

        $this->load->dbutil();
        $pref = [
            'format' => 'zip',
            'filename' => 'DPCPPP' . date("d-m-Y__H-i-s") . '.sql'
        ];

        $backup     = $this->dbutil->backup($pref);
        $db_name    = 'backup_database__' . date("d-m-Y__H-i-s") . '.zip'; // nama backup dalam bentuk zip
        $save       = './database/backup/' . $db_name; //folder tempat database disimpan

        $this->load->helper('file'); // load helper file
        write_file($save, $backup);

        $this->load->helper("download"); // load helper download
        force_download($db_name, $backup);
        redirect('welcome');
    }

    public function update_setting()
    {
        // Get setting
        $setting = $this->db->get('tb_setting')->row_array();

        // Update data
        $data = [
            'navbar'        => $_POST['navbar'],
            'alamat'        => $_POST['alamat'],
            'tlp'           => $_POST['tlp'],
            'email'         => $_POST['email'],
            'faks'          => $_POST['faks'],
            'facebook'      => $_POST['facebook'],
            'twitter'       => $_POST['twitter'],
            'instagram'     => $_POST['instagram'],
            'youtube'       => $_POST['youtube'],
        ];

        // Upload logo
        if ($_FILES['logo']['error'] == 0) {
            // Hapus logo lama
            if ($setting['logoperusahaan'] != 'default.png') {
                unlink('./storage/logo/' . $setting['logoperusahaan']);
            }
            $data['logoperusahaan'] = $this->Upload_model->upload('logo', './storage/logo/', 'LOGO_', 'logo', 10240);
        }

        // Update data
        $update = $this->db->update('tb_setting', $data);

        // Check
        if ($update) {
            $this->session->set_flashdata('status', '
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success !</strong> Perubahan setting telah disimpan
                </div>
            ');
            redirect('setting');
        }
    }

    public function akses()
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Hak Akses';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);

        $data['user'] = $this->M_User->allakses();
        $data['all'] = $this->db->get_where('users', array('password' => ''))->result_array();
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('setting/v_akses.php', $data);
        $this->load->view('template/footer.php');
    }


    function view($ida)
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Hak Akses';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $akses['akses'] = $this->M_Setting->getakses($ida);
        $akses['key'] = $this->db->get_where('users', array('id' => $ida))->row_array();
        $this->load->view('setting/v_vakses', $akses);
        $this->load->view('template/footer');
    }

    function password()
    {
        $id = $this->session->userdata('role_user');
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'Rubah Password';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $akses['key'] = $this->db->get_where('users', array('id' => $this->session->userdata('id')))->row_array();
        $this->load->view('setting/v_password', $akses);
        $this->load->view('template/footer');
    }

    public function gantipassword()
    {

        $params = array(
            'password' => md5($this->input->post('password'))
        );
        $id_user = $this->input->post('id');
        $this->M_User->update_user($id_user, $params);
        $kat = 'Edit Password user dengan id ' . $this->input->post('id');
        $this->M_Setting->addlog($kat);
        $this->session->set_flashdata('alert', '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                Password Berhasil Di Rubah.
                </div>      
                ');
        redirect('password');
    }

    public function edit()
    {
        if (isset($_POST['save'])) {

            $iduser = $this->input->post('id');
            $this->M_Setting->refresh($iduser); //Call the modal

            $submenu = $this->input->post('submenu'); //Pass the userid here
            $checkbox = $this->input->post('view');
            for ($i = 0; $i < count($checkbox); $i++) {
                $sub = $submenu[$i];
                $view = $checkbox[$i];
                $this->M_Setting->editv($iduser, $sub, $view); //Call the modal

            }

            $addbox = $this->input->post('add');
            for ($i = 0; $i < count($addbox); $i++) {
                $sub = $submenu[$i];
                $add = $addbox[$i];
                $this->M_Setting->edita($iduser, $sub, $add); //Call the modal

            }

            $editbox = $this->input->post('edit');
            for ($i = 0; $i < count($editbox); $i++) {
                $sub = $submenu[$i];
                $edit = $editbox[$i];
                $this->M_Setting->edite($iduser, $sub, $edit); //Call the modal

            }

            $deletebox = $this->input->post('delete');
            for ($i = 0; $i < count($deletebox); $i++) {
                $sub = $submenu[$i];
                $delete = $deletebox[$i];
                $this->M_Setting->editd($iduser, $sub, $delete); //Call the modal

            }
            $this->session->set_flashdata('SUCCESS', "Record Added Successfully!!");
            redirect('hakakses');
        }
    }

    public function log()
    {
        // Get data log
        $data['log'] = $this->M_Setting->get_log_aktivitas_all();

        // Set required data
        $id = 1;
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'User Log';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('setting/v_log', $data);
        $this->load->view('template/footer');
    }

    public function aktivitas()
    {
        // Get data log
        $data['log'] = $this->M_Setting->get_log_aktivitas_all();

        // Set required data
        $id = 1;
        $data['katMenu'] = 'Setting';
        $data['activeMenu'] = 'User Log';
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('setting/v_log', $data);
        $this->load->view('template/footer');
    }

    public function get_level()
    {
        $kota = $this->db->get_where('tb_pengurus', ['susunan_id' => $this->input->post('susunan_id')])->result();
        $lists = "<option value='' data-level=''>Pilih Level Kepengurusan</option>";
        foreach ($kota as $data) {
            $lists .= "<option value='" . $data->id_pengurus . "' data-level='" . $data->level . "'>" . $data->level . "</option>";
        }
        $callback = array('list' => $lists);
        echo json_encode($callback);
    }

    public function get_jabatan()
    {
        $kota = $this->db->get_where('tb_jabatan', ['pengurus_id' => $this->input->post('pengurus_id')])->result();
        $lists = "<option value='' data-jabatan=''>Pilih Jabatan</option>";
        foreach ($kota as $data) {
            $lists .= "<option value='" . $data->id_jabatan . "' data-jabatan='" . $data->jabatan . "'>" . $data->jabatan . "</option>";
        }
        $callback = array('list' => $lists);
        echo json_encode($callback);
    }
}
