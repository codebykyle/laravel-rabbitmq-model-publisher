<?php

namespace CodeByKyle\RabbitMqModelPublisher;

class RabbitMqModelPublisherProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->app->bind('ModelPublisher', 'CodeByKyle\RabbitMqModelPublisher\ModelPublisher');

        if (!class_exists('ModelPublisher')) {
            class_alias('CodeByKyle\RabbitMqModelPublisher\Facades\ModelPublisher', 'ModelPublisher');
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
            'ModelPublisher',
            'CodeByKyle\RabbitMqModelPublisher'
        ];
    }
}