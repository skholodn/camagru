<?php

/*
 * For setting all configuration settings
 */

class Config
{
	const DB_HOST = 'localhost';
	const DB_NAME = 'camagru-db';
	const DB_USER = 'root';
	const DB_PASSWORD = '123321';
	const DB_SOCKET = "/Volumes/Storage/cache/skholodn/Library/Containers/MAMP/mysql/tmp/mysql.sock";
	const ROOT_URI = 'http://localhost:8100';
	const ROUTES = array(
			'registration/check' => 'registration/check',
			'registration/save' => 'registration/save',
			'registration/confirm/([a-zA-Z0-9_.@+-]+)/([a-zA-Z0-9]+)' => 'registration/confirm/$1/$2',
			'registration' => 'registration/register',
			'profile/check' => 'profile/check',
			'profile/upload' => 'profile/upload',
			'profile' => 'profile/change',
			'login/checkpass' => 'login/checkpass',
			'login/restore' => 'login/restore',
			'login/check' => 'login/check',
			'login/logout' => 'login/logout',
			'login' => 'login/enter',
			'photo/upload' => 'photo/upload',
			'photo/save' => 'photo/save',
			'photo' => 'photo/make',
			'gallery/filter' => 'gallery/filter',
			'gallery/like' => 'gallery/like',
			'gallery/delete' => 'gallery/delete',
			'gallery/comment' => 'gallery/comment', 
			'gallery/getcomment' => 'gallery/getcomment',
			'gallery/([0-9]+)' => 'gallery/view/$1',
			'gallery/image/([0-9]+)' => 'gallery/image/$1',
			'404' => 'error/error404',
			'' => 'gallery/viewall',
		);
}