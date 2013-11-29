<?php

namespace cspoo\SmsBundle\Model;

class Sms
{
	private $recipient;

	private $message;

	public function setRecipient($recipient)
	{
		$this->recipient = $recipient;
	}

	public function getRecipient()
	{
		return $this->recipient;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}
}
