<?php
/**
 * Class to save Maildatas
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class Mail
{
	private $addressee;
	private $senderMail;
	private $senderName;
	private $cc;
	private $subject;
	private $body;
	private $reply;
	private $htmlMail;
	
	public function __construct($addressee, $subject, $body, $htmlMail = false)
	{
		$this->addressee = $addressee;
		$this->subject = $subject;
		$this->body = $body;
		$this->htmlMail = $htmlMail;
	}
	
	public function setAddressee($addressee)
	{
		$this->addressee = $addressee;
	}
	
	public function getAddressee()
	{
		return $this->addressee;
	}
	
	public function setSenderMail($senderMail)
	{
		$this->senderMail = $senderMail;
	}
	
	public function getSenderMail()
	{
		return $this->senderMail;
	}
	
	public function setSenderName($senderName)
	{
		$this->senderName = $senderName;
	}
	
	public function getSenderName()
	{
		return $this->senderName;
	}
	
	public function setCc($cc)
	{
		$this->cc = $cc;
	}
	
	public function getCc()
	{
		return $this->cc;
	}
	
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function setBody($body)
	{
		$this->body = $body;
	}
	
	public function getBody()
	{
		return $this->body;
	}
	
	public function setReply($reply)
	{
		$this->reply = $reply;
	}
	
	public function getReply()
	{
		return $this->reply;
	}
	
	public function setHtmlMail($htmlMail)
	{
		$this->htmlMail = $htmlMail;
	}
	
	public function isHtmlMail()
	{
		return $this->htmlMail;
	}
}