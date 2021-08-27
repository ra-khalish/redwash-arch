<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    const statusQ = 'Queue',
    statusP = 'Processed',
    statusC = 'Completed';


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'user') {
            redirect('block');
        }
        $this->load->model('m_user');
        $this->load->library('Producer');
    }

    public function get_session()
    {
        $useremail = $this->session->userdata('email');
        return $this->m_user->getUser('users', $useremail);
    }

    public function load_view($main_view, $data)
    {
        $this->load->view('templates/user_header',$data);
        $this->load->view("{$main_view}", $data);
        $this->load->view('templates/user_footer');
    }

    //Kontrol Antrian
    public function queue()
    {
        $data['title'] = 'Queue Page';
        $data['user'] = $this->get_session();
        $date = date("Y-m-d");
        $data['queue']  = $this->m_user->getqueue('tbl_washing', User::statusQ,$date);
        $data['processed']  = $this->m_user->getprocess('tbl_washing', User::statusP,$date);
        $data['completed']  = $this->m_user->getcompleted('tbl_washing', User::statusC,$date);
        $this->load_view('v_rwqueue', $data);
    }

    //Kontrol Pemesanan
    public function fbooking()
    {
        $data['title'] = 'Booking';
        $data['user'] = $this->get_session();
        $data['typemc'] = $this->m_user->gettype();
        $data['codebooking'] = $this->m_user->bkcode();

        $rules = array(
            array(
                    'field' => 'nm_consumer',
                    'label' => 'Consumer',
                    'rules' => 'required'
            ),
            array(
                    'field' => 'contact',
                    'label' => 'Contact',
                    'rules' => 'required|trim|min_length[11]|integer',
                    'errors' => array(
                            'min_length' => 'Your number is too short',
                    ),
            ),
            array(
                    'field' => 'noplat',
                    'label' => 'Plat Number',
                    'rules' => 'required|trim|min_length[3]'
            ),
            // array(
            //         'field' => 'typemotor',
            //         'label' => 'Type',
            //         'rules' => 'required'
            // ),
            array(
                    'field' => 'tot_cost',
                    'label' => 'Total Cost',
                    'rules' => 'required|trim'
            )
        );
        
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('<small class="text-danger pl-3">','</small>');

        if ($this->form_validation->run() == false) {
            $this->load_view('v_booking', $data);
        } else {
            $this->benchmark->mark('code_start');
            $data_order = [
                'user_id' => htmlspecialchars($this->input->post('user_id',true)),
                'nm_consumer' => htmlspecialchars($this->input->post('nm_consumer',true)),
                'contact' => htmlspecialchars($this->input->post('contact',true)),
                // 'code_booking' => htmlspecialchars($this->input->post('code_booking',true)),
                'noplat' => htmlspecialchars($this->input->post('noplat',true)),
                'tot_cost' => htmlspecialchars($this->input->post('tot_cost',true)),
                'status' => User::statusQ,
                'ctime' => date("Y-m-d H:i:s")
            ];
            $data_order['code_booking'] = $this->m_user->bkcode();
            $this->m_user->insertBook('tbl_washing',$data_order);
            $data_order['email'] = $this->session->userdata('email');
            $data_order = array_merge(
                $data_order,
                $this->m_user->getPacket($data_order['tot_cost'])
            );
            $this->notif_service($data_order);
            $this->benchmark->mark('code_end');
            $ipadd = $this->input->ip_address();
            $agent = $this->get_useragent();
            $time =  $this->benchmark->elapsed_time('code_start', 'code_end');
            log_message('info','[v] IP Add: '. $ipadd . " user_id: " . $data_order['user_id'].' Benchmark time: '.$time .' '. $agent);
            $this->session->set_flashdata('alert',success("<strong>Congratulation!</strong> Motorcycle is already in the queue."));
            redirect('user_queue');
        }
    }

    //Kontrol transaksi
    public function transaction()
    {
        $data['title'] = 'Transaction';
        $data['user'] = $this->get_session();
        $this->load_view('v_transaction', $data);
    }

    //Fungsi ambil data transaksi dengan json
    function userTransaction()
    {
        $id = $this->session->userdata('id');
        header('Content-Type: application/json');
        echo $this->m_user->getTransaction($id);
    }

    //Fungsi delete data transaksi
    function deleteTransaction(){ //delete record method
        $this->m_user->delTransaction();
        redirect('user_transaction');
    }

    //Kontrol profile
    public function user_profile()
    {
        $data['title'] = 'Profile';
        $data['user'] = $this->get_session();
        $this->load_view('v_userprofile', $data);
    }

    //Fungsi edit profile
    public function edituserProfile()
    {
        $useremail = $this->session->userdata('email');
        $data = array('success' => false, 'messages' => array());

        $rules = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required',
            ),
            array(
                'field' => 'contact',
                'label' => 'Contact',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                    'min_length' => 'Contact Number too short'
                )
            )
        );
        $this->form_validation->set_rules($rules);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == false) {
            foreach ($this->input->post() as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}
		else {
            $data['success'] = true;
            $datauser = array(
                'user_name' => htmlspecialchars($this->input->post('name',true)),
                'user_contact' => htmlspecialchars($this->input->post('contact',true)),
            );
            $this->m_user->editUser('users',$datauser,$useremail);
			$data['message'] = $this->session->set_flashdata('alert',success("Profile has been updated."));
            $data['view'] = 'user_profile';
		}
		echo json_encode($data);
    }

    //Fungsi edit password
    public function edituserPass()
    {
        $useremail = $this->session->userdata('email');
        $user =  $this->m_user->getUser('users', $useremail);
        $data = array('success' => false, 'error' => false, 'messages' => array());

        $rules = array(
            array(
                'field' => 'current_password',
                'label' => 'Current Password',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required|trim|min_length[8]|matches[new_conpassword]'
            ),
            array(
                'field' => 'new_conpassword',
                'label' => 'New Confrim Password',
                'rules' => 'required|trim|min_length[8]|matches[new_password]'
            )
        );
        $this->form_validation->set_rules($rules);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == false) {
            foreach ($this->input->post() as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		} else {
            $current_password = htmlspecialchars($this->input->post('current_password',true));
            $new_password = htmlspecialchars($this->input->post('new_password', true));

            if(!password_verify($current_password, $user['user_password'])){
                $data['error'] = true;
                $data['message'] = $this->session->set_flashdata('alert',error("Wrong current password!"));
                $data['view'] = 'user_profile';
            }else {
                if($current_password == $new_password){
                    $data['error'] = true;
                    $data['message'] = $this->session->set_flashdata('alert',error("New password cannot be the same as current password"));
                    $data['view'] = 'user_profile';
                }else {
                    $data['success'] = true;
                    //pass ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $datauser = array(
                        'user_password' => $password_hash
                    );
                    $this->m_user->editUser('users',$datauser,$useremail);
                    $data['message'] = $this->session->set_flashdata('alert',success("Password Changed!"));
                    $data['view'] = 'user_profile';
                }
            }
        }
        echo json_encode($data);
    }

    private function notif_service($data_order)
    {  
        $message = [
            'subject' => 'Your order '.$data_order['code_booking'],
            'html_content' => 'notification',
            'to_email' => $data_order['email'],
            'data_content' => [
                'name' => $data_order['nm_consumer'],
                'brand' => 'Red Wash',
                'text' => 'Come on, immediately bring Your vehicle here',
                'code_booking' => $data_order['code_booking'],
                'noplat' => $data_order['noplat'],
                'motor_type' => $data_order['motor_type'],
                'total' => $data_order['tot_cost'],
                'status' => $data_order['status'],
                'time' => $data_order['ctime'],
                'action_url' => base_url('user/queue'),
                'year' => date('Y')
            ],
            'message_type' => 'notif'
        ];
        $this->producer->publish($message);
    }

    function get_useragent()
    {
        $this->load->library('user_agent');
        $agent = [
            'platform' => $this->agent->platform(),
            'browser' => $this->agent->browser().' '.$this->agent->version(),
        ];
        return $agent['platform'].' '.$agent['browser'];
    }

}