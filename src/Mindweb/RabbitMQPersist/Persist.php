<?php
namespace Mindweb\RabbitMQPersist;

use Mindweb\Persist as Adapter;
use Mindweb\Persist\Event\PersistEvent;

use PhpAmqpLib\Connection\AMQPConnection;
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
        $connection = new AMQPConnection(
            $this->configuration['host'],
            $this->configuration['port'],
            $this->configuration['user'],
            $this->configuration['password']
        );
        $channel = $connection->channel();

        $channel->queue_declare(
            $this->configuration['queue'],
            false,
            false,
            false,
            false
        );

        $msg = new AMQPMessage(json_encode($persistEvent->getAttribution()));
        $channel->basic_publish($msg, '', $this->configuration['routingKey']);

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
}