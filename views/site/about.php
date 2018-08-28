<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Site;


$this->title = 'درباره ما';
?>
<div class="site-about">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<?=$model->about?>

<?php if (Yii::$app->session['enum']=='admin'): ?>
    <?php $form = ActiveForm::begin(); ?>

    <?php echo froala\froalaeditor\FroalaEditorWidget::widget([
        'model' => $model,
        'attribute' => 'about',
        'options' => [
            // html attributes
            'id'=>'content'
        ],
        'clientOptions' => [
            'toolbarInline' => false,
            'theme' => 'royal', //optional: dark, red, gray, royal
            'language' => 'fa', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
        ],
    ]); ?>

    <div class="form-group" style="margin-top: 10px;">
        <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php endif ?>
    
</div>