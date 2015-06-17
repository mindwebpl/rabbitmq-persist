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
                ->scalarNode('vhost')
                    ->defaultValue('/')
                ->end()
                ->booleanNode('insist')
                    ->defaultFalse()
                ->end()
                ->scalarNode('login_method')
                    ->defaultValue('AMQPLAIN')
                ->end()
                ->scalarNode('login_response')
                    ->defaultValue(null)
                ->end()
                ->scalarNode('locale')
                    ->defaultValue('en_US')
                ->end()
                ->floatNode('connection_timeout')
                    ->defaultValue(3)
                ->end()
                ->floatNode('read_write_timeout')
                    ->defaultValue(3)
                ->end()
                ->scalarNode('exchange')
                    ->defaultValue('analytics')
                ->end()
                ->scalarNode('routingKey')
                    ->defaultValue('actions')
                ->end()
            ->end();

        return $treeBuilder;
    }
}