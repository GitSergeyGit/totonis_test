<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $modelAddress app\models\UserAddress */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="row">

        <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-6">

                <div class="user-form">

                    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'gender')->dropDownList(\app\models\User::GENDER_LIST) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

                </div>
            </div>

            <div class="col-md-6">

                <div class="user-form">

                    <?= $form->field($modelAddress, 'postcode')->textInput() ?>

                    <?= $form->field($modelAddress, 'country')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($modelAddress, 'city')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($modelAddress, 'street')->textInput(['maxlength' => true]) ?>

                    <div class="row">

                        <div class="col-md-6">
                            <?= $form->field($modelAddress, 'house_number')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($modelAddress, 'apartment')->textInput(['maxlength' => true]) ?>
                        </div>

                    </div>

                </div>

            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
