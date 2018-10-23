<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression; 
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            'price',
            'count',
            'amount',
            'user_id',
        ],
    ]); ?>
    
    <p>
        <?//= Html::a('Купить игровую валюту', ['buy'], ['class' => 'btn btn-success']) ?>
        <a href="#" id="btn-success-dialog" class='btn btn-success'>Купить игровую валюту</a>
    </p>
    
    <?php
    yii\jui\Dialog::begin([
        'id' => 'payments-create', 
        'clientOptions' => [
            'title' => 'Покупка игровой валюты', 
            'autoOpen' => false, 
            'modal' => true, 
            'height' => 400, 
            'width' => 750, 
            'buttons' => [
                ['text' => 'Close', 
                    'class' => 'btn btn-sm btn-success', 
                    'click' => new JsExpression(' function() { $( this ).dialog( "close" );} '),
                ],
            ]
    ]]);
    ?>
    <div id="payments-create" class="payments-create">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    <?
    yii\jui\Dialog::end();
    $jss = new JsExpression("
        $('#btn-success-dialog').click(function(){
            $('#payments-create').dialog('open');
        });
    ");
    $this->registerJs($jss);
    ?>
</div>
