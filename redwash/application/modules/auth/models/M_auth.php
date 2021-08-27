<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model{

  //Input data registrasi
  public function insertReg($table, $user_data) {
    $this->db->insert($table, $user_data);
  }

  //Input data token yang dibuat untuk aktivasi/forgetpassword
  public function insertTkn($table, $users_token) {
    $this->db->insert($table, $users_token);
  }

  //Ambil data dari login
  public function getUserlogin($table, $where) {
    return $this->db->get_where($table, $where)->row_array();
  }

  //Ambil data dari email
  public function getUser($table, $email)
  {
    return $this->db->get_where($table, ['user_email' => $email])->row_array();
  }

  //Ambil data token
  public function getToken($table, $token)
  {
    return $this->db->get_where($table, ['user_token' => $token])->row_array();
  }
}