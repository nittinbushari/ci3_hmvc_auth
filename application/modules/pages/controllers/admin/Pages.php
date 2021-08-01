<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Pages extends My_Controller
{
    public function __construct()
    {
        //ini_set('display_errors',1);
        parent::__construct();
        $this->load->model('pages_m');
        $this->load->library('form_validation');
        $this->load->helper('pages');
    }


    public function index($offset = 0)
    {
        //Get Articles
        $data['pages'] = $this->pages_m->get_articles('id','DESC', $this->limit, $offset);
        $total = count($this->pages_m->get_articles('id', 'DESC'));
        $data['pagination'] = pagination(site_url('admin/pages/index'),$total);
        $this->template
            ->title('Pages')
            ->build('admin/index',$data);
    }


    public function getSidebars(){
        $sidebars = array(''=>'Select Sidebar');
        $theme_path = FCPATH.'themes/frontend/views/layouts/sidebars';
        
        $files = array_diff(scandir($theme_path), array('.', '..'));

        
        foreach($files as $file){
            if(!is_dir($file)){
                $ext = explode('.php',$file);
                if(count($ext) > 1){
                    $sidebars[$ext[0]] = $ext[0];
                }
                
            }    
        }

        return $sidebars;

    }



    public function getSliders(){
        $sliders = array(''=>'Select Slider');
        $theme_path = FCPATH.'themes/frontend/views/layouts/sliders';
        
        $files = array_diff(scandir($theme_path), array('.', '..'));

        
        foreach($files as $file){
            if(!is_dir($file)){
                $ext = explode('.php',$file);
                if(count($ext) > 1){
                    $sliders[$ext[0]] = $ext[0];
                }
                
            }    
        }

        return $sliders;

    }


    /*
     * Add Article
     */
    public function add()
    {
        
        //$data['categories'] = $this->pages_m->get_categories();
        if($this->input->post()){
            //Validation Rules
            $this->form_validation->set_rules('title','Title','trim|required');
            $this->form_validation->set_rules('body','Body','trim|required');
            $this->form_validation->set_rules('is_published','Publish','required');

            $build_slug = true;
            if($this->input->post('slug')){
                $this->form_validation->set_rules('slug','Page Slug','required|alpha_dash|is_unique[pages.slug]|is_unique[blog_posts.url_title]');
                $build_slug = false;
            }

            if($this->form_validation->run() == FALSE)
            {
                message('error',validation_errors());
                redirect(current_url());

            }
            else
            {
                if($build_slug){
                    $config=array(
                        'field' => 'slug',
                        'title'=> $this->input->post('title'),
                        'table'=> 'pages'
                    );

                    $this->load->library('slug', $config);
                    $slug = $this->slug->create_slug($this->input->post('title'));
                }else{
                    $slug = $this->input->post('slug');
                }



                //Create Articles Data Array
                $data = array(
                    'slug'          => $slug,
                    'title'         => $this->input->post('title'),
                    'body'          => $this->input->post('body'),
                    'category_id'   => '',
                    'user_id'       => $this->session->userdata('user_id'),
                    'access'   		=> 0,
                    'is_published'  => $this->input->post('is_published'),
                    'in_menu'  		=> 0,
                    'position'  	=> 0,
                    'meta_description'=>$this->input->post('meta_description'),
                    'meta_keywords'=>$this->input->post('meta_keywords'),
                    'heading'       => '',
                    'body_class'    => $this->input->post('body_class'),
                    'sidebar'       => $this->input->post('sidebars'),
                    'slider'        => $this->input->post('sliders')
                );

                //Articles Table Insert - Insert the Articles in the DB
                $this->pages_m->insert('pages',$data);

                //Create Message
                $this->session->set_flashdata('success', 'Your article has been saved');


                //Redirect to pages
                redirect('admin/pages');
            }
        }


        $data['sidebars'] = $this->getSidebars();
        $data['sliders'] = $this->getSliders();

        $this->template
            ->title('Pages')
            ->build('admin/add', $data);
    }


    /*
     * Edit Article
     *
     * @param - $id
    */
    public function edit($id)
    {
        $data = $this->pages_m->get_article($id);
        //$data->categories = $this->pages_m->get_categories();
        if($this->input->post()){
            //Validation Rules
            $this->form_validation->set_rules('title','Title','trim|required');
            $this->form_validation->set_rules('body','Body','trim');
            $this->form_validation->set_rules('heading','Heading','trim');

            $build_slug = false;
            if($this->input->post('slug') && $this->input->post('slug') != $data->slug){
                $this->form_validation->set_rules('slug', 'Slug', 'required|alpha_dash|is_unique[pages.slug]|is_unique[blog_posts.url_title]');
                $build_slug = true;
            }

            if($this->form_validation->run() == FALSE)
            {
                message('error', validation_errors());
                redirect(current_url());

            }
            else
            {
                //Create Articles Data Array
                $data = array(
                    'title'         => $this->input->post('title'),
                    'body'          => $this->input->post('body'),
                    'category_id'   => '',
                    'user_id'       => $this->session->userdata('user_id'),
                    'access'   		=> 0,
                    'is_published'  => $this->input->post('is_published'),
                    'in_menu'  		=> 0,
                    'position'  	=> 0,
                    'meta_description'=>$this->input->post('meta_description'),
                    'meta_keywords'=>$this->input->post('meta_keywords'),
                    'heading'       => $this->input->post('heading'),
                    'body_class'    => $this->input->post('body_class'),
                    'sidebar'       => $this->input->post('sidebars'),
                    'slider'        => $this->input->post('sliders')
                );

                if($build_slug){
                    $data['slug'] = $this->input->post('slug');
                }

                //Articles Table Insert
                $this->pages_m->update('pages',$data, array('id'=>$id));

                //Create Message
                $this->session->set_flashdata('success', 'Your article has been saved');

                //Redirect to pages
                redirect('admin/pages/edit/'.$id);
            }


        }

        $sidebars = $this->getSidebars();
        
        //Views
        $this->template->title('Edit Page')
            ->set('sidebars',$sidebars)
            ->set('sliders',$this->getSliders())
            ->build('admin/edit', $data);
    }


    /*
     * Publish Article
    *
    * @param - (int) $id
    */
    public function publish($id)
    {
        //Publish Menu Items in array
        $this->pages_m->publish($id);

        //Create Message
        $this->session->set_flashdata('article_published', 'Your article has been published');

        //Redirect to articles
        redirect('admin/pages');
    }



    /*
     * Unpublish Article
    *
    * @param - (int) $id
    */
    public function unpublish($id)
    {
        //Publish Menu Items in array
        $this->pages_m->unpublish($id);

        //Create Message
        $this->session->set_flashdata('article_unpublished', 'Your article has been unpublished');

        //Redirect to articles
        redirect('admin/pages');
    }


    /*
     * Delete Article
     *
     * @param - (int) $id
     */
    public function delete($id)
    {
        $this->pages_m->delete('pages',array('id'=>$id));

        //Create Message
        $this->session->set_flashdata('success', 'Your article has been deleted');

        //Redirect to articles
        redirect('admin/pages');
    }


    public function categories(){
        $data = array('categories' => $this->pages_m->get_categories('created'));
        $this->template->title('Page Categories')
            ->build('admin/categories',$data);
    }

    /**
     * add category
     */
    public function category_add(){
        if($post_data = $this->input->post()){
            $this->form_validation->set_rules('name','Category Title','trim|required');
            $build_slug = true;
            if($post_data['slug'] !=''){
                $this->form_validation->set_rules('slug','Category Url','requied|alpha_dash|is_unique[categories.slug]');
                $build_slug = false;
            }

            if($this->form_validation->run() == false){
                message('error',validation_errors());
                redirect(current_url());
            }else{

                if($build_slug == true){
                    $config=array(
                        'field' => 'slug',
                        'title' => $post_data['name'],
                        'table' => 'categories'
                    );

                    $this->load->library('slug',$config);
                    $slug = $this->slug->create_slug($post_data['name']);
                }else{
                    $slug = $post_data['slug'];
                }

                $data = array(
                    'name'=>$post_data['name'],
                    'slug'=>$slug,
                    'description'=>$post_data['description'],
                    'parent'=>$post_data['parent'],
                    'created'=>date('Y-m-d H:i:s')
                );

                
                if($this->pages_m->insert('categories',$data)){
                    message('success','Record added successfully');
                    redirect('admin/pages/categories');
                }else{
                    message('error','Error adding record');
                    redirect(current_url());
                }

            }
        }
        $data=array('categories' => $this->pages_m->get_categories());
        $this->template->title('Add Categories')
            ->build('admin/category/add', $data);
    }

    /**
     * delete category
     */

     public function category_delete($id){
         if($this->pages_m->delete('categories',array('id'=>$id))){
             message('success','Record deleted successfully');
         }else{
             message('error','Error deleting record');
         }
         redirect('admin/pages/categories');
     }

     /**
      * edit category
      */

      public function category_edit($id){
            $data = $this->pages_m->get_category($id);
            
            if ($this->input->post()) {
                $post_data = $this->input->post();
                $this->form_validation->set_rules('name', 'Category Title', 'trim|required');
                $build_slug = true;

                if (($post_data['slug'] != '') && ($post_data['slug'] != $data->slug)) {
                    $this->form_validation->set_rules('slug', 'URL Slug', 'required|alpha_dash|is_unique[categories.slug]');
                    $build_slug = false;
                }

                if ($this->form_validation->run() == false) {
                    message('error', validation_errors());
                    redirect(current_url());
                } else {

                    

                    $data = array(
                        'name' => $post_data['name'],
                        'description' => $post_data['description'],
                        'parent' => $post_data['parent']
                    );

                    if ($build_slug == false) {
                        $slug = $post_data['slug'];
                        $data['slug'] = $slug;
                    }

                    $return = $this->pages_m->update('categories', $data, array('id'=>$id));

                    if($return){
                        message('success', 'Record updated successfully');
                        redirect('admin/pages/categories');
                    } else {
                        message('error', 'Error updating record');
                        redirect(current_url());
                    }

                }
            }
            $data->categories = $this->pages_m->get_categories();
            $this->template->title('Edit Category')
                            ->build('admin/category/edit',$data);
      }


      /**
       * setting page
       */
      public function setting(){
          if($_POST){
              $data = $this->input->post();
              $this->pages_m->delete('settings',array('name'=>'setting'));
              foreach($data as $key => $rec){
                  $record = array('name'=>'setting','code'=>$key,'value'=>$rec);
                $this->pages_m->insert('settings',$record);
              }
              
          }

          $settings = $this->pages_m->get_by('settings',array('name'=>'setting'));
          $settings = array_column($settings,'value','code');
          $this->template->title('Settings')
            ->build('admin/settings/index',array('settings'=>$settings));
      }
}
