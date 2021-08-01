<?php

class Core_Controller extends MX_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->data=array();
        /** 
         * 
         * script to load database table config for all modules 
         * 
         */

        $this->current_module = $this->router->fetch_module();

        $this->load->library('config_loader');
        $this->config_loader->load();
        
        // end of config loader
        

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        

        /**
         * search plugin folder under modules
         */

        $module_path = APPPATH.'modules';
        $module_path = $module_path.'/'.$this->current_module;
        $folders = array_diff(scandir($module_path), array('.', '..'));

        
        foreach($folders as $folder){
            if(is_dir($module_path.'/'.$folder) && ($folder == 'plugins')){
                    $path = $module_path.'/'.$folder;
                    $plugins = array_diff(scandir($path), array('.', '..'));
                    
                    foreach($plugins as $plugin){
                       
                        if(!is_dir($plugin)){
                            include($path.'/'.$plugin);
                        }
                    }

                    
                }
        }

    }

}

?>