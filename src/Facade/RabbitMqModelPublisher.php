<?php

namespace CodeByKyle\LaravelRabbitMqModelPublisher\Facades;

/**
 * Class RabbitMqModelPublisher
 * @package CodeByKyle\LaravelRabbitMqModelPublisher
 * @see CodeByKyle\LaravelRabbitMqModelPublisher\RabbitMqModelPublisher
 */
class RabbitMqModelPublisher
{
    protected static function getFacadeAccessor()
    {
        return 'RabbitMqModelPublisher';
    }
}