<?php


namespace CodeByKyle\RabbitMqModelPublisher\Contracts;

use Bschmitt\Amqp\Message;
use CodeByKyle\RabbitMqModelPublisher\ModelEvent;

interface AmqpMessagable
{
    /**
     * Turn this object into an AMQP Message
     * @return Message
     */
    public function toMessage();

    /**
     * Turn the message into a Model Event
     * @param Message $message
     * @return mixed
     */
    public function fromMessage(Message $message);
}