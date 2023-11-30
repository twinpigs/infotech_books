<?php

namespace app\components\base;

class Formatter extends \yii\i18n\Formatter
{
    const ISBN_REG = '/(\d{3})-?(\d)-?(\d{3})-?(\d{5})-?(\d)/';
    public function asIsbn($isbn) {
        $isbn = trim($isbn);
        if($isbn) {
            if(preg_match(static::ISBN_REG, $isbn, $mathes)) {
                $mathes = array_slice($mathes, 1);
                $isbn = implode('-', $mathes);
            }
        }

        return $isbn;
    }
}