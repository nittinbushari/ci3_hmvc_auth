<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 10/1/18
 * Time: 4:02 PM
 */

class Uploads_m extends My_Model{
    function __construct()
    {
        parent::__construct();
        $this->_table = "gallery";
    }
    
    public function getAllImages(){
        $user_id = $this->session->userdata('user_id');
        return $this->db->select('*')
                ->from($this->_table)
                ->where('user_id',$user_id)
                ->get()
                ->result();
    }
   
}