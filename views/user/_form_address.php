<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserAddress */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="container">
    <div class="row">

        <?php $form = ActiveForm::begin(); ?>

            <?= Html::hiddenInput('user_id', $model->user_id) ?>

            <?= $form->field($model, 'postcode')->textInput() ?>

            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'apartment')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
