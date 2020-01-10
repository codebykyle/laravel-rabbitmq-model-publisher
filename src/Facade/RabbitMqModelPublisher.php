<?php

namespace CodeByKyle\RabbitMqModelPublisher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class RabbitMqModelPublisher
 * @package CodeByKyle\LaravelRabbitMqModelPublisher
 * @see CodeByKyle\RabbitMqModelPublisher\RabbitMqModelPublisher
 */
class RabbitMqModelPublisher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RabbitMqModelPublisher';
    }
}