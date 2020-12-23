<?php
/**
 * ExchangeBuilder.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Builder;

/**
 * Class ExchangeBuilder
 * @package PhpRabbitMQClient\Builder
 */
class ExchangeBuilder extends Builder
{
    protected $exchange;

    protected $type;

    protected $internal = false;

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
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
    public function getType(): string
    {
        return $this->type;
    }

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
     * @return bool
     */
    public function isInternal(): bool
    {
        return $this->internal;
    }

    /**
     * @param bool $internal
     * @return $this
     */
    public function setInternal(bool $internal): self
    {
        $this->internal = $internal;

        return $this;
    }
}