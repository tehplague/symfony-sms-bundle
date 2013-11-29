<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

interface SmsTransportInterface
{
	public function sendSms(Sms $sms);
}
