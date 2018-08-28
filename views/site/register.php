<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
$this->title = 'ثبت نام';
?>
<div class="site-register">
    <h3 align="center">فرم ثبت نام</h3>
<hr>
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true,'options'=>['class'=>'form-horizontal']]); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'family') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'tel') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    
        <span id="refresh-captcha" class="glyphicon glyphicon-refresh pull-left"></span>
        <?= $form->field($model, 'captcha',['enableAjaxValidation' => false])->widget(Captcha::className(),['imageOptions' => ['id' => 'my-captcha-image']])?>

        <?php $this->registerJs("
            $('#refresh-captcha').on('click', function(e){
                e.preventDefault();
                $('#my-captcha-image').yiiCaptcha('refresh');
            });
        "); ?>

        <div class="form-group" style="margin-top: 7px;">
            <?= Html::submitButton('ثبت نام', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
