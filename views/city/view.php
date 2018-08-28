<?php
use yii\grid\Gridview;
use app\models\Mahale;
use yii\helpers\ArrayHelper;
echo GridView::widget
([
	'dataProvider'=>$dataProvider,
	'columns'=>
	[
		['class'=>'yii\grid\SerialColumn',
			'contentOptions'=>['style'=>'width:20px','class'=>'text-center']
		],
		'id','persian_name','latin_name',
		[
			'attribute'=>'لیست محله ها',
			'format'=>'raw',
			
			'value'=>function($model)
			{	
				$mahaleha=Mahale::find()->where(['city_id'=>$model->id])->all();
				$res='<select class="form-group form-control" style="background-color:whitesmoke;">';
				foreach ($mahaleha as $mahale) {
					$res.='<option value="'.$mahale->id.'" >'.$mahale->name.'</option>';
				}
				$res.='</select>';
				return $res;
			}
		],
		['class'=>'yii\grid\ActionColumn',
			'buttons'=>
			[
				'view'=>function($url,$model){return '';},
				'update'=>function($url,$model){return '<a class="city-action" href="'.Yii::$app->homeUrl.'city/update" id="'.$model->id.'" data-toggle="tooltip" title="ویرایش این شهر"><span class="glyphicon glyphicon-pencil"></span></a>';},
				'delete'=>function($url,$model){return '<a class="city-action" href="'.Yii::$app->homeUrl.'city/delete" id="'.$model->id.'" data-toggle="tooltip" title="حذف این شهر"><span class="glyphicon glyphicon-trash"></span></a>';}
			],
			'contentOptions'=>['class'=>'text-center']
		],
	],
	'summary'=>"نمایش {begin} - {end} از {totalCount} شهر",
]);
?>


<?php 
$js=<<<js
$('tr th:nth-child(5)').html('محله ها');
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
  <div class="modal fade" id="deleteCityModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 align="center" class="modal-title">حذف شهر</h4>
        </div>
        <div align="center" class="modal-body">
          <h5>آیا مطمئن هستید؟</h5>
          <h5 style="direction: rtl;" class="alert alert-danger">با حذف شهر تمام محله ها و آگهی های آن پاک می شوند!</h5>
          <br>
          <div class="form-group">
	          <span id="yes" c_id url class="delete-action btn btn-danger ">بـلـه</span>
	          <span id="no" class="delete-action btn btn-info ">خـیـر</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
        </div>
      </div>
    </div>
  </div>
