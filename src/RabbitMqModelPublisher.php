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

    public function publishEvent(ModelEvent $event) {
        $this->publisher->publish(
            $event->getRoutingKey(),
            $event->toMessage()
        );
    }

    public function test(array $testEvents){
        foreach($testEvents as $modelEvent) {
            $this->publishEvent($modelEvent);
        }
    }
}