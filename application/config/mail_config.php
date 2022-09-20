<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Mailer Configuration
$config['mail_mailer']          = 'PHPMailer';
$config['mail_debug']           = 0; // default: 0, debugging: 2, 'local'
$config['mail_debug_output']    = 'html';
$config['mail_smtp_auth']       = true;
$config['mail_smtp_secure']     = ''; // default: '' | tls | ssl |
$config['mail_charset']         = 'utf-8';

// Templates Path and optional config
$config['mail_template_folder'] = 'template';
$config['mail_template_options'] = array(
                                       'SITE_NAME' => 'DPC PPP Situbondo',
                                       'SITE_LOGO' => 'assets/ktp/Logo.jpg',
                                       'BASE_URL'  => base_url(),
                                    );
// Server Configuration
$config['mail_smtp']            = 'ssl://smtp.googlemail.com';
$config['mail_port']            = 465; // for gmail default 587 with tls
$config['mail_user']            = 'petigakita@gmail.com';
$config['mail_pass']            = 'qkunousdjxjwfjta';

// Mailer config Sender/Receiver Addresses
$config['mail_admin_mail']      = 'someone@example.com';
$config['mail_admin_name']      = 'WebMaster';

$config['mail_from_mail']       = 'someone@example.com';
$config['mail_from_name']       = 'Site Name';

$config['mail_replyto_mail']    = 'someone@example.com';
$config['mail_replyto_name']    = 'Reply to Name';

// BCC and CC Email Addresses
$config['mail_bcc']             = 'hosterwebid@gmail.com';
$config['mail_cc']              = 'hosterwebid@gmail.com';

// BCC and CC enable config, default disabled;
$config['mail_setBcc']          = true;
$config['mail_setCc']           = true;


/* End of file mail_config.php */
/* Location: ./application/config/mail_config.php */