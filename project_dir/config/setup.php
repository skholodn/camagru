<?php 

require_once('../app/config.php');

$sql = file_get_contents('camagru-db.sql');

try {
	$dsn1 = "mysql:host=" .Config::DB_HOST.';unix_socket='.Config::DB_SOCKET;
	$db1 = new PDO($dsn1, Config::DB_USER, Config::DB_PASSWORD);
	$db1->query('DROP TABLE IF EXISTS `camagru-db`.`likes`;
		DROP TABLE IF EXISTS `camagru-db`.`comments`;
		DROP TABLE IF EXISTS `camagru-db`.`photos`;
		DROP TABLE IF EXISTS `camagru-db`.`users`;
		DROP DATABASE IF EXISTS `camagru-db`;
		CREATE DATABASE IF NOT EXISTS `camagru-db`;');
	try {
		$dsn2 = "mysql:host=" .Config::DB_HOST.';unix_socket='.Config::DB_SOCKET.';dbname='.Config::DB_NAME;
		$db2 = new PDO($dsn2, Config::DB_USER, Config::DB_PASSWORD);
		$res = $db2->query($sql);	
	} catch (Exception $e) {
		echo "Error 2 => ".$e->getMessage();
		exit();	
	}	
} catch (PDOException $e) {
	echo "Error 1 => ".$e->getMessage();
	exit();
}
echo "DB installed properly!";