<?php
use yii\grid\Gridview;
use app\models\Users;

echo GridView::widget
([
	'dataProvider'=>$dataProvider,
	'columns'=>
	[
		['class'=>'yii\grid\SerialColumn',
			'contentOptions'=>['style'=>'width:20px','class'=>'text-center']
		],
		'name','family','tel','email','enum',
		['class'=>'yii\grid\ActionColumn',
			'buttons'=>
			[
				'view'=>function($url,$model){return '';},
				'update'=>function($url,$model){return '<a class="user-action" href="'.Yii::$app->homeUrl.'users/update" id="'.$model->id.'" data-toggle="tooltip" title="ویرایش این کاربر"><span class="glyphicon glyphicon-pencil"></span></a>';},
				'delete'=>function($url,$model){return '<a class="user-action" href="'.Yii::$app->homeUrl.'users/delete" id="'.$model->id.'" data-toggle="tooltip" title="حذف این کاربر"><span class="glyphicon glyphicon-trash"></span></a>';}
			],
			'contentOptions'=>['class'=>'text-center']
		],
	],
	'summary'=>"نمایش {begin} - {end} از {totalCount} کاربر",
]);
?>


<?php 
$js=<<<js
$('th a').click(function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	return false;
});
$('[data-toggle="tooltip"]').tooltip();
js;
$this->registerJs($js);
 ?>
   <!-- Modal -->
  <div class="modal fade" id="deleteUserModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 align="center" class="modal-title">حذف کاربر</h4>
        </div>
        <div align="center" class="modal-body">
          <h5>آیا مطمئن هستید؟</h5>
          <h5 style="direction: rtl;" class="alert alert-warning">با حذف کاربر تمام آگهی های آن پاک می شوند!</h5>
          <br>
          <div class="form-group">
	          <span id="yes" u_id url class="delete-action btn btn-danger ">بـلـه</span>
	          <span id="no" class="delete-action btn btn-info ">خـیـر</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="newPasswordModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close">&times;</button>
          <h4 align="center" class="modal-title">تخصیص پسورد جدید</h4>
        </div>
        <div align="center" class="modal-body">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
        </div>
      </div>
    </div>
 </div>
