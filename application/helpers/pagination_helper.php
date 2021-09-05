<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function pagination($url, $rowscount, $offset)
{
    $ci = & get_instance();
    $ci->load->library('pagination');
	$config = array();
    $config["base_url"] = $url;
    $config["total_rows"] = $rowscount;
    $config["per_page"] = config('posts_per_page');
    //$config['use_page_numbers'] = TRUE;
    $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['first_link'] = lang('first');
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = lang('last');
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = lang('next');
    $config['prev_link'] = lang('previous');
    $config['reuse_query_string'] = TRUE;

    $ci->pagination->initialize($config);
    $pagination = $ci->pagination->create_links();
    
    if($pagination):
        $ci->load->vars(array('pagination'=>$pagination,'total'=>$rowscount,'offset'=>$offset));
        return $ci->template->load_view('layouts/partials/pagination');
    endif;
}
