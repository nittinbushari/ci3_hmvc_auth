<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 8/28/17
 * Time: 10:36 PM
 */
class Front_Controller extends Core_Controller{
    function __construct()
    {
        parent::__construct();
        $this->theme = "frontend";
        $this->config->load('asset');
        $this->config->config['assets']['path'] = 'themes/'.$this->theme.'/';
        $this->config->item('path','assets');
        
        $this->load->helper('asset');

       
        $this->template
            ->set_theme($this->theme)
            ->set_layout('layout');


        $this->user_details = $this->ion_auth_model->user()->row();

    }
}