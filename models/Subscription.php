<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property int $phone_id
 * @property int $author_id
 * @property int $scheduled
 *
 * @property Author $author
 * @property Phone $phone
 */
class Subscription extends \app\components\base\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_id', 'author_id'], 'required'],
            [['phone_id', 'author_id', 'scheduled'], 'integer'],
            [['phone_id', 'author_id'], 'unique', 'targetAttribute' => ['phone_id', 'author_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
            [['phone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Phone::class, 'targetAttribute' => ['phone_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_id' => 'Phone ID',
            'author_id' => 'Author ID',
            'scheduled' => 'Scheduled',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Phone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhone()
    {
        return $this->hasOne(Phone::class, ['id' => 'phone_id']);
    }
}
