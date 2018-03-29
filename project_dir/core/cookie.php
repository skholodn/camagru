<?php

class Cookie
{
    public static function setAdd($key, $value){
        $is = setcookie($key, $value, time()+100000000);
    }

    public static function delAdd($key){
        setcookie($key, '', time()-3600);   
    }

    public static function get($key){
        if (isset($_COOKIE[$key]))
            return $_COOKIE[$key];
        else
            return 0;
    }
}