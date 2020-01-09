<?php

namespace CodeByKyle\RabbitMqModelPublisher;

use Bschmitt\Amqp\Publisher;

class RabbitMqModelPublisher
{
    protected $publisher;

    public function __construct(array $config)
    {
        $this->publisher = new Publisher($config);
    }

    public function consoleTest(){
        return "Hello!";
    }
}