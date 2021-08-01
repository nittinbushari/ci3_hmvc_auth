<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Main_Controller {


	function __construct(){
		parent::__construct(); 
	}

	public function index($offset = 0)
	{
		//home baner
		add_hook('home-banner','home-banner',$this,'displayBanner',array());
		// add_hook('sidebars','blog-categories',Modules::load('blog'),'getCategoryTree',array());
		$this->template
		->title('Welcome')
		// ->set_partial('sidebar', 'layouts/sidebars/main')
		->set_layout('homepage')
		->build('welcome_message');
	}


	/**
	function to display banner **/
	public function displayBanner(){
		echo $this->load->view('welcome/banner',true);
	}

	function view($slug){
		if(!$slug){
			show_404();
			exit;
		}
		$slug = urldecode($slug);
		$this->config->load('blog/table');
		$this->load->model('pages/pages_m','pages_m',true);
		$this->load->model('blog/blog_m', 'blog_m', true);
		if($this->pages_m->count_by('pages',array('slug'=>$slug))>0){
			Modules::load('pages')->view($slug);
		}elseif($this->blog_m->count_by('blog_posts', array('url_title' => $slug)) > 0){
			Modules::load('blog')->post($slug);
		}

    }

}
