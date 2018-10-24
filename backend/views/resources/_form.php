<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Resources */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resources-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?//php// $form = ActiveForm::begin(); ?>

    <?= $form->field($modelResources, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUpload, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
