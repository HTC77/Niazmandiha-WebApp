<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form ActiveForm */
?>
<div class="change-password">
    <?php $form = ActiveForm::begin(['id'=>'newpw','options'=>['class'=>'form-horizontal']]); ?>

        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        <input type="hidden" value="<?=$id?>" id="id" name="uid">
        <div class="form-group" style="margin-top: 7px;">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- change-password -->
<?php 
      // if ($id!=Yii::$app->user->identity->id):
      	$this->registerJs("
      		$('#newpw').on('beforeSubmit',function (e) {
	      		var form = $(this);
	      		$.ajax({
	                url    : form.attr('action'),
	                type   : 'post',
	                data   : form.serialize(),
	                success: function (response) 
	                {
	                    $('#newPasswordModal').modal('hide');
	                },
	                error  : function () 
	                {
	                    console.log('internal server error');
	                }
	            });
	            return false;
      		});
		");
      // endif;
 ?>