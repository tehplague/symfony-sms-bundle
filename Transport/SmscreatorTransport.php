<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

class SmscreatorTransport implements SmsTransportInterface, SmsPrepaidTransportInterface
{
	/**
	 * SOAP client used for querying information
	 * 
	 * @var \SoapClient
	 */
	private $informationClient = null;

	/**
	 * SOAP client used for sending messages
	 * 
	 * @var \SoapClient
	 */
	private $sendClient = null;

	private $username;

	public function __construct()
	{
		if (!extension_loaded('soap') || !class_exists('\SoapClient'))
		{
			throw new \Exception('PHP SOAP module not loaded');
		}

		$soapUrl = 'http://www.smscreator.de/gateway/Information.asmx?WSDL';
		$this->informationClient = new \SoapClient($soapUrl, array('exceptions' => true, 'trace' => true));

		if ($this->informationClient == null)
		{
			throw new \Exception('Could not instantiate SOAP client');
		}

		$soapUrl = 'http://www.smscreator.de/gateway/Send.asmx?WSDL';
		$this->sendClient = new \SoapClient($soapUrl, array('exceptions' => true, 'trace' => true));

		if ($this->sendClient == null)
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

	public function getName()
	{
		return 'SMSCreator (http://www.smscreator.de)';
	}

	public function sendSms(Sms $sms)
	{
		$recipient = $sms->getRecipient();
		$recipient = str_replace(array('-', ' '), '', $recipient);

		$message = mb_convert_encoding($sms->getMessage(), 'UTF-8', 'ISO-8859-1');
		
		$request = new \stdClass();
		$request->User = $this->username;
		$request->Password = $this->password;
		$request->Recipient = $recipient;
		$request->Sender = '';
		$request->SMSText = $message;
		$request->SmsTyp = 'Standard';
		$request->SendDate = '';

		return $this->sendClient->SendSimpleSMS($request);
	}

	public function getAccountBalance()
	{
		$request = new \stdClass();
		$request->User = $this->username;
		$request->Password = $this->password;

		$result = $this->informationClient->QueryAccountBalance($request);
		if (is_object($result))
			return $result->QueryAccountBalanceResult->Value;

		return NULL;
	}
}
