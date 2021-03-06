<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 8/17/18
 * Time: 4:57 PM
 */

class Profile extends Main_Controller{
    function __construct()
    {
       
        parent::__construct();
        $this->data=array();
        $this->template
        ->set_layout('fullwidth');
        //->set_partial('sidebar', 'layouts/partials/left-sidebar');
        // ->append_metadata(css('bootstrap.min.css'))
        // ->append_metadata(css('custom.css'));

    }

    function index(){
        if(!$this->session->userdata('user_id')){
            redirect('login');
        }

        $this->data=(array)$this->ion_auth_model->user()->row();
        $this->data['csrf'] = $this->_get_csrf_nonce();
        $this->template->title('')
            ->append_metadata(js('vendor/node_modules/cropit/dist/jquery.cropit.js'))
            ->append_metadata(js('cropitProcess'))
            ->build('profile',$this->data);
    }

    function view($user_id){
        $this->data=array('user'=>(array)$this->ion_auth_model->user($user_id)->row());
        $this->template->title('')
            ->build('profileDetail',$this->data);
    }

    function account_setting(){
        if(!$this->session->userdata('user_id')){
            redirect('login');
        }

        $this->data=array('user'=>(array)$this->ion_auth_model->user()->row());
        $this->data['csrf'] = $this->_get_csrf_nonce();
        $this->template->title('')
            ->build('account_setting',$this->data);
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
