<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

class WinicTransport implements SmsTransportInterface
{

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
        return 'Winic.org (Chinese provider)';
    }

    public function sendSms(Sms $sms)
    {
        $id = urlencode($this->username);
        $password = urlencode($this->password);
        $to = urlencode($sms->getRecipient);
        $content = urlencode($sms->getContent());

        $rquestUrl = sprintf(
            "http://service.winic.org/sys_port/gateway/?id=%s&pwd=%s&to=%s&content=%s&time=",
            $id,
            $pwd,
            $to,
            $content
        );
        $returnedData = file($rurl);
        return $returnedData;
    }
}
