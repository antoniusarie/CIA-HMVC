<?php defined('BASEPATH') OR exit('No direct script access allowed');

//MAIL CONFIG
$config['protocol']         = 'smtp';
$config['smtp_host']        = 'ssl://smtp.gmail.com';
$config['smtp_port']        = 465;
$config['smtp_username']    = "your_email@gmail.com";
$config['smtp_password']    = "your_password";
$config['smtp_timeout']     = 5;
$config['wordwrap']         = TRUE;
$config['wrapchars']        = 250;
$config['mailtype']         = 'html';
$config['charset']          = 'utf-8';
$config['validate']         = FALSE;
$config['priority']         = 3;
$config['crlf']             = "\r\n";
$config['newline']          = "\r\n";
$config['bcc_batch_mode']   = FALSE;
$config['bcc_batch_size']   = 200;
