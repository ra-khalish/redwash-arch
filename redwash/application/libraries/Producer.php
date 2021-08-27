<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("./vendor/autoload.php");
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class Producer
{       
    function publish($message)
    {
        
        $connection = new AMQPStreamConnection(
            'rabbitmq', 5672, 'admin', 'admin', 'mail');
        $channel = $connection->channel();


        # Initialize Broker
        // $exchange_name = 'notif_event';
        // if ($message['message_type'] == 'notif') {
        //     $queue_name = 'notif.status.queue';
        //     $routing_key = 'notif.status';
        // } elseif ($message['message_type'] == 'auth'){
        //     $queue_name = 'notif.auth.queue';
        //     $routing_key = 'notif.auth';
        // }

        # Initialize Broker
        $exchange_name = 'notif_event';
        $queue_name = 'notif.email.queue';
        $routing_key = 'notif.email';

        $channel->queue_declare($queue_name, false, true, false, false);
        $channel->exchange_declare($exchange_name, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($queue_name, $exchange_name, $routing_key);
        // $data = implode(' ', array_slice($argv, 1));

        $message = json_encode($message);
        if (empty($message)) {
            $message = "Hello World!";
        }
        $msg = new AMQPMessage(
            $message,
            array('content_type' => 'application/json','delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $channel->basic_publish($msg, $exchange_name, $routing_key);
        // echo $message;
        log_message('info', $message);

        $channel->close();
        $connection->close();

        return TRUE;
    }    
}