<?php
if(!function_exists('add_hook')){
    function add_hook($event, $name, $class, $fnc, $args = array()){
        $ci = &get_instance();
        $ci->load->model('auth/ion_auth_model','ion_auth_model',true);
        $ci->ion_auth_model->set_hook($event, $name, $class, $fnc, $args);
    }
}


if(!function_exists('apply_hook')){
    function apply_hook($event){
        $ci = &get_instance();
        $ci->load->model('auth/ion_auth_model','ion_auth_model',true);
        $ci->ion_auth_model->trigger_events($event);
    }
}


if(!function_exists('remove_hook')){
    function remove_hook($event, $name){
        $ci = &get_instance();
        $ci->load->model('auth/ion_auth_model','ion_auth_model',true);
        $ci->ion_auth_model->remove_hook($event, $name);
    }

    
}

if(!function_exists('remove_hooks')){
    function remove_hooks($event){
        $ci = &get_instance();
        $ci->load->model('auth/ion_auth_model','ion_auth_model',true);
        $ci->ion_auth_model->remove_hooks($event);
    }

    
}


if(!function_exists('do_shortcode')){
    function do_shortcode($shortcode){
        $ci = &get_instance();
        $ci->load->library('pages/shortcode');
        return $ci->shortcode->process($shortcode);
    }
}

?>