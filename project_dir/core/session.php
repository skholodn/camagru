<?php

class Session
{
    public static function start(){
        if (session_id() == '') {
            session_start();
        }
    }

    public static function setAdd($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function unsetFilter()
    {
        unset($_SESSION['login_filter']);   
    }

    public static function unsetUser(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
    }

    public static function isLoggedOnUser(){
        if (self::get('user_id') && self::get('user_name')){
            return true;
        }
        return false;
    }
}