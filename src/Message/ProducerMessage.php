<?php
/**
 * ProducerMessage.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Message;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ProducerMessage
 * @package PhpRabbitMQClient\Message
 */
class ProducerMessage extends Message
{
    /**
     * @var string
     */
    protected $payload = '';

    /**
     * @var string
     */
    protected $routingKey = '';

    /**
     * @var array
     */
    protected $properties
        = [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ];

    /**
     * ProducerMessage constructor.
     * @param $data
     * @param string $exchange
     * @param string $routingKey
     */
    public function __construct($data, string $exchange, string $routingKey)
    {
        $this->setPayload($data)->setExchange($exchange)->setRoutingKey($routingKey)->setMessageId();
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return serialize($this->payload);
    }

    public function setPayload($data): self
    {
        $this->payload = $data;

        return $this;
    }

    public function setProperties(string $key, $value):self
    {
        $this->properties[$key] = $value;

        return  $this;
    }

    /**
     * @return $this
     */
    private function setMessageId():self
    {
        $id = base_convert(floor(microtime(true) * 1000000), 10, 36).mt_rand(10, 99);

        $this->setProperties('message_id', $id);

        return $this;
    }
}