<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 404 Override
 *
 */
class MY_Exceptions extends CI_Exceptions {
    public function __construct(){
        parent::__construct();
    }

    function show_404(){
        log_message('error','Page not found: '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
        $code = '404';
        $text = 'Page not found';

        $server_protocol = (isset($_SERVER['SERVER_PROTOCOL'])) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;

        if (substr(php_sapi_name(), 0, 3) == 'cgi'){
            header("Status: {$code} {$text}", TRUE);
        } elseif ($server_protocol == 'HTTP/1.1' OR $server_protocol == 'HTTP/1.0'){
            header($server_protocol." {$code} {$text}", TRUE, $code);
        } else{
            header("HTTP/1.1 {$code} {$text}", TRUE, $code);
        }
        
        //no guarantees CI core will be loaded when error occurs; sense current environment
        $domain = $_SERVER['SERVER_NAME'];
        if(ENVIRONMENT == 'development') { //dev
            $domain = $_SERVER['SERVER_NAME'].'/~cropyld';
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://'.$domain.'/main/error');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        if(!session_id()){
            session_start();
        }
        $strCookie = session_name()."=".session_id()."; path=".session_save_path();
        session_write_close();
        curl_setopt( $ch, CURLOPT_COOKIE, $strCookie );
        curl_exec($ch);
        curl_close($ch);
    }
}