<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Mahale;

/* @var $this yii\web\View */
/* @var $model app\models\City */
/* @var $form ActiveForm */
?>
<div class="city-update">

    <?php $form = ActiveForm::begin(['id'=>'create-city','enableAjaxValidation'=>'true','options'=>['class'=>'form-horizontal','style'=>['width'=>'50%','margin'=>'auto']]]); ?>

        <?= $form->field($model, 'latin_name') ?>
        <?= $form->field($model, 'persian_name') ?>
        <?php  
        		$mahaleha=Mahale::find()->where(['city_id'=>$model->id])->all();
				$res='<select class="form-group form-control" style="background-color:whitesmoke;width:70%;">';
				foreach ($mahaleha as $mahale) {
					$res.='<option value="'.$mahale->id.'" >'.$mahale->name.'</option>';
				}
				$res.='</select>';
				$res.='<a class="m-action" city="'.$model->persian_name.'" id="'.$model->id.'" href="/web/city/mahaleview" data-toggle="tooltip" title="ویرایش محله ها"><span class="glyphicon glyphicon-pencil"></span></a>';
		?>
		<?="<strong>محله ها </strong>$res"?>
        <div class="form-group">
            <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- city-update -->
<?php 
$js=<<<js
       $('[data-toggle="tooltip"]').tooltip();
js;
 $this->registerJs($js); ?>