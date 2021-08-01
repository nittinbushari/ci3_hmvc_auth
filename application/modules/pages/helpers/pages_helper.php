<?php
/**
 * Created by PhpStorm.
 * User: pramod
 * Date: 9/6/18
 * Time: 4:33 PM
 */


function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}


function is_unique($str, $field)
{
    $ci = &get_instance();

    $table='articles';
    sscanf($field, '%[^.].%[^.]', $table, $field);
    return isset($ci->db)
        ? ($ci->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
        : FALSE;
}


function create_slug($slug)
{
    do{
        $unique=true;

        if(!is_unique($slug,'articles.slug')){
            $unique=FALSE;
            $random=rand(1000, 100000);
            $slug=$slug.'_'.$random;
        }

    }while(!$unique);

    return $slug;
}


