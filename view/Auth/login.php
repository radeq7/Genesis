<?php
use Genesis\library\main\auth\auth;
?>
Logowanie
<form method="post">
	<input type="text" value="" placeholder="Email" name="login" size="20" />
	<br>
	<input type="text" value="" placeholder="Hasło" name="pass" size="20" />
	<br>
	<input type="submit" value="Zaloguj" />
</form>
<a href="<?php echo $this->auth->generateRemindLink()?>">Nie pamiętam hasła</a> 