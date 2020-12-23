<?php
/**
 * Message.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Message;

use PhpRabbitMQClient\Builder\ExchangeBuilder;

/**
 * Class Message
 * @package PhpRabbitMQClient\Message
 */
abstract class Message
{
    /**
     * @var string
     */
    protected $exchange = '';

    /**
     * @var string
     */
    protected $type = ExChangeType::TOPIC;

    /**
     * @var array|string
     */
    protected $routingKey = '';

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $exchange
     * @return $this
     */
    public function setExchange(string $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @param $routingKey
     * @return $this
     */
    public function setRoutingKey($routingKey): self
    {
        $this->routingKey = $routingKey;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getRoutingKey()
    {
        return $this->routingKey;
    }

    /**
     * @return ExchangeBuilder
     */
    public function getExchangeBuilder(): ExchangeBuilder
    {
        return (new ExchangeBuilder())->setExchange($this->getExchange())->setType($this->getType());
    }
}