<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 10/2/18
 * Time: 2:55 PM
 */

class Mupload{
    var $ci;

    function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('uploads/uploads_m','uploads_m',true);

    }

    function checkUploadFolder()
    {
        $foldername = FCPATH . 'uploads/';
        if (!file_exists($foldername)) {
            try{
                mkdir($foldername, 0777);
            }catch(Exception $e){
                echo $e->getMessage();
                exit;
            }
        }

        $thumbnail_folder = FCPATH . 'uploads/thumbnail/';
        if (!file_exists($thumbnail_folder)) {
            mkdir($thumbnail_folder, 0777);
        }
    }

    function do_upload(){
        $this->checkUploadFolder();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->ci->load->library('upload', $config);

        if (!$this->ci->upload->do_upload('file')) {
            $msg = $this->ci->upload->display_errors();
            return array('message' => $msg,'status' => 0);
            exit;
        } else {
            $response = $this->ci->upload->data();
            $filename = $response['file_name'];
            $this->resizeImage($filename);
            $gallery_id = $this->ci->uploads_m->insert('gallery',array('title' => $response['orig_name'], 'link'=> $filename));
            return array('gallery_id'=>$gallery_id,'message' => 'success','status'=> 1);
            exit;
        }
    }


    /**
     * Manage uploadImage
     *
     * @return Response
     */
    public function resizeImage($filename)
    {
        $source_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $filename;
        $target_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/thumbnail/';
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => true,
            'create_thumb' => true,
            'thumb_marker' => '',
            'width' => 300,
            'height' => 300
        );


        $this->ci->load->library('image_lib', $config_manip);
        if (!$this->ci->image_lib->resize()) {
            echo $this->ci->image_lib->display_errors();
        }


        $this->ci->image_lib->clear();
    }
}