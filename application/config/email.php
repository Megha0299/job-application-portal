<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Email Configuration
| -------------------------------------------------------------------
| By default on local XAMPP without live SMTP credentials, 
| 'mail' or 'sendmail' will simulate dispatch.
| To test live inbox delivery, insert your Gmail/SendGrid SMTP credentials below.
*/

$config['protocol']     = 'smtp';
$config['smtp_host']    = 'smtp.gmail.com';
$config['smtp_port']    = 587;
$config['smtp_user']    = 'your_company_email@gmail.com';  // Change to your email
$config['smtp_pass']    = 'your_16_digit_app_password';    // Google App Password (not standard account password)
$config['smtp_crypto']  = 'tls';
$config['mailtype']     = 'html';
$config['charset']      = 'utf-8';
$config['newline']      = "\r\n";
$config['crlf']         = "\r\n";
$config['wordwrap']     = TRUE;
$config['smtp_timeout'] = 10;