<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model{
    
    //Ambil data user
    public function getUser($table, $useremail,$username)
    {
        $where = "user_email = '$useremail' OR user_username = '$username'";
        return $this->db->get_where($table, $where)->row_array();
    }

    public function getUsernemail($user_id)
    {
        $result = $this->db
            ->select('user_email')
            ->from('users')
            ->where("user_id = {$user_id}")
            ->get();
        return $result->row_array();
    }

    //Ambil jumlah antrian hari ini
    public function getctqueue($statusQ, $date)
    {
        $where = "status='$statusQ' AND date(ctime)='$date'";
        $query = $this->db
            ->select('COUNT(`status`)as statusq')
            ->from('tbl_washing')
            ->where($where)
            ->get();
        return $query->row();
    }

    //Ambil jumlah pekerjaan hari ini
    public function getctprocess($statusP, $date)
    {
        $where = "status='$statusP' AND date(ctime)='$date'";
        $query = $this->db
            ->select('COUNT(`status`)as statusp')
            ->from('tbl_washing')
            ->where($where)
            ->get();    
        return $query->row();
    }

    //Total pendapatan perbulan
    public function getmonthly($table,$date)
    {
        $where = "MONTH(ctime) = MONTH('$date')";
        $query = $this->db
            ->select('SUM(`tot_cost`)AS totMonth')
            ->from($table)
            ->where($where)
            ->get();    
        return $query->row();
    }

    //Total pendapatan pertahun
    public function getannual($table,$date)
    {
        $where = "YEAR(ctime) = YEAR('$date')";
        $query = $this->db
            ->select('SUM(`tot_cost`)AS totYear')
            ->from($table)
            ->where($where)
            ->get();    
        return $query->row();
    }

    //Ambil data antrian hari ini
    public function getqueue($table, $statusQ, $date)
    {
        $where = "status='$statusQ' AND date(ctime)='$date'";
        return $this->db->get_where($table, $where)->result_array();
    }

    //Ambil data pekerjaan hari ini
    public function getprocess($table, $statusP,$date)
    {
        $where = "status='$statusP' AND date(ctime)='$date'";
        return $this->db->get_where($table, $where)->result_array();
    }

    //Ambil data selesai hari ini
    public function getcompleted($table, $statusC,$date)
    {
        $where = "status='$statusC' AND date(ctime)='$date'";
        return $this->db->get_where($table, $where)->result_array();
    }

    //Ambil data paket motor
    public function gettype()
    {
        return $this->db->get('tbl_typemotor')->result();
    }

    public function getPacket($price)
    {
        $result = $this->db
            ->select('motor_type')
            ->from('tbl_typemotor')
            ->where("price = {$price}")
            ->get();
        return $result->row_array();
    }

    //Fungsi membuat kode
    public function bkcode()
    {
        $this->db->select('RIGHT(tbl_washing.code_booking,3) as cbook',FALSE);
        $this->db->order_by('code_booking','DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_washing'); //Check kode pada tabel
        if($query->num_rows() <> 0){
            //Jika kode nya sudah ada
            $data = $query->row();
            $cbook = intval($data->cbook) + 1;
        }else{
            //Jika kode belum ada
            $cbook = 1;
        }
        $cbookmax = str_pad($cbook, 3, "0", STR_PAD_LEFT); //Angka 3 menunjukkan jumlah digit angka 0
        $cdbook = "RWB-".$cbookmax; // Hasil RWB-001 dst.
        return $cdbook;
    }

    //Menambah pemesanan
    public function insertBook($table, $data) {
        $this->db->insert($table, $data);
    }

    //generate dataTable serverside metode untuk ordermanagement
    function getOrder() {
        $this->datatables->select('nm_consumer,contact,code_booking,noplat,pay,tot_cost,ch_cost,status');
        $this->datatables->from('tbl_washing');
        $this->datatables->where('date(ctime)',date("Y-m-d"));
        $this->datatables->add_column('payment','<a href="javascript:void(0);" class="pay_record border-0 btn-transition btn btn-outline-warning btn-sm mb" 
        data-booking="$1" data-noplat="$2" data-tot_cost="$4" data-pay="$3" data-ch_cost="$5"><i class="fas fa-money-check-alt"></i></a> 
        ', 'code_booking,noplat,pay,tot_cost,ch_cost');
        $this->datatables->add_column('action',
        '<a href="javascript:void(0);" class="edit_record border-0 btn-transition btn btn-outline-success btn-sm mb" 
        data-booking="$1" data-noplat="$2" data-status="$3"><i class="fas fa-edit"></i></a> 
        <a href="javascript:void(0);" class="delete_record border-0 btn-transition btn btn-outline-danger btn-sm mb" 
        data-booking="$1"><i class="fas fa-trash"></i></a>',
        'code_booking,noplat,status');
        return $this->datatables->generate();
    }

    //DataTable untuk arsip pemesanan 
    function getOrderarchive() {
        $this->datatables->select('nm_consumer,contact,code_booking,noplat,pay,tot_cost,ch_cost,status,cashier,ctime,etime');
        $this->datatables->from('tbl_washing');
        $this->datatables->add_column('view',
        '<a href="javascript:void(0);" class="pay_record border-0 btn-transition btn btn-outline-warning btn-sm mb" 
        data-booking="$3" data-noplat="$4" data-tot_cost="$6" data-pay="$5" data-ch_cost="$7"><i class="fas fa-money-check-alt"></i></a>
        <a href="javascript:void(0);" class="info_record border-0 btn-transition btn btn-outline-info btn-sm mb" data-nm_consumer="$1" data-contact="$2" 
        data-booking="$3" data-noplat="$4" data-pay="$5" data-tot_cost="$6" data-ch_cost="$7" data-status="$8"><i class="fas fa-info-circle"></i></a>
        <a href="javascript:void(0);" class="delete_record border-0 btn-transition btn btn-outline-danger btn-sm mb"
        data-booking="$3"><i class="fas fa-trash-alt"></i></a>',
        'nm_consumer,contact,code_booking,noplat,pay,tot_cost,ch_cost,status,cashier,ctime,etime');
        return $this->datatables->generate();
    }

    //update data method for ordermanagement
    function updateOrder(){
        $code_booking = $this->input->post('code_booking');
        $data = array(
            'status'        => $this->input->post('status'),
            'cashier'       => $this->session->userdata('name'),
            'etime'         => date("Y-m-d H:i:s")
        );
        $this->db->where('code_booking',$code_booking);
        $this->db->update('tbl_washing', $data);
        $result = $this->db->get_where('tbl_washing', array('code_booking' => $code_booking))->row_array();
        $this->session->set_flashdata('alert',success("The status of the motorcycle has changed"));
        return $result;
    }

    //update data method for ordermanagement
    function updatePayment(){
        $code_booking = $this->input->post('code_booking');
        $status = 'Completed';
        $where = "code_booking = '$code_booking' AND  status = '$status'";
        $data = array(
            'pay'       => $this->input->post('pay'),
            'ch_cost'   => $this->input->post('ch_cost'),
            'status'    => 'Paid',
            'cashier' => $this->session->userdata('name'),
            'etime'     => date("Y-m-d H:i:s")
        );
        $this->db->where($where);
        $result = $this->db->update('tbl_washing', $data);
        if ($this->db->affected_rows() == TRUE){
            $this->session->set_flashdata('alert',success("The order was paid successfully"));
        } else {
            $this->session->set_flashdata('alert',error("Payment failed, the vehicle has not been completed"));
        }
        return $result;
    }

    //delete data method for ordermanagement
    function deleteOrder(){
        $code_booking = $this->input->post('code_booking');
        $this->db->where('code_booking',$code_booking);
        $result = $this->db->delete('tbl_washing');
        $this->session->set_flashdata('alert',warning("Motorcycle bookings have been deleted"));
        return $result;
    }

    //Report Model
    function getReport($where) {
        $query = $this
					->db
					->select('code_booking,noplat,pay,tot_cost,ch_cost,cashier,date(ctime)as ctime')
					->from('tbl_washing')
					->where($where)
					->get();

		if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    function getReportdate($where)
    {
        $query = $this->db
            ->select('monthname(ctime)as month,YEAR(ctime)as year')
            ->distinct()
            ->from('tbl_washing')
            ->where($where)
            ->get();
            
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getTotal($where)
    {
        $query = $this->db
            ->select('SUM(`tot_cost`)as tcost, COUNT(`id`)as tbook')
            ->from('tbl_washing')
            ->where($where)
            ->get();
            
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return NULL;
        }
    }
    //End Report Model

    //Start Model Employee
    public function insertEmply($table, $emply) {
        $this->db->insert($table, $emply);
    }

    function getallEmply()
    {
        $this->datatables->select('user_name,user_username,user_contact,id_user_role,user_role,user_is_active,user_ctime');
        $this->datatables->from('users');
        $this->datatables->join('users_role', 'user_role_id=id_user_role');
        $this->datatables->where('user_role', 'Employee');
        $this->datatables->add_column('view',
        '<a href="javascript:void(0);" class="edit_record border-0 btn-transition btn btn-outline-success btn-sm mb" 
        data-name="$1" data-username="$2" data-role="$5" data-status="$6"><i class="fas fa-edit"></i></a>
        <a href="javascript:void(0);" class="delete_record border-0 btn-transition btn btn-outline-danger btn-sm mb"
        data-username="$2"><i class="fas fa-trash-alt"></i></a>',
        'user_name,user_username,user_contact,user_role_id,user_role,user_is_active,user_ctime');
        return $this->datatables->generate();
    }

    function updateEmply()
    {
        $username = $this->input->post('user_username');
        $active = $this->input->post('user_is_active');
        $data = array(
            'user_is_active'       => $active
        );
        $this->db->where('user_username',$username);
        $result = $this->db->update('users', $data);
        $this->session->set_flashdata('alert',success("Employee Data has been updated!"));
        return $result;
    }

    function deleteEmply()
    {
        $username = $this->input->post('user_username');
        $this->db->where('user_username',$username);
        $result = $this->db->delete('users');
        $this->session->set_flashdata('alert',warning("Employee has been deleted!"));
        return $result;
    }
    //End Model Employee

    public function editUser($table,$datauser,$username)
    {
        $where = 
        $this->db->set($datauser);
        $this->db->where('user_username',$username);
        $this->db->update($table);
    }
}