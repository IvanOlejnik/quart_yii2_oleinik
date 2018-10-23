<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php// $form = ActiveForm::begin(); ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	    <?= $form->field($model, 'username')->textInput() ?>
	    <?= $form->field($model, 'email')->textInput() ?>
	    <?= $form->field($model, 'firstname')->textInput() ?>
	    <?= $form->field($model, 'lastname')->textInput() ?>
	    <?= $form->field($modelUpload, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
