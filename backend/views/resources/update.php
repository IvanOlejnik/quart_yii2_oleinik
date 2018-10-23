<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Resources */

$this->title = 'Update Resources: ' . $modelResources->name;
$this->params['breadcrumbs'][] = ['label' => 'Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelResources->name, 'url' => ['view', 'id' => $modelResources->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resources-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelResources' => $modelResources,
        'modelUpload' => $modelUpload,
    ]) ?>
</div>
