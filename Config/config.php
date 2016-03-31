<?php

use MyMVC\Library\Config;

Config::set('siteName', 'Photo Album');

Config::set('sessionId', '_mymvc_sess_identi_');

Config::set('languages', ['bg', 'en']);

Config::set('routes', [
	'default' => '',
	'admin' => 'admin',
	'authent' => 'authent',
]);

// Default settings
Config::set('defaultLanguage', 'bg');

Config::set('defaultRoute', 'default');

Config::set('defaultController', 'Home');

Config::set('defaultAction', 'index');

// Database setings
Config::set('dbDrive', 'mysql');

Config::set('dbHost', 'localhost');

Config::set('dbUser', 'root');

Config::set('dbPass', '');

Config::set('dbName', 'photo_album_2');

Config::set('dbInstance', 'app');