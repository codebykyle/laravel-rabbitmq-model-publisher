<?php

namespace CodeByKyle\RabbitMqModelPublisher;

use Bschmitt\Amqp\Publisher;
use Bschmitt\Amqp\Request;
use Illuminate\Config\Repository;

class RabbitMqModelPublisher extends Publisher
{
    public function publishEvent(ModelEvent $event) {
        $this->publish(
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