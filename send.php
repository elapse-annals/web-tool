<?php
/**
 * User: BenHuang
 * Email: benhuang1024@gmail.com
 * Date: 2019-11-09
 * Time: 15:46
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World111!');
$channel->basic_publish($msg, '', 'hello');
echo "[x] Sent 'Hello World!'\n";
$channel->close();
$connection->close();