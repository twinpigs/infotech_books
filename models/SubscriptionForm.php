<?php

namespace app\models;

use yii\base\Model;

class SubscriptionForm extends Model
{
    const MESSAGE_SUBSCRIBE_FAIL = 'Не удалось вас подписать, сорян';
    const MESSAGE_SUBSCRIBE_SUCCESS = 'Вы подписаны';
    const MESSAGE_UNSUBSCRIBE_SUCCESS = 'Вы отписаны';


    public $phone;
    public $author_id;

    public function rules()
    {
        return [
            [['phone'], 'integer'],
            [['phone'], 'string', 'max' => 10, 'min' => 10], //более модная нужна проверка, конечно
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function subscribe(): string
    {
        $phone_to_subscribe = Phone::findOne(['phone' => $this->phone]);
        if(!$phone_to_subscribe) {
            $phone_to_subscribe = new Phone();
            $phone_to_subscribe->phone = $this->phone;
            if(!$phone_to_subscribe->save()) {
                return static::MESSAGE_SUBSCRIBE_FAIL;
            }
        }
        if(!Subscription::find()->exists()) {
            $new_subscription = new Subscription();
            $new_subscription->phone_id = $phone_to_subscribe->id;
            $new_subscription->author_id = $this->author_id;
            if(!$new_subscription->save()) {

                return static::MESSAGE_SUBSCRIBE_FAIL;
            }
        }

        return static::MESSAGE_SUBSCRIBE_SUCCESS;
    }

    public function unsubscribe(): string
    {
        $phone_to_unsubscribe = Phone::findOne(['phone' => $this->phone]);
        if($phone_to_unsubscribe) {
            Subscription::deleteAll(['phone_id' => $phone_to_unsubscribe->id, 'author_id' => $this->author_id]);
        }

        return static::MESSAGE_UNSUBSCRIBE_SUCCESS;
    }
}