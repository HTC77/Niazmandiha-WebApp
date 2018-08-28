<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\City */
/* @var $form ActiveForm */
?>
<div class="city-create">

    <?php $form = ActiveForm::begin(['id'=>'create-city','enableAjaxValidation'=>'true','options'=>['class'=>'form-horizontal','style'=>['width'=>'50%','margin'=>'auto','vertical-align'=>'middle','margin-top'=>'9%']]]); ?>

        <?= $form->field($model, 'latin_name') ?>
        <?= $form->field($model, 'persian_name') ?>
    
        <div class="form-group">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- city-create -->
