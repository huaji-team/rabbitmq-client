<?php
/**
 * ConsumerMessage.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Message;

use PhpAmqpLib\Message\AMQPMessage;
use PhpRabbitMQClient\Builder\QueueBuilder;

/**
 * Class ConsumerMessage
 * @package PhpRabbitMQClient\Message
 */
abstract class ConsumerMessage extends Message
{
    /**
     * @var string
     */
    protected $queue;

    /**
     * @var bool
     */
    protected $requeue = true;

    /**
     * @var array
     */
    protected $routingKey = [];

    /**
     * @var null|array
     */
    protected $qos;

    /**
     * @var bool
     */
    protected $enable = true;

    /**
     * @var string
     */
    protected $consumerTag = '';

    /**
     * @var float|int
     */
    protected $waitTimeout = 0;

    /**
     * @var bool
     */
    protected $noACK = false;

    /**
     * @return bool
     */
    public function isNoACK(): bool
    {
        return $this->noACK;
    }

    /**
     * @param bool $noACK
     */
    public function setNoACK(bool $noACK): void
    {
        $this->noACK = $noACK;
    }


    public function __construct(string $exchange, $routingKey, string $queue)
    {
        $this->setExchange($exchange)->setRoutingKey($routingKey)->setQueue($queue);
    }

    public abstract function consumeMessage($data, AMQPMessage $message): bool;

    public function setQueue(string $queue): self
    {
        $this->queue = $queue;
        return $this;
    }

    public function getQueue(): string
    {
        return $this->queue;
    }

    public function isRequeue(): bool
    {
        return $this->requeue;
    }

    public function getQos(): ?array
    {
        return $this->qos;
    }

    public function getQueueBuilder(): QueueBuilder
    {
        return (new QueueBuilder())->setQueue($this->getQueue());
    }

    public function unserialize(string $data)
    {
        return unserialize($data);
    }

    public function getConsumerTag(): string
    {
        return $this->consumerTag;
    }

    public function setConsumerTag(string $value)
    {
        $this->consumerTag = $value;

        return $this;
    }

    public function isEnable(): bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getWaitTimeout()
    {
        return $this->waitTimeout;
    }

    public function setWaitTimeout($timeout)
    {
        $this->waitTimeout = $timeout;

        return $this;
    }
}