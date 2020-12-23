<?php
/**
 * Config.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient;

/**
 * Class Config
 * @package PhpRabbitMQClient
 */
class Config
{
    /**
     * 服务地址
     * @var string
     */
    private $host;

    /**
     * 服务端口
     * @var integer
     */
    private $port = 5672;

    /**
     * 安全账号
     * @var string
     */
    private $user;

    /**
     * 安全密码
     * @var string
     */
    private $password;

    /**
     * 虚拟机组
     * @var string
     */
    private $vhost = '/';

    /**
     * 心跳间隔 (秒)
     * @var integer
     */
    private $heartbeat = 30;

    /**
     * 连接超时 (秒)
     * @var float
     */
    private $connectTimeout = 3.0;

    /**
     * 读写超时 (秒)
     * @var float
     */
    private $readWriteTimeout = 3.0;

    /**
     * @var bool
     */
    private $keepalive = false;

    /**
     * Config constructor.
     * @param  array  $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $setter = 'set'.\ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return $this
     */
    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return $this
     */
    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }

    /**
     * @param string $vhost
     * @return $this
     */
    public function setVhost(string $vhost): self
    {
        $this->vhost = $vhost;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeartbeat(): int
    {
        return $this->heartbeat;
    }

    /**
     * @param int $heartbeat
     * @return $this
     */
    public function setHeartbeat(int $heartbeat): self
    {
        $this->heartbeat = $heartbeat;

        return $this;
    }

    /**
     * @return float
     */
    public function getConnectTimeout(): float
    {
        return $this->connectTimeout;
    }

    /**
     * @param float $connectTimeout
     * @return $this
     */
    public function setConnectTimeout(float $connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    /**
     * @return float
     */
    public function getReadWriteTimeout(): float
    {
        return $this->readWriteTimeout;
    }

    /**
     * @param float $readWriteTimeout
     * @return $this
     */
    public function setReadWriteTimeout(float $readWriteTimeout): self
    {
        $this->readWriteTimeout = $readWriteTimeout;

        return $this;
    }

    /**
     * @return bool
     */
    public function isKeepalive(): bool
    {
        return $this->keepalive;
    }

    /**
     * @param bool $keepalive
     * @return $this
     */
    public function setKeepalive(bool $keepalive): self
    {
        $this->keepalive = $keepalive;

        return $this;
    }


}