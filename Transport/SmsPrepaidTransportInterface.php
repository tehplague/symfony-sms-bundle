<?php

namespace cspoo\SmsBundle\Transport;

interface SmsPrepaidTransportInterface
{
	public function getAccountBalance();
}
