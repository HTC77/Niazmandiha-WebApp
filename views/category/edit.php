<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form ActiveForm */
?>
<div class="category-edit">
    <div class="parent">
    <h3 align="center">ویرایش دسته بندی</h3>

        <?php $form = ActiveForm::begin(['enableAjaxValidation'=>'true']); ?>

            <input type="hidden" id="c" name="cat_id" value="cat_id">
            <?= $form->field($model, 'parent')->dropDownList($cat,['prompt'=>'دسته را انتخاب کنید']) ?>
            <?= Html::button('حذف', ['class' => 'btn btn-danger pull-left','id'=>'del-parent']) ?>
            <div style="clear: both;"></div>
            <?= $form->field($model, 'onvan')->textInput() ?>
            <?= $form->field($model, 'tozihat')->textarea() ?>

        
            <div class="form-group">
                <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
<hr>
    <div class="child">
    <h3 align="center">ویرایش زیر دسته</h3>

        <?php $form = ActiveForm::begin(['enableAjaxValidation'=>'true']); ?>

            <input type="hidden" id="c" name="ch_id" value="ch_id">
            <?= $form->field($model, 'parent')->dropDownList($cat,['prompt'=>'دسته را انتخاب کنید']) ?>
            <?= $form->field($model, 'child')->dropDownList(['prompt'=>'زیر دسته را انتخاب کنید']) ?>

            <?= Html::button('حذف', ['class' => 'btn btn-danger pull-left','id'=>'del-child']) ?>
            <div style="clear: both;"></div>
            <?= $form->field($model, 'onvan')->textInput() ?>
            <?= $form->field($model, 'tozihat')->textarea() ?>
        
            <div class="form-group">
                <?= Html::submitButton('بروز رسانی', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- category-edit -->
 <div class="modal fade" id="deleteCatModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 align="center" class="modal-title">حذف دسته بندی</h4>
        </div>
        <div align="center" class="modal-body">
          <h5><strong>آیا مطمئن هستید؟</strong></h5>
          <h5 style="direction: rtl;" class="alert alert-danger">با حذف دسته تمام زیر دسته ها و آگهی های  مربوط به آن ها پاک می شوند!</h5>
          <br>
          <div class="form-group">
              <span id="yes" class="delete-action btn btn-danger ">بـلـه</span>
              <span id="no" class="delete-action btn btn-info ">خـیـر</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
        </div>
      </div>
    </div>
  </div>
 <div class="modal fade" id="deleteChildModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 align="center" class="modal-title">حذف زیر دسته</h4>
        </div>
        <div align="center" class="modal-body">
          <h5><strong>آیا مطمئن هستید؟</strong></h5>
          <h5 style="direction: rtl;" class="alert alert-danger">با حذف این زیر دسته تمام آگهی های مربوط به آن پاک می شوند!</h5>
          <br>
          <div class="form-group">
              <span id="yes" class="delete-action btn btn-danger ">بـلـه</span>
              <span id="no" onClick="return $('#deleteChildModal').modal('hide');" class="delete-action btn btn-info ">خـیـر</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
        </div>
      </div>
    </div>
  </div>

<?php 
$js=<<<js
var id;
$('#no').click(function(){
    $('*').modal('hide');
});
$('.category-edit .parent #category-parent').change(function(){
    var parent=$(this).find(':selected').text();
    var parent_id=$(this).val();
    $('.parent #c').val(parent_id);
    $.post('/web/category/get',{c_id:parent_id},function(res){
        res=JSON.parse(res);
        $('.parent #category-tozihat').val(res);
        $('.parent #category-onvan').val(parent);
    });
});

$('.category-edit .child #category-parent').change(function(){
    var parent=$(this).val();
    $.post('/web/category/getchild',{get_child:true,p_id:parent},function(res){
        res=JSON.parse(res);
        if(res!=[]){
            $('.child #category-child').empty();
             $('.child #category-child').append('<option value="">زیر دسته را انتخاب کنید</option>');
         $.each(res,function(i){
            $('.child #category-child').append('<option value='+res[i].id+'>'+res[i].onvan+'</option>');
         });
        }
    });
});

$('.category-edit .child #category-child').change(function(){
    var child=$(this).find(':selected').text();
    var child_id=$(this).val();
    $('.child #c').val(child_id);
    $.post('/web/category/get',{c_id:child_id},function(res){
        res=JSON.parse(res);
        $('.child #category-tozihat').val(res);
        $('.child #category-onvan').val(child);
    });
});

$('#del-parent').click(function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    id=$('#category-parent').val();
    if(jQuery.isNumeric(id)){
        $('#deleteCatModal #yes').attr({'c_id':id});
        $('#deleteCatModal .modal-header .modal-title').text('حذف دسته شماره:' + id);
        $('#deleteCatModal').modal('show');
    }
    else{
        alert('ابتدا یک دسته را انتخاب کنید');
    }
    return false;
});
$('#del-child').click(function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    id=$('#category-child').val();
    if(jQuery.isNumeric(id)){
        $('#deleteChildModal #yes').attr({'c_id':id});
        $('#deleteChildModal .modal-header .modal-title').text('حذف زیر دسته شماره:' + id);
        $('#deleteChildModal').modal('show');    
    }
    else{
        alert('ابتدا یک زیر دسته را انتخاب کنید');
    }
    return false;
});

$('#deleteCatModal #yes').click(function(){
    $.post("/web/category/delete",{cat:'parent',c_id:id},function(){
      getParents_1();
      $('.parent #category-onvan').val('');
      $('.parent #category-tozihat').val('');
      $('#deleteCatModal').modal('hide');
    });
});
$('#deleteChildModal #yes').click(function(){
    $.post("/web/category/delete",{cat:'child',c_id:id},function(){
      getParents_2();
      $('.child #category-child').empty();
      $('.child #category-child').append('<option value="">زیر دسته را انتخاب کنید</option>');
      $('.child #category-onvan').val('');
      $('.child #category-tozihat').val('');
      $('#deleteChildModal').modal('hide');
    });
});

function getParents_1(){
  $.post('/web/category/getparent',{get_parent:'true'},function(res){
    res=JSON.parse(res);
    if(res!=[]){
        $('.parent #category-parent').empty();
         $('.parent #category-parent').append('<option value="">دسته را انتخاب کنید</option>');
     $.each(res,function(i){
        $('.parent #category-parent').append('<option value='+res[i].id+'>'+res[i].onvan+'</option>');
     });
    }
  });
}

function getParents_2(){
   $.post('/web/category/getparent',{get_parent:'true'},function(res){
    res=JSON.parse(res);
    if(res!=[]){
        $('.child #category-parent').empty();
         $('.child #category-parent').append('<option value="">دسته را انتخاب کنید</option>');
     $.each(res,function(i){
        $('.child #category-parent').append('<option value='+res[i].id+'>'+res[i].onvan+'</option>');
     });
    }
  });
}
js;
$this->registerJs($js);
 ?>