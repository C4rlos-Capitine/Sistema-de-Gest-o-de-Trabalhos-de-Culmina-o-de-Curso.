<?php

class Hash{
	public static function make($string, $salt = ''){
		return hash('sha256', $string . $salt);
		// 'PASSWORD_DEFAULT' escolhe o algoritmo mais seguro disponível
		//return password_hash($string, PASSWORD_DEFAULT);
	}

	public static function verify($string, $hash) {
        return password_verify($string, $hash);
    }

	public static function salt($length){
		//return mcrypt_create_iv($length);
		return bin2hex(random_bytes($length));
	}
/*
	public static function salt() {
		return bin2hex(random_bytes($length));
	}
	*/
	public static function unique(){
		return self::make(uniqid());
	}
}