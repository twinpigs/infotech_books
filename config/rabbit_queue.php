<?php
//Сломан драйвер, вот печаль. Будем работать на файлах, как деды наши!
return [
    'class' => yii\queue\amqp_interop\Queue::class,
    'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_BUNNY,
    'dsn' => 'amqp://rmuser:rmpassword@rabbitmq:5672/%2F',
];