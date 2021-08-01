<?php 

class Config_loader{
    var $ci;
    function __construct()
    {
        $this->ci=&get_instance();
    }

    public function load(){
        $dirs = array_filter(glob(APPPATH . 'modules/*'), 'is_dir');
        foreach ($dirs as $dir) {
            $dir_name = explode('/', $dir);
            $dir_name = $dir_name[count($dir_name) - 1];
            $this->ci->config->load($dir_name . '/table');
        }
    }
}