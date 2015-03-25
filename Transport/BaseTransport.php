<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

abstract class BaseTransport implements SmsTransportInterface
{
	private $username;
	private $password;

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
