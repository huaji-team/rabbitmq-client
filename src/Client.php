<?php
/**
 * Client.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpRabbitMQClient\Message\ConsumerMessage;
use PhpRabbitMQClient\Message\ExChangeType;
use PhpRabbitMQClient\Message\ProducerMessage;

class Client
{
    /**
     * @var Connection
     */
    private $connection;


    public function __construct(Config $config)
    {
        $this->connection = new Connection($config);
    }

    /**
     * @param ProducerMessage $producerMessage
     * @param bool $confirm
     * @param int $timeout
     * @return bool
     * @throws \Exception
     */
    public function produce(ProducerMessage $producerMessage, bool $confirm = false, int $timeout = 5)
    {
        $result = false;
        $message = new AMQPMessage($producerMessage->payload(), $producerMessage->getProperties());

        if ($confirm) {
            $channel = $this->connection->getConfirmChannel();
        } else {
            $channel = $this->connection->getChannel();
        }

        $channel->set_ack_handler(function () use (&$result) {
            $result = true;
        });
        $channel->basic_publish($message, $producerMessage->getExchange(), $producerMessage->getRoutingKey());
        $channel->wait_for_pending_acks_returns($timeout);

        $this->connection->close();

        return $confirm ? $result : true;
    }

    public function consume(ConsumerMessage $consumerMessage)
    {
        $this->declare($consumerMessage);
        $channel = $this->connection->getChannel();

        $channel->basic_consume(
            $consumerMessage->getQueue(),
            $consumerMessage->getConsumerTag(),
            false,
            $consumerMessage->isNoACK(),
            false,
            false,
            function (AMQPMessage $message) use ($consumerMessage) {
                $this->getCallback($consumerMessage, $message);
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    protected function getCallback(ConsumerMessage $consumerMessage, AMQPMessage $message)
    {
        $data = $consumerMessage->unserialize($message->getBody());
        /** @var AMQPChannel $channel */
        $channel = $message->delivery_info['channel'];
        $deliveryTag = $message->delivery_info['delivery_tag'];

        try {
            $result = $consumerMessage->consumeMessage($data, $message);

            if (!$consumerMessage->isNoACK() &&  $result) {
                $channel->basic_ack($deliveryTag);
            }

            if (!$consumerMessage->isNoACK() && (!$result)) {
                $channel->basic_nack($deliveryTag, false, true);
            }

        } catch (\Throwable $exception ) {
            if (!$consumerMessage->isNoACK()) {
                $channel->basic_reject($deliveryTag, $consumerMessage->isRequeue());
            }
        }
    }

    protected function declare(ConsumerMessage $consumerMessage)
    {
        $builder = $consumerMessage->getExchangeBuilder();
        $channel = $this->connection->getChannel();
        //交换机
        $channel->exchange_declare(
            $builder->getExchange(),
            $builder->getType(),
            $builder->isPassive(),
            $builder->isDurable(),
            $builder->isAutoDelete(),
            $builder->isInternal(),
            $builder->isNowait(),
            $builder->getArguments(),
            $builder->getTicket()
        );

        //队列
        $queueBuilder = $consumerMessage->getQueueBuilder();
        $channel->queue_declare(
            $queueBuilder->getQueue(),
            $queueBuilder->isPassive(),
            $queueBuilder->isDurable(),
            $queueBuilder->isExclusive(),
            $queueBuilder->isAutoDelete(),
            $queueBuilder->isNowait(),
            $queueBuilder->getArguments(),
            $queueBuilder->getTicket()
        );

        $routineKeys = (array) $consumerMessage->getRoutingKey();
        foreach ($routineKeys as $routingKey) {
            $channel->queue_bind($consumerMessage->getQueue(), $consumerMessage->getExchange(), $routingKey);
        }

        if (empty($routineKeys) && $consumerMessage->getType() === ExChangeType::FANOUT) {
            $channel->queue_bind($consumerMessage->getQueue(), $consumerMessage->getExchange());
        }

        if (is_array($qos = $consumerMessage->getQos())) {
            $size = $qos['prefetch_size'] ?? null;
            $count = $qos['prefetch_count'] ?? 1;
            $global = $qos['global'] ?? null;
            $channel->basic_qos($size, $count, $global);
        }

    }
}