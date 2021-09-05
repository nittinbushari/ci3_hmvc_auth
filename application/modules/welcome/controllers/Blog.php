<?php defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends MY_Controller
{
    var $all_categories = array();
    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->model('blog_m');
        $this->load->helper('blog');
        $this->lang->load('blog/blog');
        $this->config->load('table');

        //remove_hook('sidebars','catalog-category');
        //add_hook('after_query','get_category',$this,'getCategory',array());
        //add_hook('sidebars','blog-search',$this,'searchWidget',array());
        //add_hook('categories_list','categories_list',$this,'getCategoryTree',array());
        //add_hook('sidebars','blog-categories',$this,'getCategoryTree',array());
        
        $this->template
            ->set_theme('deal')
            ->set_layout('layout-sidebar')
            ->set('class', 'blog')
            ->append_metadata(css('custom.css'))
            ->append_metadata(css('skins/skin-corporate-3.css'));
        $this->template
            //->set('archives_list', $this->blog_m->get_archive())
            ->set('categories_list', $this->blog_m->get_categories())
            //->set_partial('sidebar', 'sidebar')
            ->set('sidebar',$this->getSidebar()); 

    }


    public function getSidebar(){

        add_hook('sidebars','recent_post',$this,'recent_post',array());
        // add_hook('sidebars','post_archive',$this,'post_archive',array());
        return $this->template->load_view('layouts/sidebars/blog.php');
    }

    /** function to include css */
    public function css(){
        echo css('style.css','blog');
    }

    /*** search widget ******/
    public function searchWidget(){
        echo $this->load->view('widget/blog-search',true);
    }

    public function getCategoryTree(){
        $all_categories = $this->getCategoryHirarchy();
        $data=array('categories'=>$all_categories);
        echo $this->load->view('widget/category_tree',$data,true);
    }



    /**
     * function to get category hirarchy
     */
    public function getCategoryHirarchy($parent = 0){
        $all_categories = $this->blog_m->get_by_array(config('tbl_categories'),array('parent'=>$parent));
        foreach($all_categories as $key => $category){
            add_hook('where','join_post',$this->blog_m,'joinBlog',array());
            $no_of_posts = $this->blog_m->count_by(config('post_to_categories').' AS CAT',array('CAT.category_id'=>$category['id']));
            remove_hook('where','join_post');
            $all_categories[$key]['count'] = $no_of_posts;

            $child_category = $this->getCategoryHirarchy($category['id']);
            if(count($child_category)>0):
                $all_categories[$key]['child'] = $child_category;
                $count_posts = array_column($all_categories[$key]['child'],'count');
                $sum_of_posts = array_sum($count_posts);
                $all_categories[$key]['count'] = $no_of_posts + $sum_of_posts;
            endif;

        }

        return $all_categories;
    }


    public function index($offset = 0)
    {

        if ($this->input->get()) {
            $q = $this->input->get('q');
            add_hook('extra_like', 'search', $this->blog_m, 'searchBlog', array($q));

        }
        
        // get the posts
        $posts = $this->blog_m->getAllPosts($this->limit, $offset);
        $total = $this->blog_m->getAllPosts()->post_count;
        $data['posts'] = ($posts && $posts->posts) ? $posts->posts : '';

        if($this->input->get('q')){
            remove_hook('extra_like', 'search'); 
        }
        
        
        $this->template->title('Blog')
            ->set('title', 'Blog')
            ->set('page_title','Blog')
            ->set('class', 'blog')
            ->set('breadcrumb',1) 
            // ->set_breadcrumb('Home',site_url())
            ->set_breadcrumb('Blog',site_url('blog'))
            //->append_metadata(css('bootstrap.min.css'))
            ->set('pagination',pagination(site_url('blog'),$total,$offset))
            ->build('index', $data);
    }


    public function getBlog($offset = 0){
        
        if ($this->input->post()) {
            $q = $this->input->post('q');
            $this->ion_auth_model->set_hook('extra_like', 'search', $this->blog_m, 'searchBlog', array($q));
        }

        $uri = $this->uri->uri_string();
        
        // get the posts
        $posts = $this->blog_m->getAllPosts($this->limit, $offset);
        $total = $this->blog_m->getAllPosts()->post_count;
        $data['posts'] = ($posts && $posts->posts) ? $posts->posts : '';
        
        if($uri == ''){
            $controller = 'welcome';
        }else{
            $controller = "blog";
        }

        $data['pagination'] = pagination(site_url($controller.'/index'), $total);

        echo $this->template->load_view('blog/index',$data,true);
            
    }

    public function getCategory(){
        $category_slug = $this->vars->get('category');
        $category = $this->blog_m->get(config('tbl_categories'),array('slug'=>$category_slug));
        $this->template
        ->title($category->name)
        ->set('category',$category);
    }


    /**
     * Category
     *
     * Shows posts in a particular category
     *
     * @access  public
     * @author  Enliven Applications
     * @version 3.0
     *
     * @return  null
     */
    public function category($url_name = null, $offset = 0)
    {
        if($this->vars->get('scode_args')){
            $this->vars->set('blog_return',true);
            $url_name = $this->vars->get('scode_args');
        }

        $this->vars->set('category',$url_name);
        if ($data = $this->blog_m->get_posts_by_category($url_name)) {
            $total = $data->post_count;
        } else {
            $data['posts'] = false;
        }

        apply_hook('after_query');

        
        if($this->vars->get('blog_return')){

            $this->template->set('pagination', pagination(site_url($this->uri->uri_string()), $total));
            echo $this->load->view('blog/posts_per_category',$data,true);
            
        }else{

            if ($url_name != null) {
                $this->template->set('pagination', pagination(site_url('blog/category/' . $url_name), $total));
            } else {
                $this->template->set('pagination', pagination(site_url('blog/category'), $total));
            }

            $this->template
                ->set('title', 'Category:' . ucwords($url_name))
                ->append_metadata(css('bootstrap.min.css'))
                ->append_metadata(css('theme-elements.css'))
                ->append_metadata(css('skins/skin-corporate-3.css'))
                ->build('posts_per_category', $data);
        }

        
    }

    public function categoryWidget()
    {
        $categories = $this->blog_m->get_categories();
        $data = array('categories' => $categories);
        $this->load->view('categories', $data);
    }



    /**
     * Archive
     *
     * Shows archives for year/month
     *
     * @access  public
     * @author  Enliven Applications
     * @version 3.0
     *
     * @return  null
     */
    public function archive($year = null, $month = null, $offset = 0)
    {
        if ($data = $this->blog_m->get_posts_by_date($year, $month)) {
            //Create Pagination
            $this->load->library('pagination');

            /*
                the setting for bootstrap 3 or Semantic UI are
                already set in /applications/config/pagination.php
             */

            $config['base_url'] = site_url();
            $config['total_rows'] = $data->post_count;
            $config['per_page'] = $this->config->item('posts_per_page');

            // docs say we don't have to if we have a config file, but we have to
            $this->pagination->initialize($config);

            // tasty Links
            $data->pagination = $this->pagination->create_links();

            $this->template
                ->append_metadata(css('bootstrap.min.css'))
                ->append_metadata(css('theme-elements.css'))
                ->build('index', $data);
        }
    }

    /**
     * post
     *
     * Show a single post
     *
     * @access  public
     * @author  Enliven Applications
     * @version 1.0
     */
    public function post($url_title = null)
    {
        
        // load up some narrowly needed stuff
        $this->load->model('comments/article_comments_model', 'comments_m', true);
        $this->load->library('form_validation');

        if (isset($_GET['preview']) && $_GET['preview'] == 1) {
            $this->ion_auth_model->set_hook('preview', 'preview', $this->blog_m, 'previewBlog', array());
        }

        // We kan haz a post?
        if ($data['post'] = $this->blog_m->get_post_by_url($url_title)) {
            $this->ion_auth_model->set_hook('extra_comment_query', 'enable-moderate', $this->comments_m, 'moderateFnc', array($data['post']['id']));

           // exisiting comments?
            $data['comments'] = $this->comments_m->get_comments($data['post']['id']);

            if (config('allow_comments') == 1 && $this->input->post()) {
                if ($data['post']['allow_comments'] != 0) {
                    $this->new_comment($data['post']['id'], site_url($url_title));
                }
            }


        }

        //$this->obcore->set_meta($data['post'], 'post');
        // echo "<pre>";
        // print_r($data);die;
        // build the page
        $this->template
            ->title($data['post']['meta_title'] ? $data['post']['meta_title'] : $data['post']['title'])
            ->set('title', $data['post']['meta_title'] ? $data['post']['meta_title'] : $data['post']['title'])
            ->set('category','Blog')  
            ->set('page_title',$data['post']['title'])
            ->set('uri','blog')
            ->set_layout('fullwidth')
            ->set('class','blog-detail')
            // ->set_breadcrumb('Home',site_url())
            ->set_breadcrumb('Blog',site_url('blog'))
            ->set_breadcrumb($data['post']['title'],site_url().$url_title)
            ->set('meta_description', $data['post']['meta_description'])
            ->set('meta_keywords', $data['post']['meta_keywords']);
           
            //->append_metadata(css('theme-elements.css'))

        $this->template->build('blog/single_post', $data);

    }

    public function comments(){
        echo "fjakjfbaj";
    }

    /**
     * new comment
     *
     * adds new comment to a post
     *
     * @param   $id The post ID
     * @param   $url to redirect back to post
     * @param   $parent The parent comment, if any. depth = 1
     *
     * @access  public
     * @author  Enliven Applications
     * @version 1.0
     */
    public function new_comment($parent = 'false')
    {
        $id= $this->input->post('post_id');
        $url=$this->input->post('url');
        $this->load->model('article_comments_model', 'comments_m', true);

        // do we use reCaptcha
        if ($this->config->item('use_recaptcha') == 1) {
            $this->form_validation->set_rules('g-recaptcha-response', 'lang:recaptcha', 'callback_verify_recaptcha');
        }

        // are we using the honeypot?
        if ($this->config->item('use_honeypot') == 1) {
            if (!empty($this->input->post('date_stamp_gotcha'))) {
                redirect();
            }
        }

        // looged in user? no need to worry them for
        // info we already have.
        if ($this->ion_auth->logged_in() == false) {
            $this->form_validation->set_rules('nickname', 'Name', 'required|max_length[50]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');


        }

        // need a comment though
        $this->form_validation->set_rules('comment', 'Comment', 'required|htmlentities');

        // pretty for Bootstrap 3
        // TODO: switching for Semantic UI
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        // run it!  did it pass validation?
        if ($this->form_validation->run() == true) {

            $this->ion_auth_model->set_hook('before_comment_insert', 'enable_modded', $this, 'enableModded', array($id));

            if ($this->comments_m->create_comment($id)) {
                // default oops
                $message = 'unknown error';

                // if they're logged in, but are they being
                // moderated?
                if ($this->ion_auth->logged_in()) {
                    $message = ($this->config->item('mod_user_comments') == 0) ? lang('add_comment_success') : lang('add_comment_success_modded');
                }
                // they're not logged in, but are they being
                // moderated?
                else {
                    $message = ($this->config->item('mod_non_user_comments') == 0) ? lang('add_comment_success') : lang('add_comment_success_modded');
                }

                // point_add(7);

                // woot!  set the success message
                $this->session->set_flashdata('success', 'Your Comment Posted Successully!');

                redirect($url);
            }


        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($url);
        }
    }


    /**
     * verify reCaptcha
     *
     * uses Phil Sturgeon's Rest client
     * to connect to google.com new v2
     * recaptcha system and verify the
     * captcha token provided by the user
     * is valid.
     *
     * @access  public
     * @author  Enliven Applications
     * @version 1.0
     */
    public function verify_recaptcha($str)
    {
        // applications/libraries
        $this->load->library('rest');

        // rest config
        $config = array(
            'server' => 'https://www.google.com/recaptcha/api/',
        );

        // post info to send to google
        $post = array(
            'secret' => $this->config->item('recaptcha_private_key'), // see admin settings
            'response' => $str, // redicilously long string from form.
            'remoteip' => $this->input->ip_address()  // optional, but we're going to do it anyway.
        );

        // Run Rest initialization
        $this->rest->initialize($config);

        // Pull in response
        $recaptcha = $this->rest->post('siteverify', $post);

        // because dashes in objects...
        // bleh.  Thanks google.
        $recaptcha = (array)$recaptcha;

        // errors?
        if (isset($recaptcha['error-codes'])) {
            // we'll need humanize() shortly.
            $this->load->helper('inflector');

            // add errors to the form_validation error message
            foreach ($recaptcha['error-codes'] as $error) {
                /*
                Set a human readable error message.

                Fun fact: an undocumented second param in humanize() allows
                          one to specify the Input Separator.  the default is
                          the underscore.  Google returns a dash.
                 */
                $this->form_validation->set_message('verify_recaptcha', 'Recaptcha - ' . humanize($error, '-'));
            }
            // there were errors, so the callback fails
            return false;
        }
        // no errors.  Winner, winner, chicken dinner.
        return true;
    }

    /**
     * blog widget
     */

    function blogWidget($category, $limit)
    {

        $data = (array)$this->blog_m->get_posts_by_category($category, $limit);
        $cat = $this->blog_m->get(config('tbl_categories'), array('slug' => $category));
        $data['title'] = $cat->name;
        $this->load->view('widget/sidebar-widget', $data);
    }


    /**
     * check for modded
     */

    function enableModded($post)
    {

    }

    /*
    * Recent post widget
    */ 
    function recent_post(){
        $posts=$this->blog_m->get_by('blog_posts','',array('id'=>'DESC'),'5');
        echo '<div class="theme-card">
        <h4>Recent Blog</h4>
        <ul class="popular-blog">';
        foreach ($posts as $post):?>
            <li>
                <div class="media"> 
                    <div class="blog-date"><span><?php echo date('d',strtotime($post['created_datetime'])); ?> </span><span><?php echo date('M',strtotime($post['created_datetime'])); ?></span></div>
                    <a href="<?php echo site_url($post['url_title']); ?>">
                        <div class="media-body align-self-center">
                            <h6><?php echo $post['title'];?></h6>
                        </div>
                    </a>
                </div>
            </li>  
            <?php endforeach;
        echo '</ul>
        </div>';
    }

} // EOC
