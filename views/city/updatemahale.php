<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Mahale */
/* @var $form ActiveForm */
?>
<div class="mahale-update">

    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>'true','id'=>'update-mahale','action' => '/web/city/mahaleupdate','options'=>['class'=>'form-horizontal','style'=>['width'=>'50%','margin'=>'auto']]]); ?>

        <?= $form->field($model, 'name') ?>

        <div class="form-group">
            <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<input id="u" type="hidden" pgu="<?=$pgu?>" m_pgu="<?=$m_pgu?>">
</div><!-- mahale-update -->
<?php
$js=<<<js
    var pagination_url=$('#u').attr('pgu');
    var mahale_pagination_url=$('#u').attr('m_pgu');
   
    function mahaleRender(url){
        $('#myModal .modal-body').load(url,function(){
            $('th a').click(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    }
    function render(view){
        $('.admin-content').load('/web/'+view);
    }
    function fullRender(url){
        $('.admin-content').load(url);
    }
    $('#update-mahale').on('beforeSubmit',function (e) {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) 
        {
            return false;
        }
        $.post('/web/city/session',{submit:'true'},function(){
            // submit form
            $.ajax({
                url    : form.attr('action'),
                type   : 'post',
                data   : form.serialize(),
                success: function (response) 
                {
                    pagination_url!='' ? fullRender(pagination_url) : render('city/view');
                    mahaleRender(mahale_pagination_url);
                    $('#updateMahaleModal').modal('hide');
                },
                error  : function () 
                {
                    console.log('internal server error');
                }
            });
        });
        
        return false;
    });
js;
 $this->registerJs($js); ?>