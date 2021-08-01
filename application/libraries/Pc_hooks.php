<?php
class Pc_hooks{
    function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('auth/ion_auth_model', 'ion_auth_model', true);
    }

    function apply(){
        
        // blog sidebar hook
        $args = array('category'=> 'vpn','limit'=>5);
        add_hook('sidebar_blog','sidebar_blog',Modules::load('blog'),'blogWidget',$args);
        
        // blog categories
        add_hook('sidebar_blog','sidebar_category',Modules::load('blog'), 'categoryWidget',array());
        
        
        // badge display
        add_hook('badge', 'badge', Modules::load('points'), 'calculateBadge', array());
        
        
    }
}

?>