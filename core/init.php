<?php
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'trabalho_tcc'
	),
	
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);
//require_once 'classes/Config.php';
spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';
});

require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	echo "<script>alert('user asked to be remebered')</script>";
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('user_session', array('hash', '=', $hash));
	if($hashCheck->count2()){
		//echo 'Hash matches, log user in';
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}