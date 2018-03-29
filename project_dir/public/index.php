<?php

//require '../vendor/autoload.php';

// errors settings
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('session.cookie_httponly', 1);
error_reporting(E_ALL);

// timezone settings
date_default_timezone_set('Europe/Kiev');

// setting ROOT directory

define('ROOT', __DIR__.DIRECTORY_SEPARATOR);

// loading files

spl_autoload_register(function ($class) {
	$core = ROOT . '../core/' . strtolower($class) . '.php';
	$controllers = ROOT . '../app/controllers/' . $class . '.php';
	$models = ROOT . '../app/models/' . $class . '.php';
	$views = ROOT . '../app/views/' . $class . '.php';
	if (file_exists($core))
		include $core;
	elseif (file_exists($controllers))
		include $controllers;
	elseif (file_exists($models))
		include $models;
	elseif (file_exists($views))
		include $views;
});

include ROOT . '../app/config.php';

// FRONT Controller
//session_start();

// Установка соединение с БД


// вызов ROUTER
$router = new Router();
$router->run();

 //~r($_SESSION);