<?php

namespace cspoo\SmsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use cspoo\SmsBundle\Transport;
use cspoo\SmsBundle\Services\SmsFactory;

class cspooSmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $extensionConfig = $this->processConfiguration($configuration, $configs);

        $transports = array();
        foreach ($extensionConfig['transports'] as $name => $config)
        {
        	$isDefaultTransport = $extensionConfig['default_transport'] === $name;
        	$this->configureTransport($name, $config, $container, $isDefaultTransport);
        }

        $container->setParameter('sms.transports', $transports);
        $container->setParameter('sms.default_transport', $extensionConfig['default_transport']);
    }

    protected function configureTransport($name, array $config, ContainerBuilder $container, $isDefaultTransport = false)
    {
    	$container->setParameter(sprintf('sms.transports.%s.type', $name), $config['type']);
    	$container->setParameter(sprintf('sms.transports.%s.username', $name), $config['username']);
    	$container->setParameter(sprintf('sms.transports.%s.password', $name), $config['password']);
    }

    public function getAlias()
    {
        return 'cspoo_sms';
    }
}
