<?php
//Сломан драйвер, вот печаль. Будем работать на файлах, как деды наши!
return [
    'class' => \yii\queue\amqp_interop\Queue::class,
    'port' => 5672,
    'user' => 'rmuser',
    'password' => 'rmpassword',
    'queueName' => 'sms',
    'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_LIB,
];