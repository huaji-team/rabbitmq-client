# 说明

RabbitMQ 是一个很常用的消息中间件，但是官方提供客户端比较难用，好理解使用方便为目的，再次封装一下。

# 安装


# 生产消息

```php
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

```
默认的交换机的是 主题型的可以通过 


```php
  $msg->getExchangeBuilder()
```
获取交换机类进行设置。


# 消费消息

```php
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

```

首先要 创建一个 消费的类继承 ConsumerMessage类， consumeMessage方法就是写回调的逻辑。

默认 NoACK 是 false ，可以通过 $consumer->setNoACK(true); 设置不需要确认。 

消息需要确认时候，回调里面 要return true 表示处理成功， retrun false   表示消费失败，会重新放到队列。 当抛出异常时候， 会根据是否方法队列就行判断，默认是放回队列，可以通过 $consumer->isRequeue(false) 就行设置，是放回队列还是丢弃。
