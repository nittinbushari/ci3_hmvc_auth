<?php

class Dashboard extends Front_Controller{
    function __construct()
    {
        parent::__construct();

    }

    function index(){
        $data=array();
        $this->template
            ->title('Dashboard')
            ->build('dashboard',$data);
    }
}