<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Agahi */
/* @var $form ActiveForm */
$url=Yii::$app->homeUrl;
?>
<div class="agahi-create">

    <?php $form = ActiveForm::begin(['id'=>'create-agahi','method'=>'post','action'=>'/web/agahi/saveagahi','options'=>['class'=>'form-horizontal','style'=>'padding:18px;margin-bottom:50px']]); ?>
       
        <?= $form->field($model, 'onvan')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'tozihat')->textarea()?>
        <?= $form->field($model, 'price') ?>
       
        
        <?= $form->field($model, 'cat_id')->dropDownList($cat,['prompt'=>'دسته مورد نظر خود را انتخاب کنید']) ?>
        <?= $form->field($model, 'subCat_id')->dropDownList(['prompt'=>'زیر دسته مورد نظر خود را انتخاب کنید']) ?>
          <?= $form->field($model, 'mahale_id')->dropDownList($mahale,['prompt'=>'محله مورد نظر را انتخاب کنید']) ?>
            <?= $form->field($model, 'pic')->fileInput(['class'=>'form-control','accept'=>'image/*','name'=>'agahi-img']) ?>
         <div class="pic-albom" align="center">
             <div class="pic"><img id="pic-1" src=<?=$url.'img/nopic.png'?>><a id="del-pic-1" href="#" class="delete-pic glyphicon glyphicon-remove pull-right"></a></div>
             <div class="pic"><img id="pic-2" src=<?=$url.'img/nopic.png'?>><a id="del-pic-2" href="#" class="delete-pic glyphicon glyphicon-remove pull-right"></a></div>
             <div class="pic"><img id="pic-3" src=<?=$url.'img/nopic.png'?>><a id="del-pic-3" href="#" class="delete-pic glyphicon glyphicon-remove pull-right"></a></div>
             <div class="pic"><img id="pic-4" src=<?=$url.'img/nopic.png'?>><a id="del-pic-4" href="#" class="delete-pic glyphicon glyphicon-remove pull-right"></a></div>
         </div>
             <input type="hidden" id="file-name" name="pic_file">
             <input type="hidden" id="file-ext" name="pic_ext">
        <div class="form-group" style="clear: both;">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary pull-left']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- agahi-create -->

<?php 
$js=<<<Js
var url="http://localhost/web/";

$('#agahi-cat_id').change(function(){
    var parent=$(this).val();
    $.post(url+'category/getchild',{get_child:true,p_id:parent},function(res){
        res=JSON.parse(res);
        if(res!=[]){
            $('#agahi-subcat_id').empty();
             $('#agahi-subcat_id').append('<option value="">زیر دسته مورد نظر خود را انتخاب کنید</option>');
         $.each(res,function(i){
            $('#agahi-subcat_id').append('<option value='+res[i].id+'>'+res[i].onvan+'</option>');
         });
        }
    });
}); 
    var byte_file=[];
    var byte_type=[];
    var byte_ext=[];
    var i=1;
    function readURL(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {  
                byte_file[i]=e.target.result; 
                byte_type[i]=byte_file[i].split('/',1);
                byte_type[i]=byte_type[i].toString().replace("data:",'');
                if(byte_type[i]=="image"){
                    $('#pic-'+i).attr('src', e.target.result);
                    $('#del-pic-'+i).css('display','block');
                    byte_ext[i]=byte_file[i].split(';',1);
                    byte_ext[i]=byte_ext[i].toString().replace("data:image/",'.');
                    byte_file[i]=byte_file[i].split(',')[1];
                    // console.log('extension '+i+' is::::  '+byte_ext[i]);
                    // console.log('type '+i+' is::::  '+byte_type[i]);
                    // console.log('byte '+i+' is::::  '+byte_file[i]);
                    i++;
                }
                else{
                    alert('عکس نا معتبر است!');
                }   
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#agahi-pic").change(function(){
        if(i<=4){
            var s=$('#pic-'+i).attr("src");
            while(i<5 && !s.includes("nopic.png")){
               s=$('#pic-'+ ++i).attr("src");   
            }
            if(i<=4){
                readURL(this);
            }else{
                alert('حداکثر عکس انتخاب شده!');
            }
        }
        else{
            alert('حداکثر عکس انتخاب شده!');
        }
        $(this).val('');
    });
    $('#create-agahi').on('beforeSubmit',function(e){
        $('#file-name').val(byte_file);
        $('#file-ext').val(byte_ext);
    });
    $('.delete-pic').click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var id=$(this).attr('id');
        id=id.substring(id.lastIndexOf('-')+1);
        i=id;
        $('#pic-'+i).attr('src','/web/img/nopic.png');
        $('#del-pic-'+i).css('display','none');
        byte_file[i]=null;
        byte_ext[i]=null;
        i=1;
        return false;
    });
Js;
$this->registerJs($js);
?>