<?php
/**
 * QueueBuilder.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Builder;

/**
 * Class QueueBuilder
 * @package PhpRabbitMQClient\Builder
 */
class QueueBuilder extends Builder
{
    protected $queue;

    protected $exclusive = false;

    protected $arguments = [
        'x-ha-policy' => ['S', 'all'],
    ];

    /**
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * @param string $queue
     * @return $this
     */
    public function setQueue(string $queue): self
    {
        $this->queue = $queue;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExclusive(): bool
    {
        return $this->exclusive;
    }

    /**
     * @param bool $exclusive
     * @return $this
     */
    public function setExclusive(bool $exclusive): self
    {
        $this->exclusive = $exclusive;
        return $this;
    }
}