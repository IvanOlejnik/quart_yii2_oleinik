<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Resources */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resources-form">
	
	<?php $form = ActiveForm::begin(); ?>
	    
    <p>Колличество  <?=$model->resources->name;?> = <?=$model->count;?></p>
    <img src='<?=$model->resources->icon;?>' class="icon-size-big">
    <?= $form->field($model, 'count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
