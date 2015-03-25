<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

class WinicTransport extends BaseTransport
{

    public function getName()
    {
        return 'Winic.org (Chinese provider)';
    }

    public function sendSms(Sms $sms)
    {
        $id = urlencode($this->getUsername());
        $password = urlencode($this->getPassword());
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
