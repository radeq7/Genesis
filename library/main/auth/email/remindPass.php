<?php
namespace Genesis\library\main\auth\email;

use Genesis\library\main\appConfig;
class remindPass extends \Genesis\library\main\email\templateEmail {
	function __construct($recipient, $link){
		$this->setSubject('Przypomnij hasło');
		$this->addTo($recipient);
		$this->setFrom('system@genix3.com', 'Genix3');
		$this->setReplace('{$siteName}', appConfig::getConfig('title'));
		$this->setReplace('{$userName}',  $recipient);
		$this->setReplace('{$link}', $link);
		$this->setReplace('{$siteEmail}', appConfig::getConfig('email'));
		$this->setTemplateView(BASE_PATH . '/view/EmailTemplate/Auth/remindPass.html');
		$this->setLayoutView(BASE_PATH . '/view/EmailTemplate/Auth/layoutEmail.html');
		$this->setBodyText($this->getMessage());
	}
}