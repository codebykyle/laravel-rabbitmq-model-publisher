<?php


namespace CodeByKyle\RabbitMqModelPublisher\ModelEvents;

use CodeByKyle\RabbitMqModelPublisher\ModelEvent;
use CodeByKyle\RabbitMqModelPublisher\ModelEventTypes;

class ModelCreated extends ModelEvent
{
    public $actionType = ModelEventTypes::CREATED;
}