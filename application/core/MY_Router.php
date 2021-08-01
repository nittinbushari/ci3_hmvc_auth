<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {
    public $module;
    private $located = 0;

    protected function _set_request($segments = array()){
        $segments = $this->_validate_request($segments);
        // If we don't have any segments left - try the default controller;
        // WARNING: Directories get shifted out of the segments array!
        if (empty($segments))
        {
            $this->_set_default_controller();
            return;
        }

        if ($this->translate_uri_dashes === TRUE)
        {
            $segments[0] = str_replace('-', '_', $segments[0]);
            if (isset($segments[1]))
            {
                $segments[1] = str_replace('-', '_', $segments[1]);
            }
        }

        if($segments[0] == 'admin' && isset($segments[1])){
            if (isset($segments[2])){
                $this->set_method($segments[2]);
                $segments[2] = $segments[2];
            }else{
                $this->set_method('index');
                $segments[2] = 'index';
            }
            $this->directory    = '../modules/'.$segments[1].'/controllers/admin/';
            $this->module       = $segments[1];
            $this->class        = $segments[1];

            $segments[1] = $segments[1];


            unset($segments[0]);
            $this->uri->rsegments = $segments;
        }else{
            $segments = $this->locate($segments);

            if($this->located == -1)
            {
                $this->_set_404override_controller();
                return;
            }

            if(empty($segments))
            {
                $this->_set_default_controller();
                return;
            }

            $this->set_class($segments[0]);

            if (isset($segments[1]))
            {
                $this->set_method($segments[1]);
            }
            else
            {
                $segments[1] = 'index';
            }

            array_unshift($segments, NULL);
            unset($segments[0]);
            $this->uri->rsegments = $segments;
        }
    }
}