<?php
namespace Mindweb\RabbitMQPersist;

use Mindweb\Persist as Adapter;
use Mindweb\Persist\Event\PersistEvent;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Persist extends Adapter\Persist
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @param PersistEvent $persistEvent
     */
    public function persist(PersistEvent $persistEvent)
    {
        $this->getChannel()->basic_publish(
            new AMQPMessage(
                json_encode($persistEvent->getAttribution())
            ),
            $this->configuration['exchange'],
            $this->configuration['routingKey']
        );

        $persistEvent->addPersistResult(
            'rabbitmq',
            true
        );
    }

    /**
     * @return null|ConfigurationInterface
     */
    public function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * @param array $configuration
     */
    public function initialize(array $configuration = array())
    {
        $this->configuration = $configuration;
    }

    /**
     * @return AMQPChannel
     */
    private function getChannel()
    {
        $connection = new AMQPStreamConnection(
            $this->configuration['host'],
            $this->configuration['port'],
            $this->configuration['user'],
            $this->configuration['password'],
            $this->configuration['vhost'],
            $this->configuration['insist'],
            $this->configuration['login_method'],
            $this->configuration['login_response'],
            $this->configuration['connection_timeout'],
            $this->configuration['read_write_timeout']
        );

        return $connection->channel();
    }
}