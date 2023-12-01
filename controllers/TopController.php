<?php

namespace app\controllers;

use app\components\YearHelper;
use app\services\AuthorService;

class TopController extends \app\components\base\Controller
{
    public function actionIndex()
    {

        return $this->render('index',
            ['years' => YearHelper::getAll()]
        );
    }

    public function actionYear($year)
    {
        $year = (int) $year;

        return $this->render('year',
            [
                'year' => $year,
                'data' => AuthorService::getTop($year),
            ]
        );
    }

}
