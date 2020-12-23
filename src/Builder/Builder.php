<?php
/**
 * Builder.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Builder;

use PhpAmqpLib\Wire\AMQPTable;

/**
 * Class Builder
 * @package PhpRabbitMQClient\Builder
 */
class Builder
{
    /**
     * @var bool
     */
    protected $passive = false;

    /**
     * @var bool
     */
    protected $durable = true;

    /**
     * @var bool
     */
    protected $autoDelete = false;

    /**
     * @var bool
     */
    protected $nowait = false;

    /**
     * @var AMQPTable|array
     */
    protected $arguments = [];

    /**
     * @var null|int
     */
    protected $ticket;

    /**
     * @return bool
     */
    public function isPassive(): bool
    {
        return $this->passive;
    }

    /**
     * @param bool $passive
     * @return $this
     */
    public function setPassive(bool $passive): self
    {
        $this->passive = $passive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDurable(): bool
    {
        return $this->durable;
    }

    /**
     * @param bool $durable
     * @return $this
     */
    public function setDurable(bool $durable): self
    {
        $this->durable = $durable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoDelete(): bool
    {
        return $this->autoDelete;
    }

    /**
     * @param bool $autoDelete
     * @return $this
     */
    public function setAutoDelete(bool $autoDelete): self
    {
        $this->autoDelete = $autoDelete;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNowait(): bool
    {
        return $this->nowait;
    }

    /**
     * @param bool $nowait
     * @return $this
     */
    public function setNowait(bool $nowait): self
    {
        $this->nowait = $nowait;

        return $this;
    }

    /**
     * @return array|AMQPTable
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function setArguments($arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param null|int $ticket
     * @return static
     */
    public function setTicket($ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}