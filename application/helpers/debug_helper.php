<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 10/10/17
 * Time: 11:51 AM
 */
include APPPATH.'third_party/debug/ChromePhp.php';

function pcsinfo($args){
    ChromePhp::log($args);
}

function pcswarn($args){
    ChromePhp::warn($args);
}