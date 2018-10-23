<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\JsExpression; 
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1> 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'attribute'=>'avatar_image',
                'value'=> $model->avatar_image,
                'format' => ['image',['class'=>'icon-size-big']],
            ],
            'firstname',
            'lastname',
            'role',
            'created_at',
        ],
    ]) ?>

    <p>
        <?//= Html::a('Редактировать профиль', , ['class' => 'edit-data btn btn-primary']) ?>
        <a src="#" id="btn-success-dialog" class="btn btn-primary">Редактировать профиль</a>
        
        <?= Html::a('Удалить свою учетную запись', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
   

</div>
    
    <?php
    yii\jui\Dialog::begin([
        'id' => 'user-update', 
        'clientOptions' => [
            'title' => 'Редактировать профиль', 
            'autoOpen' => false, 
            'modal' => true, 
            'height' => 620, 
            'width' => 750, 
            'buttons' => [
                ['text' => 'Close', 
                    'class' => 'btn btn-sm btn-success', 
                    'click' => new JsExpression(' function() { $( this ).dialog( "close" );} '),
                ],
            ]
    ]]);
    ?>
    <div class="user-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
            'modelUpload' => $modelUpload,
        ]) ?>

    </div>
    <?
    yii\jui\Dialog::end();
    $jss = new JsExpression("
        $('#btn-success-dialog').click(function(){
            $('#user-update').dialog('open');
        });
    ");
    $this->registerJs($jss);
    ?>



<?/**
$js = new JsExpression("
    $('.edit-data').click( function () {
        $('.user-update').toggleClass('hidden-speshl');
        $('.edit-data').toggleClass('edit-btn');
        $('.edit-data').toggleClass('edit-btn-cn');
    });
");  
    
$this->registerJs($js);
**/?>
