<?php
namespace Mindweb\RabbitMQPersist;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rabbitmq_persist');

        $rootNode->children()
            ->scalarNode('host')
                ->defaultValue('localhost')
            ->end()
            ->scalarNode('port')
                ->defaultValue('5672')
            ->end()
            ->scalarNode('user')
                ->defaultValue('guest')
            ->end()
            ->scalarNode('password')
                ->defaultValue('guest')
            ->end()
            ->scalarNode('queue')
                ->defaultValue('preAnalytics')
            ->end()
            ->scalarNode('routingKey')
                ->defaultValue('routingKey')
            ->end()
        ->end();

        return $treeBuilder;
    }
}