<?php
/** @var yii\web\View $this */
/** @var array $years */
$this->title = 'Top 10';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<p>
    <?= \yii\helpers\Html::ul(
        array_map(function ($el) {
            return \yii\helpers\Html::a($el, ['top/year', 'year' => $el]);
        }, $years), ['encode' => false]); ?>
</p>
