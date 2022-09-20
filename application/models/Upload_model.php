<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upload_model extends CI_Model
{

    public function upload($inputfile, $path, $prefix = 'IMG_', $alias, $max_size = 5120)
    {
        // Set config
        $config['upload_path']          = $path;
        $config['allowed_types']        = 'jpeg|jpg|png|gif|pdf|zip|rar|doc|docx|xls|xlsx|ppt|pptx|';
        $config['file_name']            = strtoupper(uniqid($prefix));
        $config['overwrite']            = false;
        $config['max_size']             = $max_size;

        // Proses upload
        $this->load->library('upload', $config, $alias);
        $this->$alias->initialize($config);

        // If Success
        if ($this->$alias->do_upload($inputfile)) {
            $uploaddata = $this->$alias->data();
            return $uploaddata['file_name'];
        }

        // If Failed
        return null;
    }

    public function put_content($base64_image, $prefix, $path)
    {
        // Decode Data
        list($type, $base64_image) = explode(';', $base64_image);
        list(, $base64_image) = explode(',', $base64_image);
        $imgData = base64_decode($base64_image);
        // Get file format
        $type = explode('/', $type);
        $type = '.' . $type[1];
        // Upload Data
        $imageName = strtoupper(uniqid($prefix)) . $type;
        $imagePath = $path . $imageName;
        file_put_contents($imagePath, $imgData);


        return $imageName;
    }
}

/* End of file Upload_model.php */
