<?php
namespace Genesis\library\main\auth;

class userValidate{
	/**
	 * Sprawdzenie czy nazwa login spełnia wymagania i czy się nie powtarza w bazie danych
	 */
	function checkLogin(string $login) : bool{
		return TRUE;
	}
	/**
	 * Sprawdzenie czy pass spełnia wymagania
	 */
	function checkPass(string $pass) : bool{
		return TRUE;
	}
}