<?php

namespace app\services;

use app\models\Book;
use Yii;


class BookService extends \yii\base\Component
{
    public Book $model;

    private function scheduleSMS($authors_ids, $book_id)
    {

    }

    public function save(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        $old_authors_ids = $this->model->getAuthors()->select('id')->column();
        $new_authors_ids = $this->model->_authors;
        if(!$new_authors_ids) {
            $new_authors_ids = [];
        }
        $authors_to_sms = array_diff($new_authors_ids, $old_authors_ids);
        try {
            if ($this->model->save()) {
                $this->model->refresh();
                Yii::$app->db->createCommand()->delete(
                    'author_has_book',
                    ['book_id' => $this->model->id]
                )->execute();
                foreach ($new_authors_ids as $new_author_id) {
                    Yii::$app->db->createCommand()->insert(
                        'author_has_book',
                        [
                            'book_id' => $this->model->id,
                            'author_id' => $new_author_id,
                        ]
                    )->execute();
                }
                $transaction->commit();
                $this->scheduleSMS($authors_to_sms, $this->model->id);

                return true;
            } else {
                throw new \Exception('Ничего не вышло, руины!');
            }
        } catch (\Throwable $e) {
            $transaction->rollback();

            return false;
        }
    }

    public function getErrors(): array
    {
        return $this->model->errors;
    }
}