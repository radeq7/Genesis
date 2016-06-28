<?php
namespace Genesis\library\main\auth;

class userValidate{
	/**
	 * Sprawdzenie czy nazwa login spełnia wymagania i czy się nie powtarza w bazie danych
	 */
	function checkLogin(string $login) : bool{
		if ( filter_var($login, FILTER_VALIDATE_EMAIL) )
			return TRUE;
		return FALSE;
	}
	/**
	 * Sprawdzenie czy pass spełnia wymagania
	 */
	function checkPass(string $pass) : bool{
		if ( preg_match('/(?=^.{6,20}$)(?=.*\d)(?=.*[A-Za-z]).*$/', $pass) ) // od 6 do 20 znaków, minimum jedna cyfra, jedna duża litera i jedna mała
			return TRUE;
		return FALSE;
	}
}