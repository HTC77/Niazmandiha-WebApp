<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'تماس با ما';
?>
<div class="site-contact">

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success text-right">
             <h4 style="font-family: mitra"> .با تشکر! &nbsp; پیام شما ارسال شد به زودی با شما تماس خواهیم گرفت</h4>
        </div>

    <?php else: ?>

        <div class="c-form">
          <h3 align="center"><?= Html::encode($this->title) ?></h3>
        <p >
           <h3 style="font-family: mitra"> اگر درخواست ، سؤال یا پیشنهادی دارید از طریق فرم زیر با ما تماس بگیرید. متشکریم.</h3>
           <hr>
        </p>


                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                    <div id="refresh-captcha" class="glyphicon glyphicon-refresh pull-left"></div>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['imageOptions' => ['id' => 'my-captcha-image'],
                        'template' => '<div class="row"><div class="col-lg-3 pull-left">{image}</div><div class="col-lg-9">{input}</div></div>',
                    ]) ?>

                 <?php $this->registerJs("
                            $('#refresh-captcha').on('click', function(e){
                                e.preventDefault();
                                $('#my-captcha-image').yiiCaptcha('refresh');
                            });
                            $('p').css('color','#00ffff');
                        "); ?>
                    <div class="form-group">
                        <?= Html::submitButton('ارسال', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>
