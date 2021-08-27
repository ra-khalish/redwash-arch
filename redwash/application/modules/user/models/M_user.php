<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model{
    
    //Ambil data user
    public function getUser($table, $email)
    {
        return $this->db->get_where($table, ['user_email' => $email])->row_array();
    }

    //Ambil data antrian
    public function getqueue($table, $statusQ, $date)
    {
        $where = "status='$statusQ' AND date(ctime)='$date'";
        return $this->db->get_where($table, $where)->result_array();
    }

    //Ambil data pengerjaan
    public function getprocess($table, $statusP,$date)
    {
        $where = "status='$statusP' AND date(ctime)='$date'";
        return $this->db->get_where($table, $where)->result_array();
    }

    //Ambil data selesai
    public function getcompleted($table, $statusC,$date)
    {
        $where = "status='$statusC' AND date(ctime)='$date'";
        return $this->db->get_where($table, $where)->result_array();
    }

    //Ambil data tipemotor/paket cuci motor
    public function gettype()
    {
        return $this->db->get('tbl_typemotor')->result_array();
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

    //Membuat kode pemesanan
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

    //Menginput pemesanan
    public function insertBook($table, $data_book) {
        $this->db->insert($table, $data_book);
    }

    //Ambil data transaksi dengan DataTables
    public function getTransaction($id) {
        $this->datatables->select('code_booking,noplat,pay,tot_cost,ch_cost,status,ctime,etime');
        $this->datatables->from('tbl_washing');
        $this->datatables->where('user_id',$id);
        $this->datatables->add_column('view',
        '<a href="javascript:void(0);" class="delete_record border-0 btn-transition btn btn-outline-danger btn-sm mb" 
        data-booking="$1"><i class="fas fa-trash"></i></a>',
        'code_booking,noplat,pay,tot_cost,ch_cost,status,ctime,etime');
        return $this->datatables->generate();
    }

    //Menghapus data transaksi
    function delTransaction(){
        $code_booking = $this->input->post('code_booking');
        $this->db->where('code_booking',$code_booking);
        $result = $this->db->delete('tbl_washing');
        $this->session->set_flashdata('alert',warning("Transaction has been deleted"));
        return $result;
    }

    //Query untuk update data user
    public function editUser($table,$datauser,$useremail)
    {
        $this->db->set($datauser);
        $this->db->where('user_email',$useremail);
        $this->db->update($table);
    }

}