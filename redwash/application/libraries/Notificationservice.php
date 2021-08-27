<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
  /**
  * Ignited Datatables
  *
  * This is a wrapper class/library based on the native Datatables server-side implementation by Allan Jardine
  * found at http://datatables.net/examples/data_sources/server_side.html for CodeIgniter
  *
  * @package    CodeIgniter
  * @subpackage libraries
  * @category   library
  * @version    2.0 <beta>
  * @author     Vincent Bambico <metal.conspiracy@gmail.com>
  *             Yusuf Ozdemir <yusuf@ozdemir.be>
  * @link       http://ellislab.com/forums/viewthread/160896/
  */
  class Notificationservice
  {
    private $CI;

    function __construct()
    {
        // Assign by reference with "&" so we don't create a copy
        $this->CI = &get_instance();
    }

    function send_email($message)
    {
        
        $this->CI->email->from($_ENV['SENDGRID_EMAIL'], 'RedWash');
        $this->CI->email->to($message['to_email']);
        $this->CI->email->subject($message['subject']);
        $this->CI->email->message($this->CI->load->view("email/{$message['html_content']}", $message['data_content'], true));

        if ($this->CI->email->send()) {
            return TRUE;
        } else {
            show_error($this->CI->email->print_debugger());
        }
        
    }
  }
