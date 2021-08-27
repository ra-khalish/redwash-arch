<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $config = array(
//     'protocol' => 'smtp',
//     'smtp_host' => 'ssl://smtp.googlemail.com',
//     'smtp_port' => 465,
//     'smtp_user' => $_ENV['AUTH_EMAIL'],
//     'smtp_pass' => $_ENV['AUTH_PASSWORD'],
//     'mailtype' => 'html',
//     'smtp_timeout' => '5',
//     'charset' => 'iso-8859-1',
//     'wordwrap' => TRUE,
//     'newline' => "\r\n"
// );

$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.sendgrid.net',
    'smtp_port' => 587,
    'smtp_user' => 'apikey',
    'smtp_pass' => $_ENV['SEND_GRID_API_KEY'],
    'mailtype' => 'html',
    'smtp_timeout' => '5',
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE,
    'crlf' => "\r\n",
    'newline' => "\r\n"
);

// $config = array(
//     'protocol' => 'smtp',
//     'smtp_host' => 'ssl://smtp.flockmail.com',
//     'smtp_port' => 465,
//     'smtp_user' => $_ENV['FLOCK_EMAIL'],
//     'smtp_pass' => $_ENV['FLOCK_PASS'],
//     'mailtype' => 'html',
//     'smtp_timeout' => '7',
//     'charset' => 'iso-8859-1',
//     'wordwrap' => TRUE,
//     'crlf' => "\r\n",
//     'newline' => "\r\n"
// );