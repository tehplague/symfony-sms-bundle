symfony-sms-bundle
==================

Symfony2 bundle for supporting SMS

## Activate the bundle

In your AppKernel:
```
    new cspoo\SmsBundle\cspooSmsBundle(),

```

## Example of configuration

```
# config.yml
cspoo_sms:
    default_transport: winic
    transports:
        -
            name: winic
            type: winic
            username: foo
            password: bar

```

it's possible to disable sms delivery in test mode

```yaml
# config_test.yml

cspoo_sms:
    disable_delivery: true
```

## Usage in controller


```
        $smsSender = $this->container->get('sms');
        $sms = $smsSender->createSms($phone, $content);
        $smsSender->sendSms($sms);

```

## Adding your own provider

If you have a provider that needs a username/password
you can simply add it by doing these steps

### Create a Transport class

In the Transport folder add a classe MyOwnTransport.php and put in it


```php
<?php

namespace cspoo\SmsBundle\Transport;

use cspoo\SmsBundle\Model\Sms;

class WinicTransport extends BaseTransport
{

    public function getName()
    {
        return 'name of the provider';
    }

    public function sendSms(Sms $sms)
    {
        $id = urlencode($this->getUsername());
        $password = urlencode($this->getPassword());
        $to = urlencode($sms->getRecipient());
        $content = urlencode($sms->getMessage());

        // your provider specific code

        // return whatever you want
        return 42;
    }
}

```

### Add your Transport class in the SMS factory

In the `Services` folder you can edit `SmsFactory.php` to populate the `loadTransport` method with your new class

### Add your Transport name in the list of possible configuration parameter

In `DependencyInjection/Configuration.php` you can provider name in the list of possible entry
