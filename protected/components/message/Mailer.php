<?php
/**
 * This class sends Mails
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class Mailer extends CApplicationComponent
{
	
	public $sendMail = true;
	public $defaultMail = 'default@example.com';
	public $defaultName = 'defaultname';
	public $contactAddress = 'contact@example.com';
	public $registerName = 'Registrierung';
	public $registerMail = 'register@example.com';
	
	const HTML = '
<html>
	<head>
		<title>###title###</title>
	</head>
	<body>
		###body###
	</body>
</html>';
	
	/**
	 * Sends a Register Mail
	 * @param User $user
	 */
	public function sendRegisterMail(User $user, UserValidate $validate)
	{
		$subject = MsgPicker::msg()->getMessage(MSG::MAIL_SUBJECT_REGISTER);
		$body = MsgPicker::msg()->getMessage(MSG::MAIL_BODY_REGISTER, array(
			'name'=>$user->userid,
			'link'=>Yii::app()->createAbsoluteUrl('login/userValidate', array('user'=>$user->userid, 'key'=>$validate->validateid)),
		));
		$mail = new Mail($user->mail, $subject, $body, true);
		$mail->setSenderMail($this->registerMail);
		$mail->setSenderName($this->registerName);
		return $this->sendMail($mail);
	}
	
	/**
	 * Sends a Contact Mail
	 * @param ContactForm $contact
	 * @return boolean
	 */
	public function sendContactMail(ContactForm $contact)
	{
		$mail = new Mail($this->contactAddress, $contact->subject, $contact->body);
		$mail->setSenderMail($contact->mail);
		$mail->setSenderName($contact->name);
		return $this->sendMail($mail);
	}
	
	/**
	 * Sends a Mail
	 * @param Mail $mail
	 * @return boolean
	 */
	public function sendMail(Mail $mail)
	{
		if(! $this->sendMail)
			return true;
		
		if($mail->getSenderMail() === null || $mail->getSenderMail() === '')
			$mail->setSenderMail($this->defaultMail);
		
		if($mail->getSenderName() === null || $mail->getSenderName() === '')
			$mail->setSenderName($this->defaultName);
		
		if($mail->isHtmlMail())
			return $this->sendHtmlMail($mail);
		else
			return $this->sendTextMail($mail);
	}
	
	/**
	 * Sendes a Text-Mail
	 * @param Mail $mail
	 * @return boolean
	 */
	private function sendTextMail(Mail $mail)
	{
		$name='=?UTF-8?B?'.base64_encode($mail->getSenderName()).'?=';
		$subject='=?UTF-8?B?'.base64_encode($mail->getSubject()).'?=';
		$header="From: $name <{$mail->getSenderMail()}>\r\n";
	
		if($mail->getReply() !== null && $mail->getReply() !== '')
			$header.="Reply-To: {$mail->getReply()}\r\n";
		else
			$header.="Reply-To: {$mail->getSenderMail()}\r\n";
	
		if($mail->getCc() !== null && $mail->getCc() !== '')
			$header.="Cc: {$mail->getCc()}\r\n";
	
		$header.="MIME-Version: 1.0\r\n".
				"Content-Type: text/plain; charset=UTF-8";
	
		return mail($to ,$subject,$body,$header);
	}
	
	/**
	 * Sends a Html-Mail
	 * @param Mail $mail
	 * @return boolean
	 */
	private function sendHtmlMail(Mail $mail)
	{
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$header .= "From: ".$mail->getSenderName()." <".$mail->getSenderMail().">\r\n";
	
		if($mail->getReply() !== null && $mail->getReply() !== '')
			$header .= "Reply-To: ".$mail->getReply()."\r\n";
		else
			$header .= "Reply-To: ".$mail->getSenderMail()."\r\n";
	
		if($mail->getCc() !== null && $mail->getCc() !== '')
			$header .= "Cc: ".$mail->getCc()."\r\n";
	
		$header .= "X-Mailer: PHP ". phpversion();
	
		return mail($toMail, $subject, $body, $header);
	}
}