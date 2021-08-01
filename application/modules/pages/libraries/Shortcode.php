<?php 

class Shortcode{
	var $ci;
	function __construct(){
		$this->ci = &get_instance();
	}

	public function run($body){
        
        preg_match_all("#\[[^\]]*\]#",$body,$shortcodes, PREG_PATTERN_ORDER);
        foreach($shortcodes[0] as $shortcode){
            $scode = $shortcode;
            $content = $this->process($shortcode);
            $body = str_replace($scode,$content,$body);
        }

        return $body;
    }

    /**
     * do shortcode
     */
    
     // public function process($shortcode){
    //     $scode = $shortcode;
    //     $shortcode = str_replace('[','',$shortcode);
    //     $shortcode = str_replace(']','',$shortcode);

    //     $extract = explode(' ',$shortcode);

    //     $module = $extract[0];
    //     if($extract[1]){
    //         $arg = explode('=',$extract[1]);
    //         $fnc = $arg[0];
    //         if($arg[1]){
    //             $args = $arg[1];
            
    //             $args = str_replace('"','',$args);
    //             $args = str_replace("'","",$args);

    //             //variable passed to shortcode function
    //             $this->ci->vars->set('scode_args',$args);
    //         }
    //     }else{
    //         $fnc = "index";
    //     }
        
        
        
    //     ob_start();
    //     apply_hook($module.'_'.$fnc);
    //     $content = ob_get_contents();
    //     ob_end_clean();
    //     return $content;
    // }


    public function process($shortcode){
        $scode = $shortcode;
        $shortcode = substr($shortcode, 1, -1);
        $shortcode = str_replace('&nbsp;',' ',$shortcode);
        $extract = explode(" ",$shortcode);
        $args = array();
        $i = 0;
        
        foreach($extract as $ext){
            if($i == 0){
                $module = $ext;
            }elseif($i== 1){
                $fnc = $ext;
            }else{
                $arg = explode('=',$ext);
                $key = $arg[0];
                $val = $arg[1];
                
                if($val){
                    $tmpval = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($val))))));
                    
                    //preg_match_all('!\d+!', $val, $matches);
                    //$tmpval = $matches[0][0];

                    //variable passed to shortcode function
                    // $this->ci->vars->set($fnc,$args);
                }
                

                if(!is_numeric($tmpval)){
                    $tmpval = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($val))))));
                }

                $args[$key] = $tmpval;
                
                
            }

            $i++;
        }

        ob_start();

        Modules::load($module)->$fnc($args);
        
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}