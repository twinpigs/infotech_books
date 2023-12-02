<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $cover
 *
 * @property Author[] $authors
 */
class Book extends \app\components\base\ActiveRecord
{
    public $_authors;
    public $_cover;
    public $_remove_cover;
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
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'cover'], 'string', 'max' => 255],
            [['isbn'], 'integer'],
            [['isbn'], 'string', 'max' => 13, 'min' => 13], //тут, на самом деле, валидадция по алгоритму, с контрольными числами и все такое
            [['isbn'], 'unique'],
            ['_authors', 'each', 'rule' => ['exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['_authors' => 'id']]],
            ['_cover', 'file', 'extensions' => ['png', 'jpg'], 'maxSize' => 480*640],//TODO: на бою построже надо, и размер
            ['_remove_cover', 'safe']
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
            'isbn' => 'ISBN',
            'cover' => 'Cover',
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('author_has_book', ['book_id' => 'id']);
    }

    public function upload(): bool
    {
        if(!!$this->_remove_cover && !$this->_cover) {
            $old_cover = $this->getCurrentCoverPath();
            $this->cover = null;
            $this->save(false);
            $this->removeCover($old_cover);
        }
        if(!$this->_cover) {
            return true;
        }
        if ($this->validate()) {
            //TODO: путь надо бы законфигурить и/или добавить алиас
            if(!file_exists(Yii::getAlias('@webroot/covers'))) {
                FileHelper::createDirectory(Yii::getAlias('@webroot/covers'));
            }
            $src = md5($this->_cover->baseName . time()) . '.' . $this->_cover->extension;
            //TODO: отресайзить же
            $this->_cover->saveAs(Yii::getAlias('@webroot/covers/' . $src));
            $old_cover = $this->getCurrentCoverPath();
            $this->cover = $src;
            $this->save(false);
            $this->removeCover($old_cover);
            return true;
        } else {

            return false;
        }
    }

    private function getCurrentCoverPath(): false|string|null
    {
        $result = null;
        if($this->cover) {
            $result = Yii::getAlias('@webroot/covers/' . $this->cover);
        }

        return $result;
    }

    private function removeCover($path)
    {
        if($path && file_exists($path)) {
            unlink($path);
        }
    }
}
