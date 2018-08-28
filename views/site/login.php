<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\CaptchaValidator;
use yii\captcha\Captcha;

$this->title = 'ورود به سیستم	';
/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */
/* @var $form ActiveForm */
?>
<div class="site-login">
          <h3 align="center"><?= Html::encode($this->title) ?></h3>
<hr>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div align="center" class="form-group" style="margin-top: 7px;">
            <?= Html::submitButton('ورود', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-login -->
