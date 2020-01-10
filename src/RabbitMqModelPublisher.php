<?php

namespace CodeByKyle\RabbitMqModelPublisher;

use Bschmitt\Amqp\Publisher;
use Illuminate\Config\Repository;

class RabbitMqModelPublisher
{
    protected $publisher;

    public function __construct(array $config)
    {
        $this->publisher = new Publisher(
            new Repository($config)
        );
    }

    public function test(){
        return "Hello!";
    }
}