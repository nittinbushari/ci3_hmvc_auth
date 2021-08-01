<?php

defined ('BASEPATH') or exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation{
    function __construct()
    {
        parent::__construct();
    }

    function run($module = '', $group = '') {
        (is_object($module)) AND $this->CI = &$module;
        return parent::run($group);
    }

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @param	string
     * @return	bool
     */
    public function alpha_dash($str)
    {
        //return (bool)preg_match('/^[a-z0-9_-\pL]+$/u', $str);
        return (bool)preg_match('/^[\p{L}\p{N}_-]+$/u', $str);
    }


}
?>