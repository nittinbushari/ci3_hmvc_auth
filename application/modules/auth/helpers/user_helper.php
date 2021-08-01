<?php

if(!function_exists('user')){
    function user($user_id){
        $ci = &get_instance();
        return $user = $ci->ion_auth_model->user($user_id)->row();
    }
}

?>