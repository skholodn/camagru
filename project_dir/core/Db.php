<?php


abstract class Db
{
    private static $instance = null;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance(){
        if (!isset(self::$instance)){
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME, Config::DB_USER,
                Config::DB_PASSWORD, $pdo_options);
        }
       return self::$instance;
    }
}