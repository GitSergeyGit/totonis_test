<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'password',
            'name',
            'last_name',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    return User::GENDER_LIST[$model->gender] ?? '--';
                },
                'filter' => User::GENDER_LIST,
            ],
            'email:email',
            ['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y H:i']],
        ],
    ]) ?>

    <p>
        <?= Html::a('Create Address', ['create-address', 'user_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if(!empty($model->userAddresses)):?>

        <div class="row">

            <div class="col-sm-11">
                <?php
                echo \yii\grid\GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $model->userAddresses,
                        'sort' => [
                            'attributes' => ['id'],
                        ],
                        'pagination' => [
                            'pageSize' => 5,
                        ],
                    ]),
                    'columns' => [

                        'postcode',
                        'country',
                        'city',
                        'street',
                        'house_number',
                        'apartment',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}{delete}',
                            'buttons'=>[
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-address', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-address', 'id' => $model->id], [
                                        'title' => 'Удалить',
                                        'data-confirm' => 'Are you sure you want to delete?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                    ]);
                                }
                            ]
                        ],

                    ],
                ]);
                ?>

            </div>

        </div>

    <?php endif;?>

</div>

