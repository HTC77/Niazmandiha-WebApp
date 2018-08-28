<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="users-create">
    <?php $form = ActiveForm::begin(['id'=>'create-user','options'=>['class'=>'form-horizontal','style'=>['width'=>'50%','margin'=>'auto']]]); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'family') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'tel') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        <?= $form->field($model, 'enum')->dropDownList(['user'=>'user','admin'=>'admin']) ?>

       

        <div class="form-group" style="margin-top: 7px;">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- users-create -->
