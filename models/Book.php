<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string|null $cover
 *
 * @property AuthorHasBook[] $authorHasBooks
 */
class Book extends \app\components\base\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'year'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'cover'], 'string', 'max' => 255],
            [['cover'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'cover' => 'Cover',
        ];
    }

    /**
     * Gets query for [[AuthorHasBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorHasBooks()
    {
        return $this->hasMany(AuthorHasBook::class, ['book_id' => 'id']);
    }
}
