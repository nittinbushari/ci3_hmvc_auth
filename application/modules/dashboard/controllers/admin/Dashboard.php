<?php

class Dashboard extends My_Controller{
    function __construct()
    {
        parent::__construct();

    }

    function index(){
        $data=array();        
        $this->template
            ->title('Workset')
            ->set_breadcrumb('Workset','#')
            ->build('admin/dashboard',$data);
    }
}
