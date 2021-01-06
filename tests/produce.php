<?php
/**
 * 1.php
 * @author   Liu Zhang
 */

require_once 'vendor/autoload.php';

use PhpRabbitMQClient\Config;
use PhpRabbitMQClient\Client;
use PhpRabbitMQClient\Message\ProducerMessage;

$conf = new Config([
    'host' => '*****',
    'port' => 5672,
    'user' => 'admin',
    'password' => '123456',
    'vhost' => '/',
]);

$client = new Client($conf);

$msg = new ProducerMessage(
    [
        'a' => 1,
        'b' => 2
    ],
    'liu-exchange',
    'liu-routeking'
);

$client->produce($msg);

