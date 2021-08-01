<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 30/06/17
 * Time: 09:30
 */


class My_Controller extends Core_Controller{
    var $theme;

    function __construct()
    {
        parent::__construct();

        // theme used
        $this->theme = "backend";
        //timestamp addition

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->config->load('asset');
        
        // load table config file of all modules

        if (method_exists($this->router, 'fetch_module')) {
            $_module = $this->router->fetch_module();
            $this->config->load($_module . '/table');
        }

        $this->config->config["assets"]['path']='themes/'.$this->theme.'/';
        $this->load->helper('asset');
        $this->load->helper('auth/user');
        
        $this->template
            ->set_theme($this->theme)
            ->set_layout('dashboard');



        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }elseif(!$this->ion_auth->is_admin()){
            redirect('/','refresh');
        }


        $this->user_details = $this->ion_auth_model->user()->row();
        $this->template->set('user_details',$this->user_details);

        //pagination
        $this->limit = config('per_page');

        // if (ENVIRONMENT == 'development') {
        //     $this->output->enable_profiler(true);
        // } else {
        //     $this->output->enable_profiler(false);
        // }

        date_default_timezone_set('America/Los_Angeles');
    }


    public function js($file,$module){
        echo js($file,$module);
    }

    public function css($file,$module){
        echo css($file,$module);
    }
}
