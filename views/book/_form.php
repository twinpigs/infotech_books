<?php

use app\components\AuthorHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */

$model->_authors = $model->authors;
$model->_remove_cover = false;
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true, 'placeholder' => '9785699120143']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput(['placeholder' => '2023']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if($model->cover && file_exists(Yii::getAlias('@webroot/covers/' . $model->cover))): ?>
        <img src="<?= '/covers/' . $model->cover ?>" alt="cover" class="img-thumbnail">
        <?= $form->field($model, '_remove_cover')->checkbox() ?>
    <?php endif; ?>
    <?= $form->field($model, '_cover')->fileInput() ?>
    <p>Далее такой красивый виджет, подбор с асинхронным поиском, а то авторов многовато.</p>
    <?= $form->field($model, '_authors')->listbox(
        ArrayHelper::map(AuthorHelper::getAllSorted(), 'id', 'name'),
        [
            'multiple' => 'multiple',
            'size' => 10,
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
