<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Author $model */
/** @var app\models\Subscription $subscription_model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'books',
                'format' => 'html',
                'value' => function ($data) {
                    $items = [];
                    foreach ($data->books as $book) {
                        $items[] = Html::a($book->title, ['book/view', 'id' => $book->id]);
                    }
                    return $output = Html::ul($items, ['encode' => false]);
                }
            ],
        ],
    ]) ?>

    <?php if(Yii::$app->user->isGuest): ?>
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($subscription_model, 'phone',
            ['template' => "{label}\n<div class=\"input-group\"><div class=\"input-group-prepend\">
                            <div class=\"input-group-text\">+7</div></div>{input}</div>\n{hint}\n{error}"
            ])
            ->textInput(['maxlength' => true, 'placeholder' => '9272222222']) ?>
        <?= $form->field($subscription_model, 'author_id')->hiddenInput()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Subscribe', ['class' => 'btn btn-success', 'name' => 'mode', 'value' => 'subscribe']) ?>
            <?= Html::submitButton('Unsubscribe', ['class' => 'btn btn-danger', 'name' => 'mode', 'value' => 'unsubscribe']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <p>В реальной жизни подразумевается, что вы решили капчу, и успешно ввели код подтверждения, которые как будто бы были вам показаны и отправлены.
        Ничего этого нету тут, но можно добавить. Потом )</p>
    <?php endif; ?>

</div>
