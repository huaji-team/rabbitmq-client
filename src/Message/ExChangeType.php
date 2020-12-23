<?php
/**
 * ExChangeType.php
 * @author   Liu Zhang
 */

namespace PhpRabbitMQClient\Message;

/**
 * Class ExChangeType
 * @package PhpRabbitMQClient\Message
 */
class ExChangeType
{
    const DIRECT = 'direct';

    const FANOUT = 'fanout';

    const TOPIC = 'topic';

    public static function all()
    {
        return [
            self::DIRECT,
            self::FANOUT,
            self::TOPIC,
        ];
    }
}