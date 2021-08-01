<?php class Vars{
    var $vars = array();
    function __construct(){
        
    }

    function get($key){
        return $this->vars[$key];
    }

    function set($key, $value){
        $this->vars[$key] = $value;
    }


} ?>