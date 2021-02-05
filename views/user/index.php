<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'login',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
