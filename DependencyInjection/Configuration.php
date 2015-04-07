<?php

namespace cspoo\SmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sms');

        $this->addServersSection($rootNode);

        return $treeBuilder;
    }

    private function addServersSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->booleanNode('disable_delivery')->defaultFalse()->end()
                ->scalarNode('default_transport')
                    ->isRequired()
                ->end()
                ->arrayNode('transports')
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('type')
                            ->validate()
                                ->ifNotInArray(array('smscreator', 'winic'))
                                ->thenInvalid('The %s type is not supported')
                            ->end()
                        ->end()
                        ->scalarNode('username')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('password')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
