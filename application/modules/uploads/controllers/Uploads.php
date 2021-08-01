<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Uploads extends Core_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('uploads_m');
    }

    function add() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
//        $config['max_width'] = 1024;
//        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            echo $this->upload->display_errors();
            exit;

            
        } else {
            $response = $this->upload->data();
            $filename = $response['file_name'];
            $gallery_id = $this->uploads_m->insert('gallery',array('title' => $response['orig_name'], 'link'=> $filename,'user_id'=>$this->session->userdata('user_id')));
            echo json_encode(array('gallery_id'=>$gallery_id));
            exit;
            
            
        }
    }
    
    public function fileUpload(){
        $data=$this->uploads_m->getAllImages();
        echo $this->load->view('fileUpload',$data, true);
        exit;
    }


    /*
     * Load css file for template
     * Can call css file in folder /assets/css/ with templatecss/filename.css
     */

    public function moduleCss($module, $file)
    {

        if (method_exists($this->router, 'fetch_module')) {
            if($module){
                $_module = $module;
            }else{
                $_module = $this->router->fetch_module();
            }
                
            $style = file_get_contents(MODULE_DIR . $_module . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $file);
            if (!$style) {
                header('HTTP/1.1 404 Not Found');
                return;
            }
            header("Content-type: text/css; charset: UTF-8");
            echo $style;
             exit;
        }
        
    }


    public function moduleJs($module,$file)
    {
       
        if (method_exists($this->router, 'fetch_module')) {
            if($module){
                $_module = $module;
            }else{
                $_module = $this->router->fetch_module();
            }

            $js = file_get_contents(MODULE_DIR . $_module . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . $file);
            if (!$js) {
                header('HTTP/1.1 404 Not Found');
                return;
            }

            header("Content-type: application/javascript; charset: UTF-8");
            echo $js;
            exit;
        }

        
    }

}
