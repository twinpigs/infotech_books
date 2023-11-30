<?php

namespace app\components;

use app\models\Author;

class AuthorHelper
{
    public static function getAllSorted(): array
    {
        return Author::find()->orderBy(['name' => SORT_ASC, 'id' => SORT_ASC])->all();
    }
}