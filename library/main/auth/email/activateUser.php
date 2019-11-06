<?php
namespace Genesis\library\main\auth\email;

use Genesis\library\main\appConfig;
class activateUser extends \Genesis\library\main\email\templateEmail {
	function __construct($recipient, $link){
		$this->setSubject('Aktywacja konta');
		$this->addTo($recipient);
		$this->setFrom(appConfig::getConfig('email'), appConfig::getConfig('title'));
		$this->setReplace('{$siteName}', appConfig::getConfig('title'));
		$this->setReplace('{$userName}',  $recipient);
		$this->setReplace('{$link}', $link);
		$this->setReplace('{$siteEmail}', appConfig::getConfig('email'));
		$this->setTemplateView(BASE_PATH . '/view/EmailTemplate/Auth/activateUser.html');
		$this->setLayoutView(BASE_PATH . '/view/EmailTemplate/Auth/layoutEmail.html');
		$this->setBodyText($this->getMessage());
	}
}