<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="change-password">
    <?php $form = ActiveForm::begin(['id'=>'changepw','options'=>['class'=>'form-horizontal']]); ?>

        <?= $form->field($model, 'old_password')->passwordInput() ?>
        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        
        <div class="form-group" style="margin-top: 7px;">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- change-password -->
