<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 *
 * @property AuthorHasBook[] $authorHasBooks
 */
class Author extends \app\components\base\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[AuthorHasBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorHasBooks()
    {
        return $this->hasMany(AuthorHasBook::class, ['author_id' => 'id']);
    }
}
