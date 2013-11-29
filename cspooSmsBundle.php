<?php

namespace cspoo\SmsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\Compiler\RegisterPluginsPass;

class cspooSmsBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
	}
}
