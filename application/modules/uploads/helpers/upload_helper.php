<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 10/1/18
 * Time: 4:59 PM
 */

if(!function_exists('getFileDetail')){
    function getFileUrl($id){
        $ci = &get_instance();
        $ci->load->model('uploads/uploads_m','uploads_m',true);
        $response = $ci->uploads_m->getOne('gallery', array('id'=>$id));
        return base_url().'uploads/'.$response['link'];
    }
}