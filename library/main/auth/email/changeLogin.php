<?php
namespace Genesis\library\main\auth\email;

use Genesis\library\main\appConfig;
class changeLogin extends \Genesis\library\main\email\templateEmail {
	function __construct($recipient, $link){
		$this->setSubject('Potwierdź zmianę adresu email');
		$this->addTo($recipient);
		$this->setFrom(appConfig::getConfig('email'), appConfig::getConfig('title'));
		$this->setReplace('{$siteName}', appConfig::getConfig('title'));
		$this->setReplace('{$userName}',  $recipient);
		$this->setReplace('{$link}', $link);
		$this->setReplace('{$siteEmail}', appConfig::getConfig('email'));
		$this->setTemplateView(BASE_PATH . '/view/EmailTemplate/Auth/changeLogin.html');
		$this->setLayoutView(BASE_PATH . '/view/EmailTemplate/Auth/layoutEmail.html');
		$this->setBodyText($this->getMessage());
	}
}