<?php

namespace app\components;


use app\components\smspilot\SmsPilot;
use app\models\Author;
use app\models\Book;
use app\models\Phone;
use app\models\Subscription;
use yii\base\BaseObject;
use yii\helpers\Url;
use yii\queue\JobInterface;

class SmsSender extends BaseObject implements JobInterface
{
    public array $authors_ids;
    public int $book_id;

    public function execute($queue)
    {
        $book = Book::findOne($this->book_id);
        if(!$book) {

            return;
        }
        \Yii::debug($book->title);
        $subscriptions = Subscription::find()
            ->alias('s')
            ->select(['phone', 'name'])
            ->leftJoin(Author::tableName() . ' a', 'a.id = s.author_id')
            ->leftJoin(Phone::tableName() . ' p', 'p.id = s.phone_id')
            ->andWhere(['author_id' => $this->authors_ids])
            ->asArray()
            ->all();

        if(!$subscriptions) {

            return;
        }

        $sms = new SmsPilot(\Yii::$app->params['pilot_api_key']);

        //Можно было бы и запрос поумней, учитывая, что в книгу могут добавиться несколько автором одновременно
        //а подписки на них у разных людей и не обязательно вместе и так далее
        //, и не дергать АПИ на каждый номер, а слать пачкой, но я чот не успел осознать:
        //написано можно слать на "несколько" номеров, даже на "много" номеров. А на сколько именно? Поэтому сделал по одному.
        //Можно тут создавать дочерние очереди (на каждый номер), чтобы долбить до победного
        foreach ($subscriptions as $subscription) {
            $message = $subscription['name']
                . ' написал новую книжку '
                . $book->title . ' <и тут ссылка>';
            \Yii::debug('Отправляем на номер ' . $subscription['phone'] . ' сообщение: ' . $message);
            if(!$sms->send('7'.$subscription['phone'], $message)) {
                \Yii::error($sms->error);
                //и мы такие: АХ! UNSUPPORTED OPERATOR, например, да как же мы валидировали-то? Что же мы за люди такие?
            }
        }
    }
}