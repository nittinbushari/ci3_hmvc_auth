<?php

class Pages extends Main_Controller //I am creating a custom base controller, instead of the default CI_Controller
{
    var $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('pages_m');
        $this->load->helper('forum/token');
        ini_set('display_errors',0);
        $this->template->set_layout('layout-sidebar');
        $this->load->library('pages/shortcode');
    }

    public function index()
    {
        //Get Articles
        $data['pages'] = $this->pages_m->get_articles('id','DESC','10');

        //Load View
        $this->load->view('home', $data);
    }

    /**
    function to display sidebar

    **/
    public function showSidebar($slug){
        return $this->template->load_view('layouts/sidebars/'.$slug);
    }


    public function showSlider($slug){
        return $this->template->load_view('layouts/sliders/'.$slug);
    }


    public function view($slug)
    {
        //Get Menu Items
        $this->data['menu_items'] = $this->pages_m->get_menu_items();

        //Get Article
        $this->data['article'] = (array)$this->pages_m->get_articleBySlug($slug);
        $sidebar = $this->data['article']['sidebar'];
        $slider = $this->data['article']['slider'];
        
        if($sidebar){
            //check for sidebar
            $theme_path = $this->template->get_theme_path();
            $sidebar_path = $theme_path.'views/layouts/sidebars/'.$sidebar.'.php';
            if(file_exists($sidebar_path)){
                $this->template->set('sidebar',$this->showSidebar($sidebar));
            }
        }else{
            $sidebar = $this->template->load_view('layouts/partials/left-sidebar.php');
            $this->template->set('sidebar',$sidebar);
            
        }

        


        if($slider){
            $theme_path = $this->template->get_theme_path();
            $slider_path = $theme_path.'views/layouts/sliders/'.$slider.'.php';

            if(file_exists($slider_path)){
                $this->template->set('slider',$this->showSlider($slider));
            }
        }
        
        //Load View
         $this->template
            ->title($this->data['article']['title'])
            ->set('title', $this->data['article']['heading'])
            ->set('class', $this->data['article']['body_class'])
            ->set('meta_keywords',$this->data['article']['meta_keywords'])
            ->set('meta_descriptions',$this->data['article']['meta_description'])
            ->build('pages/inner', $this->data);
            
    }


    
}