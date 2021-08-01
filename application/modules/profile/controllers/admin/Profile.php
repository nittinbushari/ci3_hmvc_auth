<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 8/17/18
 * Time: 4:57 PM
 */

class Profile extends My_Controller{
    function __construct()
    {
        parent::__construct();
    }

    function index($id=''){
        if($id){
            $this->user_details = $this->ion_auth_model->user($id)->row();
        }
         $data=array('user'=>(array)$this->user_details);
        if($id){
            $data['id']=$id;
        }
        $data['csrf'] = $this->_get_csrf_nonce();
        $this->template->title('Profile')
            ->build('admin/profile',$data);
    }

    function account_setting($id=''){
        if($id){
            $this->user_details = $this->ion_auth_model->user($id)->row();
        }
        $this->data=array('user'=>(array)$this->user_details);
        if($id){
            $data['id']=$id;
        }
        $this->data['csrf'] = $this->_get_csrf_nonce();
        $this->template->title('')
            ->build('admin/account_setting',$this->data);
    }

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }
}