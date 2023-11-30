<?php
namespace app\components;

use yii\helpers\Html;

class BookHelper
{
    public static function authorsToHtml($book)
    {
        $items = [];
        foreach ($book->authors as $author) {
            $items[] = Html::a($author->name, ['author/view', 'id' => $author->id]);
        }
        return $output = Html::ul($items, ['encode' => false]);
    }
}