<?php
namespace Genesis\library\main\email;

class email{
	protected $subject = '';
	protected $recipients = '';
	protected $message = '';
	protected $senderEmail = '';
	protected $senderCaption = '';
	protected $headers = 'From: %s <%s>'. "\r\n" . 'Reply-To: %s' . "\r\n" . 'MIME-Version: 1.0' . "\r\n". 'Content-Type: text/html; charset=UTF-8' . "\r\n" ;
	
	function addTo($to){
		if (empty($this->recipients))
			$this->recipients .= $to;
		else 
			$this->recipients .= ', ' . $to;
	}
	function setSubject($subject){
		$this->subject = $subject;
	}
	function setFrom($email, $caption = ''){
		$this->senderEmail = $email;
		$this->senderCaption = $caption;
	}
	function setBodyText($txt){
		$this->message = $txt;
	}
	function send(){
		$headers = sprintf($this->headers, $this->senderCaption, $this->senderEmail, $this->senderEmail);
		$result = mail($this->recipients, $this->subject, $this->message, $headers);
		return $result;
	}
}