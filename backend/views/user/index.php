<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            'role',
            [
                'attribute'=>'avatar_image',
                //'value'=> $model->avatar_image,
                'format' => ['image',['class'=>'icon-size']],
            ],

            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-screenshot">Ban</span>', 
                    "/admin/user/change-role?id=$data->id&act=ban");
                },

            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-screenshot">cancBan</span>', 
                    "/admin/user/change-role?id=$data->id&act=cancBan");
                },

            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-screenshot">adm</span>', 
                    "/admin/user/change-role?id=$data->id&act=adm");
                },

            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-screenshot">cancAdm</span>', 
                    "/admin/user/change-role?id=$data->id&act=cancAdm");
                },

            ], 

            ['class' => 'yii\grid\ActionColumn'],
            //'template' => '{view} {update} {delete} {link}',
        ],
    ]); ?>
</div>
