<?php
/** @var int $year */
/** @var array $data */
$this->title = $year;
$this->params['breadcrumbs'][] = ['label' => 'Top 10', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<p>
<?php if(!$data): ?>
Никто ничего не написал в этом году, вообще.
<?php else: ?>
    <?= \yii\helpers\Html::ol(
        array_map(function ($el) {
            return \yii\helpers\Html::a($el['name'] . ' (' . $el['books'] . ')', ['author/view', 'id' => $el['id']]);
        }, $data), ['encode' => false]); ?>
<?php endif; ?>
</p>