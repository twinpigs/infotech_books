<?php
/** @var yii\web\View $this */
/** @var array $years */
?>
<h1>top/index</h1>

<p>
    <?= \yii\helpers\Html::ul(
        array_map(function ($el) {
            return \yii\helpers\Html::a($el, ['top/year', 'year' => $el]);
        }, $years), ['encode' => false]); ?>
</p>
