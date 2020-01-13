<?php


namespace CodeByKyle\RabbitMqModelPublisher\ModelEvents;

use CodeByKyle\RabbitMqModelPublisher\ModelEvent;
use CodeByKyle\RabbitMqModelPublisher\ModelEventTypes;

class ModelDeleted extends ModelEvent
{
    public $actionType = ModelEventTypes::DELETED;
}