<?php
/**
 * Client.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{
    /**
     * @var Config
     */
    private $config;

    /**
     * RabbitMQ连接
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * Client constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->connection = $this->initConnection();
    }

    /**
     * 获取连接
     * @return AMQPStreamConnection
     */
    public function getConn()
    {
        if ($this->connection && $this->connection->isConnected()) {
            return $this->connection;
        }

        return  $this->initConnection();
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getConfirmChannel()
    {
        $channel = $this->getChannel();
        $channel->confirm_select();

        return $channel;
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel()
    {
        return $this->getConn()->channel();
    }

    /**
     * 初始化链接
     * @return AMQPStreamConnection
     */
    private function initConnection()
    {
        $insist = false;
        $login_method = 'AMQPLAIN';
        $login_response = null;
        $locale = 'en_US';
        $context = null;

        return new AMQPStreamConnection(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getUser(),
            $this->config->getPassword(),
            $this->config->getVhost(),
            $insist,
            $login_method,
            $login_response,
            $locale,
            $this->config->getConnectTimeout(),
            $this->config->getReadWriteTimeout(),
            $context,
            $this->config->isKeepalive(),
            $this->config->getHeartbeat()
        );
    }

    /**
     * 关闭
     * @throws \Exception
     */
    public function close()
    {
        $this->getConn()->close();
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->close();
    }
}