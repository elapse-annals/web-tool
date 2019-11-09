<?php
/**
 * User: BenHuang
 * Email: benhuang1024@gmail.com
 * Date: 2019-11-09
 * Time: 22:54
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false, false);

$serverities = array_slice($argv, 1);
if (empty($serverities)) {
    file_put_contents('php//stderr', "Usage: $argv[0] [info] [warning] [error]\n");
    exit(1);
}

foreach ($serverities as $serverity) {
    $channel->queue_bind($queue_name, 'direct_logs', $serverity);
}

echo " [*] Waiting for logs. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
