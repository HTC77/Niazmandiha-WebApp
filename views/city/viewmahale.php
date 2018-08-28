<?php
use yii\grid\Gridview;
use app\models\Mahale;
use yii\helpers\ArrayHelper;
use yii\web\View;
?>
<div class="v-mahale">
<?php
echo GridView::widget
([
	'dataProvider'=>$dataProvider,
	'columns'=>
	[
		['class'=>'yii\grid\SerialColumn',
			'contentOptions'=>['style'=>'width:20px','class'=>'text-center']
		],
		'id','name',
		['class'=>'yii\grid\ActionColumn',
			'buttons'=>
			[
				'view'=>function($url,$model){return '';},
				'update'=>function($url,$model){return '<a class="mahale-action" href="'.Yii::$app->homeUrl.'city/mahaleupdate" id="'.$model->id.'" data-toggle="tooltip" title="ویرایش این محله"><span class="glyphicon glyphicon-pencil"></span></a>';},
				'delete'=>function($url,$model){return '<a class="mahale-action" href="'.Yii::$app->homeUrl.'city/mahaledelete" id="'.$model->id.'" data-toggle="tooltip" title="حذف این محله"><span class="glyphicon glyphicon-trash"></span></a>';}
			],
			'contentOptions'=>['class'=>'text-center']
		],
	],
	'summary'=>"نمایش {begin} - {end} از {totalCount} محله",
]);
?>
</div>

<?php 
$js=<<<js
$('th a').click(function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	return false;
});
$('[data-toggle="tooltip"]').tooltip();
js;
$this->registerJs($js,View::POS_BEGIN);
 ?>
   <!-- Modal -->
  <div class="modal fade" id="deleteMahaleModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close">&times;</button>
          <h4 align="center" class="modal-title">حذف محله</h4>
        </div>
        <div align="center" class="modal-body">
          <h5>آیا مطمئن هستید؟</h5>
          <h5 style="direction: rtl;" class="alert alert-danger">با حذف این محله تمام آگهی های مربوط به این محله پاک می شوند!</h5>
          <br>
          <div class="form-group">
	          <span id="yes"  m_id url class="delete-action btn btn-danger ">بـلـه</span>
	          <span id="no" class="delete-action btn btn-info ">خـیـر</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">انصراف</button>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="updateMahaleModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close">&times;</button>
          <h4 align="center" class="modal-title">ویرایش محله</h4>
        </div>
        <div align="center" class="modal-body">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">انصراف</button>
        </div>
      </div>
    </div>
  </div>
