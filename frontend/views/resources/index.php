<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResourcesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resources';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resources-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::encode($formModel->name) ?>
    <?=$formModel->name?>

    <table class="table table-striped table-bordered table-data-center"><thead>
        <tr>
            <th><a href="#" data-sort="id">ID</a></th>
            <th><a href="#" data-sort="name">Name</a></th>
            <th><a href="#" data-sort="icon">Count</a></th>
            <th class="action-column">Icon</th>
            <th class="action-column">Buttons</th>
        </tr>  
         <tr><?php $form = ActiveForm::begin(); ?>
            <td width="100px;"><?= $form->field($formModel, 'id')->label(false) ?></td>
            <td><?= $form->field($formModel, 'name')->label(false) ?></td>
            <td width="200px;"> <?//= $form->field($formModel, 'count')->label(false) ?></td>
            <th class="action-column"></th>
            <td>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            </td>    
        </tr> <?php ActiveForm::end(); ?>
        </thead>
        <tbody>
            <?if(isset($resourcesData) && !empty($resourcesData)){ 
                foreach($resourcesData as $resourcData){?>
                <tr data-key="3">
                    <?if(isset($resourcData['resources'])){?>
                        <td><?=$resourcData['resources']['id'];?></td>
                        <td><?=$resourcData['resources']['name'];?></td>
                        <td><?=$resourcData['count'];?></td>
                        <td><img class="icon-size" src="<?=$resourcData['resources']['icon'];?>"></td>
                        <td><a href="/resources/update?id=<?=$resourcData['resources']['id']?>"><span class="glyphicon glyphicon-pencil">Редактировать</span></a></td>
                    <?}?>
                <?}?>
                </tr>
            <?}?>
        </tbody>
    </table>
</div>
