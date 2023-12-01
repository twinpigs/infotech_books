<?php

namespace app\components;

use app\models\Book;

class YearHelper
{
    public static function getAll(): array
    {
        return Book::find()->select('year')->distinct()->orderBy(['year' => SORT_DESC])->column();
    }
}