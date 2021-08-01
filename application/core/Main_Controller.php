<?php

/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 30/06/17
 * Time: 09:30
 */


class Main_Controller extends Core_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->utm();

        //ini_set('display_errors', 1);
        $this->config->load('settings');
        $this->theme = "frontend";
        
        //timestamp addition
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->config->load('asset');
        $this->config->config['assets']['path'] = "themes/" . $this->theme . '/';
        $this->load->helper('asset');

        if (method_exists($this->router, 'fetch_module')) {
            $_module = $this->router->fetch_module();
            if ($_module) {
                $this->config->load($_module . '/table');
            }

        }

        $this->template->set_theme($this->theme);

        if ($this->session->userdata('user_id')) {
            $user_details = (array)$this->ion_auth_model->user()->row();
            
             //$points = get_points();
            $this->template->set('user_details', $user_details);
        //         ->set('points',$points);

        }


        //pagination
        $this->limit = config('per_page');

        /**
         * error reporting
         */

        // if (ENVIRONMENT == 'development') {
        //     $this->output->enable_profiler(true);
        // } else {
        //     $this->output->enable_profiler(false);
        // }

        /**
         * load hooks
         */
        // $this->load->library('pc_hooks');
        // $this->pc_hooks->apply();


        add_hook('newsletter','newsletter',Modules::load('email'),'newsletter',array());

        date_default_timezone_set('America/Los_Angeles');
    }

    public function utm()
    {
        // utm_source, utm_medium and utm_campaign are mandatory if supplied.
        $utm_source = $this->input->get('utm_source');
        if (!empty($utm_source)){

            $get = $this->input->get();
            $this->session->set_userdata('utm_source', $utm_source);

            if(!empty($get['utm_medium'])){
                $this->session->set_userdata('utm_medium', $get['utm_medium']);
            }
            if(!empty($get['utm_campaign'])){
                $this->session->set_userdata('utm_campaign', $get['utm_campaign']);
            }
            if(!empty($get['utm_content'])){
                $this->session->set_userdata('utm_content', $get['utm_content']);
            }
            if(!empty($get['utm_term'])){
                $this->session->set_userdata('utm_term', $get['utm_term']);
            }

            // We'll also store Google Click ID.
            if(!empty($get['gclid'])){
                $this->session->set_userdata('gclid', $get['gclid']);
            }

            // %_SERVER['HTTP_REFERER'] is NOT available on HTTPS.
            $referer = $this->input->server('HTTP_REFERER');
            if (!empty($referer)) {
                $this->session->set_userdata('referer', $referer);
            }
        } else {
            $utm_source = $this->session->userdata('utm_source');
            if (empty($utm_source)) {
                if (!empty($_COOKIE)) {
                    $utm = $this->getUtmDataFromCookie();
                    $this->session->set_userdata('utm_source', @$utm['utm_source']);
                    $this->session->set_userdata('utm_medium', @$utm['utm_medium']);
                    $this->session->set_userdata('utm_campaign', @$utm['utm_campaign']);
                    $this->session->set_userdata('utm_term', @$utm['utm_term']);
                    $this->session->set_userdata('utm_content', @$utm['utm_content']);
                }
            }
        }
    }


    public function getUtmDataFromCookie()
    {
        $data = array();
        foreach($_COOKIE as $name => $value) {
            switch ($name) {
                case "__utmz":
                case "__utmzz":
                    $utmz = explode('|', $value);
                    foreach ($utmz as $row) {
                        list($key, $val) = explode('=', $row);
                        switch ($key) {
                            case "utmcsr":
                                $data['utm_source'] = $val;
                                break;
                            case "utmccn":
                                $data['utm_campaign'] = $val;
                                break;
                            case "utmcmd":
                                $data['utm_medium'] = $val;
                                break;
                            case "utmctr":
                                $data['utm_term'] = $val;
                                break;
                            case "utmcct":
                                $data['utm_content'] = $val;
                                break;
                            default:
                                // We're not capturing "utmgclid".
                        }
                    }
                    break;
                default:
            }
        }
        return $data;
    }

}
