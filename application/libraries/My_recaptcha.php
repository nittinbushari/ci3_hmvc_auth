<?php


class My_recaptcha{
    var $cap,$ci;
    function __construct(){
        $this->ci = & get_instance();
        $this->cap = new Recaptcha();
        add_hook('head','recaptcha',$this,'js',array());
        $this->setKey();
    }

    public function js(){
        echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
    }

    public function setKey(){
        $this->ci->load->model('pages/pages_m');

        $key = $this->ci->pages_m->get('settings',array('code'=>'recaptcha_site_key'))->value;
        $secret = $this->ci->pages_m->get('settings',array('code'=>'recaptcha_secret_key'))->value;

        $this->cap->set_keys($key,$secret);

    }

    public function create(){
        $attributes = array();
        return $this->cap->create_box($attributes);
    }

    public function valid(){
        return $this->cap->is_valid();
    }

}