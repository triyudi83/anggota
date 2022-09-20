<?php

function Sendemail($email, $message, $subject,$judul)
{
    $ci = get_instance();
    $ci->load->library('email');
    $config = [
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'petigakita@gmail.com',
        'smtp_pass' => 'qkunousdjxjwfjta',
        'mailtype'  => 'html',
        'charset'   => 'iso-8859-1'
        // 'mailtype'  => 'html',
        // 'charset'   => 'utf-8',
        // 'protocol'  => 'smtp',
        // 'smtp_host' => 'mail.pengwiljatimini.id',
        // 'smtp_user' => 'ticket@pengwiljatimini.id',  // Email gmail
        // 'smtp_pass'   => 'Masuk*123',  // Password gmail
        // 'smtp_crypto' => 'tls',
        // 'smtp_port'   => 587,
        // 'crlf'    => "\r\n",
        // 'newline' => "\r\n"
    ];
    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from('petigakita@gmail.com',  $judul);
    $ci->email->to($email);
    //$ci->email->cc('tri.yudi.eryanto@gmail.com');
    //$ci->email->bcc('tri.yudi.eryanto@gmail.com');
    $ci->email->subject($subject);
    $ci->email->message($message);
    if ($ci->email->send()) {
        return true;
    } else {
        echo $ci->email->print_debugger();
    }
}

function attachment($email, $message, $subject, $attachment)
{
    $ci = get_instance();
    $ci->load->library('email');
    $config = [
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'protocol'  => 'smtp',
        'smtp_host' => 'mail.pengwiljatimini.id',
        'smtp_user' => 'ticket@pengwiljatimini.id',  // Email gmail
        'smtp_pass'   => 'Masuk*123',  // Password gmail
        'smtp_crypto' => 'tls',
        'smtp_port'   => 587,
        'crlf'    => "\r\n",
        'newline' => "\r\n"
    ];
    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from('ticket@pengwiljatimini.id', 'TICKET PENGWILJATIM');
    $ci->email->to($email);
    $ci->email->subject($subject);
    $ci->email->message($message);
    $ci->email->attach(base_url($attachment));
    if ($ci->email->send()) {
        return true;
    } else {
        echo $ci->email->print_debugger();
    }
}
