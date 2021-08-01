<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input 
{
        public function __construct($rules = array())
        {
                parent::__construct($rules);
        }

        public function ip_address()
        {
		// If apache_request_headers exists, use header to retrieve ip.
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
			if (array_key_exists('X-Forwarded-For', $headers)) {
				if (filter_var( $headers['X-Forwarded-For'],
					FILTER_VALIDATE_IP,
					FILTER_FLAG_IPV4 )) {
					return $headers['X-Forwarded-For'];
				} else {
					$tokens = explode(",", $headers['X-Forwarded-For']);
					foreach ($tokens as $token) {
						$token = trim($token);
						if (filter_var( $token,
							FILTER_VALIDATE_IP,
							FILTER_FLAG_IPV4 ) && !isPrivateIp($token)) {
							return $token;
						}
					}
				}
			}
		}
	
		// Otherwise, use the SERVER global.
		$keys = array(
				'HTTP_CLIENT_IP',
				'HTTP_X_FORWARDED_FOR',
				'HTTP_X_FORWARDED',
				'HTTP_X_CLUSTER_CLIENT_IP',
				'HTTP_FORWARDED_FOR',
				'HTTP_FORWARDED',
				'REMOTE_ADDR');
	
	    foreach ($keys as $key){
	        if (array_key_exists($key, $_SERVER)){
	            foreach (explode(',', $_SERVER[$key]) as $ip){
	                $ip = trim($ip);
	                if (filter_var($ip, FILTER_VALIDATE_IP,
	                    FILTER_FLAG_NO_PRIV_RANGE |
	                    FILTER_FLAG_NO_RES_RANGE) !== false){
	                    return $ip;
	                }
	            }
	        }
	    }
	    // No valid IP is detected. We are going to return empty string.
	    return parent::ip_address();
        }
}