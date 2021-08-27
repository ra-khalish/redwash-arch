<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
    public function index()
    {
        if($this->session->userdata('status') == 'admin'){
            redirect('admin');
          }else if($this->session->userdata('status') == 'user'){
            redirect('user/queue');
          }
          
        $this->load->view('templates/home_header');
        $this->load->view('v_home');
        $this->load->view('templates/home_footer');
    }

}