<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model{
    
    public function getUser($table, $email)
    {
        return $this->db->get_where($table, ['user_email' => $email])->row_array();

    }
}