<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="users-update">
    <?php $form = ActiveForm::begin(['id'=>'update-user','options'=>['class'=>'form-horizontal','style'=>['width'=>'50%','margin'=>'auto']]]); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'family') ?>
        <?= $form->field($model, 'email',['enableAjaxValidation'=>true]) ?>
        <?= $form->field($model, 'tel') ?>
        <?= $form->field($model, 'enum')->dropDownList(['user'=>'user','admin'=>'admin']) ?>

       <h3><span class="create-new-password glyphicon glyphicon-asterisk" id="<?=$model->id?>"  data-toggle="tooltip" title="تخصیص پسورد جدید برای این کاربر"></span></h3>

        <div class="form-group" style="margin-top: 7px;">
            <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- users-update -->
<?php 
$js=<<<js
       $('[data-toggle="tooltip"]').tooltip();
js;
 $this->registerJs($js); ?>