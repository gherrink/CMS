<?php
class Message
{
	private $status;
	private $message;
	
	public function __construct($msg_code, $params=array())
	{
		$this->status = BsHtml::ALERT_COLOR_SUCCESS;
		$this->message = MsgPicker::msg()->getMessage($msg_code, $params);
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function getHead()
	{
		return BsHtml::bold(MsgPicker::msg()->getMessage('MSG_'.strtoupper($this->status)));
	}
}