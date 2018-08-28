<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form ActiveForm */
?>
<div class="category-create">
<h3 align="center">ایجاد دسته بندی</h3>
    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>'true','id'=>'create-cat']); ?>
    	<input type="hidden" name="c_parent" value="true">
        <?= $form->field($model, 'onvan')->textInput() ?>
        <?= $form->field($model, 'tozihat')->textarea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

<hr>
<h3 align="center">ایجاد زیر دسته</h3>
    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>'true','id'=>'create-child']); ?>
    	<input type="hidden" name="c_child" value="true">
        <?= $form->field($model, 'parent')->dropDownList($cat,['prompt'=>'دسته را انتخاب کنید']) ?>
        <?= $form->field($model, 'onvan')->textInput() ?>
        <?= $form->field($model, 'tozihat')->textarea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- category-create -->
