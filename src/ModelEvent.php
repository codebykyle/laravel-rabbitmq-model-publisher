<?php

namespace CodeByKyle\RabbitMqModelPublisher;

use Bschmitt\Amqp\Message;
use CodeByKyle\RabbitMqModelPublisher\Contracts\AmqpMessagable;
use Illuminate\Database\Eloquent\Model;
use PhpOption\None;
use Ramsey\Uuid\Uuid;
use Serializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


abstract class ModelEvent implements AmqpMessagable
{
    /**
     * The routing key to publish. Leave blank to automatically generate
     * @var
     */
    public $routingKey;

    /**
     * What type of action was processed in the publisher?
     * eg: Create, Read, Update, Delete, etc
     * @var string
     * @see ModelEventTypes
     */
    public $actionType;

    /**
     * Content Type of the Body
     * @var string
     */
    public $contentType = 'application/json';

    /**
     * Which website or application is sending the request
     * @var
     */
    public $source;

    /**
     * What type of application is dispatching this message
     *
     * @var string
     */
    public $sourceType = SourceTypes::WEBSITE;

    /**
     * What type of user submitted this request.
     * eg: a bot, a user, an admin, an anonymous user, a webhook, etc
     * @see UserTypes
     * @var string
     */
    public $userType = UserTypes::USER;

    /**
     * The user issuing this model event
     *
     * @var Model|null
     */
    public $user;

    /**
     * If there is a reply to request attached
     * @var
     */
    public $replyTo;

    /**
     * If this request is part of a bigger chain of requests
     * @var
     */
    public $correlationId;

    /**
     * Which model did this affect
     *
     * @var Model
     */
    public $model;

    /**
     * A dictionary of changed fields
     *
     * @var array
     */
    public $changedFields = [];

    /**
     * A dictionary of all model fields
     *
     * @var array
     */
    public $modelData = [];

    /**
     * Default ModelEvent constructor.
     */
    public function __construct()
    {
    }

    /**
     * Serialize the body of the request into a JSON array
     *
     * @return array
     */
    public function bodyArray()
    {
        return [
            'modelData' => $this->getModelData(),
            'changedFields' => $this->getChangedFields(),
            'user' => $this->getUserData(),
            'userType' => $this->userType
        ];
    }

    protected function getUserData() {
        return $this->user->toArray();
    }

    /**
     * Convert the model data into a string
     *
     * @return false|string
     */
    protected function serializeBody() {
        return json_encode($this->bodyArray());
    }

    /**
     * Convert the model into an array of data
     *
     * @return array
     */
    public function getModelData() {
        if (!empty($this->modelData)) {
            return $this->modelData;
        }

        return $this->model->toArray();
    }

    /**
     * Get a list of changed fields
     *
     * @return array
     */
    public function getChangedFields() {
        if (!empty($this->changedFields)) {
            return $this->changedFields;
        }

        return $this->model->getChanges();
    }

    /**
     * Serialize the properties into a JSON array
     * @return array
     */
    public function propertiesArray() {
        return [
            'replyTo' => $this->replyTo,
            'correlationId' => $this->getCorrelationId(),
        ];
    }

    /**
     * Convert this event into a message
     *
     * @return Message
     */
    public function toMessage()
    {
        return new Message(
            $this->serializeBody(),
            $this->propertiesArray()
        );
    }

    public function getRoutingKey() {
        if (empty($this->routingKey)) {
            $appEnv = env('APP_ENV', 'production');
            $siteName = env('APP_NAME', 'Laravel');

            if (method_exists($this->model, 'getRoutingKey')) {
                $modelName = $this->model->getRoutingKey();
            } else if (property_exists($this->model, 'routingKey')) {
                $modelName = $this->model->routingKey;
            }  else {
                $modelName = $this->model->getTable();
            }

            return strtolower(
                collect([
                    $appEnv,
                    $this->sourceType,
                    $siteName,
                    $modelName,
                    $this->actionType
                ])
                ->join('.')
            );
        }

        return $this->routingKey;
    }

    public function getCorrelationId() {
        if (empty($this->correlationId)) {
            return Uuid::uuid4()->toString();
        }

        return $this->correlationId;
    }

    /**
     * Convert a message into an event
     *
     * @param Message $message
     * @return mixed
     */
    public function fromMessage(Message $message)
    {
        $messageProperties = $message->get_properties();
        $messageBody = $message->getBody();
    }
}