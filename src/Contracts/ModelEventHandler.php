<?php

namespace CodeByKyle\RabbitMqModelPublisher\Contracts;

use CodeByKyle\RabbitMqModelPublisher\ModelEvent;
use CodeByKyle\RabbitMqModelPublisher\RabbitMqModelPublisher;
use Illuminate\Database\Eloquent\Model;

interface ModelEventHandler
{
    public function handleEvent(ModelEvent $modelEvent);
}