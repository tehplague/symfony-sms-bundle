<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

class SmscreatorTransport implements SmsTransportInterface
{
	/**
	 * SOAP client
	 * 
	 * @var \SoapClient
	 */
	private $client = null;

	private $username;

	public function __construct()
	{
		if (!extension_loaded('soap') || !class_exists('\SoapClient'))
		{
			throw new \Exception('PHP SOAP module not loaded');
		}

		$soapUrl = 'http://soap.smscreator.de/send.asmx?WSDL';
		$this->client = new \SoapClient($soapUrl);

		if ($this->client == null)
		{
			throw new \Exception('Could not instantiate SOAP client');
		}
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function sendSms(Sms $sms)
	{
		$recipient = $sms->getRecipient();
		$recipient = str_replace(array('-', ' '), '', $recipient);

		$message = mb_convert_encoding($sms->getMessage(), 'UTF-8', 'ISO-8859-1');
		
		return $this->client->SendSimpleSMS(
			$this->username,
			$this->password,
			$recipient,
			$message
		);
	}
}
