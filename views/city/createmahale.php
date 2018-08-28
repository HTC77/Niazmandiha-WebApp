<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mahale */
/* @var $form ActiveForm */
?>
<div class="city-createmahale">

    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>true,'id'=>'create-mahale','options'=>['class'=>'form-horizontal','style'=>['width'=>'50%','margin'=>'auto','vertical-align'=>'middle','margin-top'=>'9%']]]); ?>
    	<?php $model->city_id=$city_id;?>
        <?= $form->field($model, 'city_id')->dropDownList($city) ?>
        <?= $form->field($model, 'name') ?>
    
        <div class="form-group">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- city-createmahale -->
