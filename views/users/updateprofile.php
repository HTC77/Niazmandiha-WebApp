<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="users-updateprofile">

    <?php $form = ActiveForm::begin(['id'=>'update-profile','options'=>['class'=>'form-horizontal']]); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'family') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'tel') ?>
    
        <div class="form-group">
            <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- users-updateprofile -->
