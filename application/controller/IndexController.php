<?php

class IndexController extends Controller {
		
	function init() {
		
	}
	
	function indexAction() {
		// Jeśli wysłano formularz sprawdż czy login i hasło są prawidłowe
		if (count($_POST)) {
			if (library_include_auth::login($_POST['login'], $_POST['pass']))
				application::redirect('/main'); 
			else
				$this->view->render('Index/badlogin.php');
		}
	}
 	
}