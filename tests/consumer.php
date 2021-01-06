<?php
require_once 'vendor/autoload.php';

use PhpRabbitMQClient\Config;
use PhpRabbitMQClient\Client;
use PhpRabbitMQClient\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

$conf = new Config([
    'host' => '*****',
    'port' => 5672,
    'user' => 'admin',
    'password' => '123456',
    'vhost' => '/',
]);

$client = new Client($conf);


class Consumer extends ConsumerMessage
{
    public function __construct(string $exchange, $routingKey, string $queue)
    {
        parent::__construct($exchange, $routingKey, $queue);
    }

    public function consumeMessage($data, \PhpAmqpLib\Message\AMQPMessage $message): bool
    {
        print_r($data);

        return true;
    }
}

$consumer = new Consumer('liu-exchange', 'liu-routeking', 'liu-queue');
//$consumer->setNoACK(true);
//$consumer->isRequeue(false);
$client->consume($consumer);


