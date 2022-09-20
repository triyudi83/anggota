<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Anggota extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Anggota');
        $this->load->model('M_Setting');
        $this->load->library('upload');

        // Check login
        if (!$this->session->userdata('id')) {
            redirect('auth');
        }
    }

    public function status($status)
    {
        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Keanggotaan';

        if ($status == 'register') {
            $data['activeMenu'] = 'Calon Anggota';
            $data['register'] = $this->M_Anggota->get_by_status('Baru', 'Aktif');
        } else if ($status == 'aktif') {
            $data['activeMenu'] = 'Anggota Aktif';
            $data['register'] = $this->M_Anggota->get_by_status('Verifikasi', 'Aktif');
        } else if ($status == 'tidakaktif') {
            $data['activeMenu'] = 'Anggota Tidak Aktif';
            $data['register'] = $this->M_Anggota->get_by_status('Verifikasi', 'Tidak');
        } else if ($status == 'kta') {
            $data['activeMenu'] = 'Upload KTA';
            $data['register'] = $this->M_Anggota->get_by_status('Verifikasi', 'Aktif');
        } else {
            $data['activeMenu'] = 'Anggota';
        }

        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('anggota/' . $status . '.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function detail($detail)
    {
        $url = $this->uri->segment(2);

        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Keanggotaan';
        if ($url == 'register') {
            $data['activeMenu'] = 'Calon Anggota';
            $data['title'] = 'Detail Registrasi Anggota DPC';
            $data['button'] = '
                <a href=' . base_url('anggota/register') . ' class="btn btn-warning">Kembali</a>
                <a href="' . base_url('anggota/verifikasi/' . $detail) . '" class="btn btn-success verifikasi">Verifikasi Pendaftaran</a>
            ';
        } else if ($url == 'aktif') {
            $data['activeMenu'] = 'Anggota Aktif';
            $data['title'] = 'Detail Anggota DPC Aktif';
            $data['button'] = '
                <a href=' . base_url('anggota/aktif') . ' class="btn btn-warning">Kembali</a>
            ';
        } else if ($url == 'tidakaktif') {
            $data['activeMenu'] = 'Anggota Tidak Aktif';
            $data['title'] = 'Detail Anggota DPC Tidak Aktif';
            $data['button'] = '
            <a href=' . base_url('anggota/tidakaktif') . ' class="btn btn-warning">Kembali</a>
        ';
        } else if ($url == 'kta') {
            $data['activeMenu'] = 'Upload KTA';
            $data['title'] = 'Detail Upload KTA';
            $data['button'] = '
            <a href=' . base_url('anggota/kta') . ' class="btn btn-warning">Kembali</a>
        ';
        }
        $data['anggota'] = $this->M_Anggota->get_by_id($detail);
        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('anggota/detail.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function create_aktif()
    {
        $id = $this->session->userdata('role_user');
        $data['menu'] = $this->M_Setting->getmenu($id);
        $data['submenu'] = $this->M_Setting->getsubmenu($id);
        $data['katMenu'] = 'Keanggotaan';
        $data['activeMenu'] = 'Anggota Aktif';
        $data['title'] = 'Detail Anggota DPC Aktif';
        $data['provinsi'] = $this->db->get('tb_provinsi')->result();

        $this->load->view('template/header.php', $data);
        $this->load->view('template/sidebar.php', $data);
        $this->load->view('anggota/create.php', $data);
        $this->load->view('template/footer.php', $data);
    }

    public function verifikasi($id)
    {
        $anggota = $this->M_Anggota->get_by_id($id);
        if ($anggota->status == 'Baru') {
            $params = array(
                'created_at' => $anggota->created_at,
                'status' => 'Verifikasi',
                'update_at' => date('Y-m-d h:i:s')
            );
            $this->M_Anggota->update($id, $params);

            $kat = 'Verifikasi Anggota DPC PPP ' . $anggota->nama;
            $this->M_Setting->addlog($kat);

            $this->email($anggota->email);



            $this->session->set_flashdata('flash', '
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                Data Berhasil di Verifikasi
                </div>      
            ');
        } else {
            $this->session->set_flashdata('flash', '
                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-ban"></i> Gagal!</h5>
                Data Sudah di Verifikasi
                </div>      
            ');
        }
        redirect('anggota/register');
    }

    public function edit($id)
    {
        $url = $this->uri->segment(2);
        $query = $this->M_Anggota->get_keterangan($id, $url);
        if ($query) {
            $id = $this->session->userdata('role_user');
            $data['menu'] = $this->M_Setting->getmenu($id);
            $data['submenu'] = $this->M_Setting->getsubmenu($id);
            $data['katMenu'] = 'Keanggotaan';
            if ($url == 'aktif') {
                $data['activeMenu'] = 'Anggota Aktif';
                $data['title'] = 'Edit Anggota DPC Aktif';
            } else if ($url == 'tidakaktif') {
                $data['activeMenu'] = 'Anggota Tidak Aktif';
                $data['title'] = 'Edit Anggota DPC Tidak Aktif';
            }
            $data['anggota'] = $query;
            $this->load->view('template/header.php', $data);
            $this->load->view('template/sidebar.php', $data);
            $this->load->view('anggota/edit_anggota.php', $data);
            $this->load->view('template/footer.php', $data);
        } else {
            show_404();
        }
    }
    public function update()
    {
        //upload all image
        $this->_rules('update');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nik' => form_error('nik'),
                'nama' => form_error('nama'),
                'bagian' => form_error('bagian'),
                'status_anggota' => form_error('status_anggota'),

            );

            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $id = $this->input->post('id');
            $data = $this->M_Anggota->get_by_id($id);

            $config['upload_path'] = './assets/ktp/';
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['max_size'] = '2048';
            $config['file_name'] = 'anggota_' . time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')) {
                $upload_foto = $this->upload->data('file_name');
                $foto = 'assets/ktp/' . $upload_foto;
            } else {
                $foto = $data->foto;
            }

            
            $params = array(
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'bagian' => $this->input->post('bagian'),
                'foto' => $foto,
                'status_anggota' => $this->input->post('status_anggota'),
                'keterangan' => $this->input->post('keterangan'),
                'tgl_nonaktif' => date('Y-m-d', strtotime($this->input->post('tgl_nonaktif')))
            );
            $this->M_Anggota->update($id, $params);

            $kat = 'Edit Data Anggota ' . $this->input->post('nama');
            $this->M_Setting->addlog($kat);

            echo json_encode(['status' => 'success', 'message' => 'Data Berhasil di Update']);
        }
    }

    public function store()
    {
        //echo json_encode($_POST);
        $this->_rules('store');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'nik' => form_error('nik'),
                'nama' => form_error('nama'),
                'bagian' => form_error('bagian'),
                'status_anggota' => form_error('status_anggota'),
            );

            echo json_encode(['status' => 'error', 'message' => $result]);
        } else {
            $config['upload_path'] = './assets/ktp/';
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['max_size'] = '2048';
            $config['file_name'] = 'anggota_' . time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $upload_foto = $this->upload->data('file_name');
                $foto = 'assets/ktp/' . $upload_foto;
            } else {
                $foto = '';
            }
            $params = array(
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'bagian' => $this->input->post('bagian'),
                'status_anggota' => $this->input->post('status_anggota'),
                'tgl_nonaktif' => date('Y-m-d', strtotime($this->input->post('tgl_nonaktif'))),
                'foto' => $foto,
                'keterangan' => $this->input->post('keterangan'),
                'update_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->db->insert('tb_pendaftaran', $params);
            if ($insert) {
                $kat = 'Tambah Data Anggota ' . $this->input->post('nama');
                $this->M_Setting->addlog($kat);
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal ditambahkan']);
            }
        }
    }

    public function delete($id)
    {
        $data = $this->M_Anggota->get_by_id($id);
        if ($data) {
            $this->db->where('id', $id);
            $this->db->delete('tb_pendaftaran');

            $kat = 'Hapus Data Anggota ' . $data->nama;
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

    private function email($email)
    {
        error_reporting(0);
        $config = array(
            'mail_from_mail' => 'petigakita@gmail.com',
            'mail_from_name' => 'DPC PPP Situbondo',
            'mail_bcc' => 'my_email@example.com',
            'mail_setBcc' => true
        );
        $data = array(
            "NAME"       => 'DPC PPP Situbondo',
        );

        $template_html = 'sample-1.html';

        $mail = new Mail($config);
        $mail->AddEmbeddedImage('assets/ktp/Logo.png', 'logo', 'Logo.png');
        $mail->IsHTML(true);
        $mail->setMailBody($data, $template_html);
        return $mail->sendMail('VERIFIKASI PENDAFTARAN ANGGOTA', $email);
    }

    public function itemdelete()
    {
        $ids = $this->input->post('ids');

        $this->db->where_in('id', explode(",", $ids));
        $this->db->delete('tb_pendaftaran');

        echo json_encode(['success' => "Item Deleted successfully."]);
    }

    public function uploadkta($id)
    {
        $data['actions'] = 'add';
        $data['action'] = site_url('Anggota/upload_kta');
        $data['modal_title'] = 'Upload KTA';
        $data['formID'] = 'formEdit';
        $data['button'] = 'Simpan';
        $data['anggota'] = $this->M_Anggota->get_by_id($id);

        $this->load->view('anggota/upload', $data);
    }

    public function upload_kta()
    {
        $data = $this->db->get_where('tb_pendaftaran', array('nik' => $this->input->post('kd_gambar')))->row();
        $config['upload_path'] = './assets/ktp/'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->upload->initialize($config);
        if (!empty($_FILES['filefoto']['name'])) {

            if ($this->upload->do_upload('filefoto')) {

                $gbr = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/ktp/' . $gbr['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['new_image'] = './assets/ktp/' . $gbr['file_name'];
                // $this->load->library('image_lib', $config);
                // $this->image_lib->resize();


                $gambar = 'assets/ktp/' . $gbr['file_name'];
                $id = $this->input->post('kd_gambar');

                $this->db->where('nik', $id);
                $this->db->update('tb_pendaftaran', array('kta' => $gambar));

                $kat = 'Upload KTA ' . $data->nama;
                $this->M_Setting->addlog($kat);


                echo json_encode(['status' => 'success', 'message' => 'KTA Berhasil di upload']);
                // echo "gagalfoto" . $this->upload->display_errors();
            } else {
                echo "gagalfoto" . $this->upload->display_errors();

                echo json_encode(['status' => 'error', 'message' => 'KTA Gagal Ditambahkan']);

                // redirect('login');
            }
        } else {
            echo "gagalfoto" . $this->upload->display_errors();
            echo $this->session->set_flashdata('msg', 'warning');
            redirect('anggota/kta');

            // redirect('login');
        }
    }

    public function nik_check()
    {
        $nik = $this->input->post('nik');
        $cek = $this->db->get_where('tb_pendaftaran', array('nik' => $nik, 'status_anggota' => 'aktif'))->row();
        if ($cek) {
            $this->form_validation->set_message('nik_check', 'NIK sudah terdaftar');
            return false;
        } else {
            return true;
        }
    }

    public function nik_check_update()
    {
        $nik = $this->input->post('nik');
        $id = $this->input->post('id');
        $cek = $this->db->get_where('tb_pendaftaran', array('nik' => $nik, 'status_anggota' => 'aktif', 'id !=' => $id))->row();
        if ($cek) {
            $this->form_validation->set_message('nik_check_update', 'NIK sudah terdaftar');
            return false;
        } else {
            return true;
        }
    }

    public function _rules($status)
    {
        if ($status == 'store') {
            $this->form_validation->set_rules('nik', 'Nik', 'trim|required|callback_nik_check');
        }
        if ($status == 'update') {
            $this->form_validation->set_rules('nik', 'Nik', 'trim|required|callback_nik_check_update');
        }
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('bagian', 'Bagian', 'trim|required');
        $this->form_validation->set_rules('status_anggota', 'Status Anggota', 'trim|required');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function export($export)
    {
        $kecamatan = $this->input->post('kecamatan');
        if ($export == 'aktif') {
            $ex = 'Aktif';
        } else {
            $ex = 'Tidak Aktif';
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $sheet->setCellValue('A1', 'Data Anggota ' . $ex);
        $sheet->mergeCells('A1:W1');
        $sheet->getStyle('A1')->getFont()->setBold(TRUE);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'NIK');
        $sheet->setCellValue('C3', 'Nama');
        $sheet->setCellValue('D3', 'Tempat, Tanggal Lahir');
        $sheet->setCellValue('E3', 'Jenis Kelamin');
        $sheet->setCellValue('F3', 'Provinsi');
        $sheet->setCellValue('G3', 'Kabupaten');
        $sheet->setCellValue('H3', 'Kecamatan');
        $sheet->setCellValue('I3', 'Desa');
        $sheet->setCellValue('J3', 'Alamat');
        $sheet->setCellValue('K3', 'RT');
        $sheet->setCellValue('L3', 'RW');
        $sheet->setCellValue('M3', 'Pernikahan');
        $sheet->setCellValue('N3', 'Hobby');
        $sheet->setCellValue('O3', 'No HP');
        $sheet->setCellValue('P3', 'Email');
        $sheet->setCellValue('Q3', 'Facebook');
        $sheet->setCellValue('R3', 'Instagram');
        $sheet->setCellValue('S3', 'Keahlian');
        $sheet->setCellValue('T3', 'Pekerjaan');
        $sheet->setCellValue('U3', 'Organisasi');
        $sheet->setCellValue('V3', 'Status Anggota');
        $sheet->setCellValue('W3', 'Tanggal Daftar');


        $sheet->getStyle('A3:W3')->applyFromArray($style_col);

        if ($kecamatan == '') {
            $where = array('status' => 'verifikasi', 'status_anggota' => $ex);
            $anggota = $this->M_Anggota->get_export($where);
        } else {
            $where = array('status' => 'Verifikasi', 'status_anggota' => $ex, 'tb_pendaftaran.id_kecamatan' => $kecamatan);
            $anggota = $this->M_Anggota->get_export($where);
        }


        $no = 1;
        $numrow = 4;

        foreach ($anggota as $item) {
            $sheet->setCellValue('A' . $numrow, $no++);
            //set type data
            $sheet->setCellValueExplicit('B' . $numrow, $item->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $numrow, $item->nama);
            $sheet->setCellValue('D' . $numrow, $item->tempatlahir . ', ' . date('d-m-Y', strtotime($item->tanggallahir)));
            $sheet->setCellValue('E' . $numrow, $item->jk);
            $sheet->setCellValue('F' . $numrow, $item->name_prov);
            $sheet->setCellValue('G' . $numrow, $item->name_kota);
            $sheet->setCellValue('H' . $numrow, $item->kecamatan);
            $sheet->setCellValue('I' . $numrow, $item->kelurahan);
            $sheet->setCellValue('J' . $numrow, $item->alamat);
            $sheet->setCellValue('K' . $numrow, $item->rt);
            $sheet->setCellValue('L' . $numrow, $item->rw);
            $sheet->setCellValue('M' . $numrow, $item->pernikahan);
            $sheet->setCellValue('N' . $numrow, $item->hobby);
            $sheet->setCellValue('O' . $numrow, $item->hp);
            $sheet->setCellValue('P' . $numrow, $item->email);
            $sheet->setCellValue('Q' . $numrow, $item->facebook);
            $sheet->setCellValue('R' . $numrow, $item->instagram);
            $sheet->setCellValue('S' . $numrow, $item->keahlian);
            $sheet->getStyle('S' . $numrow)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('T' . $numrow, $item->kerja);
            $sheet->getStyle('T' . $numrow)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('U' . $numrow, $item->organisasi);
            $sheet->getStyle('U' . $numrow)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('V' . $numrow, $item->status_anggota);
            $sheet->setCellValue('W' . $numrow, date('d-m-Y', strtotime($item->created_at)));


            $sheet->getStyle('A' . $numrow . ':W' . $numrow)->applyFromArray($style_row);


            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);
            $sheet->getColumnDimension('M')->setAutoSize(true);
            $sheet->getColumnDimension('N')->setAutoSize(true);
            $sheet->getColumnDimension('O')->setAutoSize(true);
            $sheet->getColumnDimension('P')->setAutoSize(true);
            $sheet->getColumnDimension('Q')->setAutoSize(true);
            $sheet->getColumnDimension('R')->setAutoSize(true);
            $sheet->getColumnDimension('S')->setAutoSize(true);
            $sheet->getColumnDimension('T')->setAutoSize(true);
            $sheet->getColumnDimension('U')->setAutoSize(true);
            $sheet->getColumnDimension('V')->setAutoSize(true);
            $sheet->getColumnDimension('W')->setAutoSize(true);

            $numrow++;
        }

        $sheet->setTitle("Laporan Data Anggota " . $ex);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Anggota.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function coba_email()
    {
        $data = '<h2>Sample Basic</h2>
        <hr>
        <p>This is a simple basic mail message in <strong>HTML</strong> string format</p>
        <p>Lorem ipsum dolor sit amharum<br /> quod deserunt id dolores.</p>';

        $mail = new Mail();
        $mail->setMailBody($data);
        $mail->sendMail('Awesome Subject', 'tri.yudi.eryanto@gmail.com');
    }
}
