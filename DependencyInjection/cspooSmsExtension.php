<?php

namespace cspoo\SmsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class cspooSmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $servers = array();
        foreach ($config['servers'] as $name => $server)
        {
        	$isDefaultServer = $config['default_server'] === $name;
        	$this->configureServer($name, $server, $container, $isDefaultServer);
        }
    }

    protected function configureServer($name, array $server, ContainerBuilder $container, $isDefaultServer = false)
    {
    	$container->setParameter(sprintf('sms.servers.%s.type', $name), $server['type']);
    	$container->setParameter(sprintf('sms.servers.%s.username', $name), $server['username']);
    	$container->setParameter(sprintf('sms.servers.%s.password', $name), $server['password']);
    }

    public function getAlias()
    {
        return 'cspoo_sms';
    }
}
