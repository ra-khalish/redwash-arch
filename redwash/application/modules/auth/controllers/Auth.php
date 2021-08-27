<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{
  public function __construct()
    {
        parent::__construct();
        $this->load->model('m_auth');
        $this->load->library('Notificationservice');
    }

    public function load_view($main_view, $data)
    {
        $this->load->view('templates/auth_header',$data);
        $this->load->view("{$main_view}");
        $this->load->view('templates/auth_footer');
    }

    //Login
    public function index()
    {
      if($this->session->userdata('status') == 'admin'){
        redirect('admin');
      }else if($this->session->userdata('status') == 'user'){
        redirect('user/queue');
      }
      $rules = array(
        array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|trim'
        ),
        array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim'
        )
      );
      $this->form_validation->set_error_delimiters('<small class="text-danger pl-3">','</small>');
      $this->form_validation->set_rules($rules);
      if($this->form_validation->run() == false){
        $data['title'] = 'Login Page';
        $this->load_view('v_login', $data);
      } else {
        $this->_login(); //Mengarah ke fungsi login
      }
    }

    private function _login()
    {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $where = "user_email='$username' OR user_username='$username'";

      $user = $this->m_auth->getUserlogin('users', $where);

      //Jika user ada
      if($user){
        //Jika usernya aktif
        if($user['user_is_active'] == 1){
          //Cek password
          if(password_verify($password, $user['user_password'])){
            $data = [
              'id' => $user['user_id'],
              'username' => $user['user_username'],
              'name' => $user['user_name'],
              'email' => $user['user_email'],
              'role_id' => $user['user_role_id']
            ];
            if ($user['user_role_id'] == 1) {
              $data['status'] = 'admin';
              $this->session->set_userdata($data);
              $this->session->set_flashdata('alert',success("<strong>Login Successfully</strong>"));
              redirect('admin');
            }else if($user['user_role_id'] == 3) {
              $data['status'] = 'admin';
              $this->session->set_userdata($data);
              $this->session->set_flashdata('alert',success("<strong>Login Successfully</strong>"));
              redirect('admin');
            }else if($user['user_role_id'] == 2) {
              $data['status'] = 'user';
              $this->session->set_userdata($data);
              $this->session->set_flashdata('alert',success("<strong>Login Successfully</strong>"));
              redirect('user/queue');
            }
          }else{
            $this->session->set_flashdata('alert',error('Email/Username and Password is not correct!'));
            redirect('login');
          }
        }else{
          $this->session->set_flashdata('alert',error('This Email/Username has not been activated! Please check your email.'));
          redirect('login');
        }
      }else{
        $this->session->set_flashdata('alert',error('Email/Username is not registered! Please register.'));
        redirect('login');
      }
    }

    //Registrasi
    public function registration()
    {
      if($this->session->userdata('status') == 'admin'){
        redirect('admin');
      }else if($this->session->userdata('status') == 'user'){
        redirect('user/queue');
      }

      $rules = array(
        array(
          'field' => 'username',
          'label' => 'Username',
          'rules' => 'required|trim|is_unique[users.user_username]'
        ),
        array(
          'field' => 'name',
          'label' => 'Full Name',
          'rules' => 'required|trim'
        ),
        array(
          'field' => 'email',
          'label' => 'Email',
          'rules' => 'required|trim|valid_email|is_unique[users.user_email]',
          'errors' => array(
            'is_unique' => 'This email has already registered!'
          ),
        ),
        array(
          'field' => 'contact',
          'label' => 'Contact Number',
          'rules' => 'required|trim|is_unique[users.user_contact]',
          'errors' => array(
            'is_unique' => 'This contact number has already was taken!'
          ),
        ),
        array(
          'field' => 'password1',
          'label' => 'Password',
          'rules' => 'required|trim|min_length[8]|matches[password2]',
          'errors' => array(
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
          ),
        ),
        array(
          'field' => 'password2',
          'label' => 'Password',
          'rules' => 'required|trim|matches[password1]'
        )
      );
      $this->form_validation->set_error_delimiters('<small class="text-danger pl-3">','</small>');
      $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == false){
            $data['title'] = 'RedWash Registration';
            $this->load_view('v_registration', $data);
        }else {
            $email = htmlspecialchars($this->input->post('email',true));
            $user_data = [
                'user_name' => htmlspecialchars($this->input->post('name',true)),
                'user_username' => htmlspecialchars($this->input->post('username',true)),
                'user_email' => htmlspecialchars($email),
                'user_contact' => htmlspecialchars($this->input->post('contact',true)),
                'user_password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
                'user_role_id' => 2,
                'user_is_active' => 0,
                'user_ctime' => date("Y-m-d")
            ];

            //Membuat token
            $token = base64_encode(random_bytes(32));
            $users_token = [
              'user_email' => $email,
              'user_token' => $token,
              'user_cdate' => time()
            ];
            $this->m_auth->insertReg('users',$user_data); //Memasukkan data ke table user
            $this->m_auth->insertTkn('users_token',$users_token); //Memasukkan data ke tabel token
            
            $this->_sendEmail($token,$email,'verify',$user_data);//Mengirim token ke fungsi _sendEmail
            $this->session->set_flashdata('alert',success('<strong>Congratulation!</strong> Your account has been created, Please Check your email.'));
            redirect('login');
        }
    }

    private function _sendEmail($token, $email, $type, $user_data)
    {
      if($type == 'verify'){
        $subject = 'Account Verification';
        $url = base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token);
        $content = 'welcome';
      } else if($type == 'forgot'){
        $subject = 'Reset Password';
        $url = base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token);
        $content = 'password-reset';
      }
      
      $message = [
        'subject' => $subject,
        'html_content' => $content,
        'to_email' => $email,
        'data_content' => [
          'name' => $user_data['user_name'],
          'username' => $user_data['user_username'],
          'sender_email' => $_ENV['SENDGRID_EMAIL'],
          'sender' => 'Admin',
          'brand' => 'Red Wash',
          'action_url' => $url,
          'login_url' => base_url('login'),
          'date' => date("Y-m-d H:i:s"),
          'year' => date("Y")
        ],
        'message_type' => 'auth'
      ];
      $this->notificationservice->send_email($message);
      
      // $this->producer->publish($message);
      
    }

    // //Fungsi sendEmail
    // private function _sendEmail($token, $email, $type)
    // {
    //   //Konfigurasi untuk email pengirim kode aktivasi
    //   $config = array(
    //     'protocol'  => 'smtp',
    //     'smtp_host' => 'ssl://smtp.googlemail.com',
    //     'smtp_user' => $_ENV['AUTH_EMAIL'],
    //     'smtp_pass' => $_ENV['AUTH_PASSWORD'],
    //     'smtp_port' => 465,
    //     'mailtype'  => 'html',
    //     'charset'   => 'utf-8',
    //     'newline'   => "\r\n"
    //   );

    //   //$this->load->library('email',$config);
    //   //Menjalankan librari email dari konfigurasi yang ada
    //   $this->email->initialize($config);

    //   //Email pengirim
    //   $this->email->from('radevman403','Admin RedWash');
    //   //Email akan dikirim ke email yang di input
    //   $this->email->to($email);

    //   //Jika fungsi sendEmail untuk verify
    //   if($type == 'verify'){
    //     $this->email->subject('Account Verification');
    //     $this->email->message('Click this link to verify your account : 
    //       <a href="'.base_url() . 'auth/verify?email=' . $email 
    //       . '&token=' . urlencode($token) . '">Activate</a>');//Masuk kembali ke login
    //   } else if($type == 'forgot'){
    //     $this->email->subject('Reset Password');
    //     $this->email->message('Click this link to reset your password : 
    //       <a href="'.base_url() . 'auth/resetpassword?email=' . $email 
    //       . '&token=' . urlencode($token) . '">Reset Password</a>');//Masuk ke forgot password
    //   }

    //   //Mengirim email
    //   if($this->email->send()){
    //     return true;
    //   }else{
    //     echo $this->email->print_debugger();
    //     die;
    //   }
    // }

    //Fungsi verify
    public function verify()
    {
      $email = $this->input->get('email');
      $token = $this->input->get('token');

      $user = $this->m_auth->getUser('users', $email);

      if($user){
        $users_token = $this->m_auth->getToken('users_token', $token);

        if($users_token){
          if(time() - $users_token['user_cdate'] < (60*60*24)){//Batas waktu token
            $this->db->set('user_is_active', 1);
            $this->db->where('user_email', $email);
            $this->db->update('users');
            $this->db->delete('users_token', ['user_email' => $email]);
            
            $this->session->set_flashdata('alert',success('<strong>'.$email.'</strong> has been activated! Please login.'));
            redirect('login');

            }else{
              //Jika waktu nya habis
              $this->db->delete('users', ['user_email' => $email]);
              $this->db->delete('users_token', ['user_email' => $email]);
              $this->session->set_flashdata('alert',error('Account activation failed! Token expired.'));
              redirect('auth');
          }
        }else{
          //Jika token berbeda dari tabel token
          $this->session->set_flashdata('alert',error('Account activation failed! Token Invalid.'));
          redirect('login');
        }
      }else{
        //Jika token benar, email salah
        $this->session->set_flashdata('alert',error('Account activation failed! Wrong email.'));
        redirect('login');
      }
    }

    //Fungsi Logout
    public function logout()
    {
      $this->session->unset_userdata('username');
      $this->session->unset_userdata('name');
      $this->session->unset_userdata('email');
      $this->session->unset_userdata('role_id');
      $this->session->unset_userdata('status');

      $this->session->set_flashdata('alert',success('You have been logged out!'));
      redirect('home');
    }

    //Fungsi blok
    public function block()
    {
      $this->load->view('templates/blocked');
    }

    //Fungsi lupa password
    public function forgotPass()
    {
      $this->form_validation->set_rules('email','Email','trim|required|valid_email');
      $this->form_validation->set_error_delimiters('<small class="text-danger pl-3">','</small>');
      if($this->form_validation->run() == false){
        $data['title'] = 'Forgot Password';
        $this->load_view('v_forgotpassword', $data);
      }else{
        $email  = $this->input->post('email');
        $user_data   = $this->db->get_where('users', ['user_email' => $email, 'user_is_active' => 1])->row_array();

        if($user_data){
          $token = base64_encode(random_bytes(32));
          $users_token = [
            'user_email' => $email,
            'user_token' => $token,
            'user_cdate' => time()
          ];

          //Memasukkan data token ke tabel
          $this->m_auth->insertTkn('users_token',$users_token);
          //Memanggil fungsi sendEmail dengan kondisi forgot
          $this->_sendEmail($token,$email,'forgot',$user_data);
          $this->session->set_flashdata('alert',success('Please check your email to reset your password!'));
          redirect('login');
        }else{
          //Jika email nya belum di registrasi
          $this->session->set_flashdata('alert',error('Email is not registered or activated!'));
          redirect('forgot-password');
        }
      }
    }

    //Fungsi password
    public function resetpassword()
    {
      $email = $this->input->get('email');
      $token = $this->input->get('token');

      $user = $this->m_auth->getUser('users', $email);

      if($user){
        $users_token = $this->m_auth->getToken('users_token', $token);

        if($users_token){
          $this->session->set_userdata('reset_email', $email);//Memasang session dari email
          $this->changePass();//Memanggil fungsi changePass
        }else{
          //Jika token nya salah
          $this->session->set_flashdata('alert',error('Reset password failed! Wrong token.'));
          redirect('login');
        }
      }else{
        //Jika email nya salah
        $this->session->set_flashdata('alert',error('Reset password failed! Wrong email.'));
        redirect('login');
      }
    }

    //Fungsi changePass
    public function changePass()
    {
      //Jika session nya tidak ada
      if(!$this->session->userdata('reset_email')){
        redirect('login');
      }
      $rules = array(
        array(
                'field' => 'password1',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|matches[password2]'
        ),
        array(
                'field' => 'password2',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|matches[password1]'
        )
      );
      $this->form_validation->set_error_delimiters('<small class="text-danger pl-3">','</small>');
      $this->form_validation->set_rules($rules);
      if($this->form_validation->run() == false){
        $data['title'] = 'Change Password';
        $this->load_view('v_changepassword', $data);
      }else{
        $password = password_hash($this->input->post('password1'),PASSWORD_DEFAULT);
        $email = $this->session->userdata('reset_email');

        $this->db->set('user_password', $password);
        $this->db->where('user_email', $email);
        $this->db->update('users');
        $this->db->delete('users_token', ['user_email' => $email]);

        $this->session->unset_userdata('reset_email');
        $this->session->set_flashdata('alert',success('Password has been changed! Please login.'));
        redirect('login');
      }
    }
}