<?php


namespace CodeByKyle\RabbitMqModelPublisher\ModelEvents;

use CodeByKyle\RabbitMqModelPublisher\ModelEvent;
use CodeByKyle\RabbitMqModelPublisher\ModelEventTypes;

class ModelRestored extends ModelEvent
{
    public $actionType = ModelEventTypes::RESTORED;
}