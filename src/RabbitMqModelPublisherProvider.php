<?php

namespace CodeByKyle\RabbitMqModelPublisher;

class RabbitMqModelPublisherProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->app->bind('RabbitMqModelPublisher', 'CodeByKyle\RabbitMqModelPublisher\RabbitMqModelPublisher');

        if (!class_exists('RabbitMqModelPublisher')) {
            class_alias('CodeByKyle\RabbitMqModelPublisher\Facades\ModelPublisher', 'RabbitMqModelPublisher');
        }

        $this->publishes([
            __DIR__ . '/../config/rabbitmq-model-publisher.php' => config_path('rabbitmq-model-publisher.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton('CodeByKyle\RabbitMqModelPublisher\RabbitMqModelPublisher', function ($app) {
            return new RabbitMqModelPublisher(
                config('rabbitmq-model-publisher')
            );
        });
    }

    public function provides()
    {
        return [
            'RabbitMqModelPublisher',
            'CodeByKyle\RabbitMqModelPublisher'
        ];
    }
}