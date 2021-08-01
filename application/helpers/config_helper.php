<?php 

if(!function_exists('config')){
    function config($val){
        $ci = &get_instance();
        return $ci->config->item($val);
    }
}

?>