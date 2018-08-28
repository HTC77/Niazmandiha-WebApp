<?php
use yii\grid\Gridview;
use app\models\Agahi;
$newCol='';
if(Yii::$app->session['enum']=='admin')
{
	$newCol=[
	'attribute'=>'وضعیت',
	'format'=>'raw',
	'value'=>function($model)
	{
		if($model->taeed==1)
		{
			return '<input type="checkbox" checked="true" id="change_taeed" name="change_taeed" data-ok="false" data-id="'.$model->id.'"/>تأیید'.'<span class="submited-agahi">تأیید شده</span>';
		}
		else
		{
			return '<input type="checkbox" id="change_taeed" name="change_taeed" data-ok="true" data-id="'.$model->id.'"/>تأیید '.'<span class="not-submited-agahi">تأیید نشده</span>';						
		}
	}, 
	];
}
else
{
		$newCol=[
	'attribute'=>"وضعیت",
	'format'=>'raw',
	'value'=>function($model)
	{
		if($model->taeed==1)
		{
			return '<span class="submited-agahi">تأیید شده</span>';
		}
		else
		{
			return '<span class="not-submited-agahi">تأیید نشده </span>';
		}
	}, 
	];	
}
?>
<?=Yii::$app->session['enum']=='admin'?
GridView::widget
([
	'dataProvider'=>$dataProvider,
	'columns'=>
	[
		['class'=>'yii\grid\SerialColumn',
			'contentOptions'=>['style'=>'width:20px','class'=>'text-center']
		],
		'onvan','tozihat','user.email','user.name','user.family',$newCol,
		['class'=>'yii\grid\ActionColumn',
			'buttons'=>
			[
				'view'=>function($url,$model){return '<a class="agahi-action" href="'.Yii::$app->homeUrl.'agahi/details" id="'.$model->id.'" data-toggle="tooltip" title="مشاهده ی کامل این آگهی"><span class="glyphicon glyphicon-eye-open"></span></a>';},
				'update'=>function($url,$model){return '<a class="agahi-action" href="'.Yii::$app->homeUrl.'agahi/update" id="'.$model->id.'" data-toggle="tooltip" title="ویرایش این آگهی"><span class="glyphicon glyphicon-pencil"></span></a>';},
				'delete'=>function($url,$model){return '<a class="agahi-action" href="'.Yii::$app->homeUrl.'agahi/delete" id="'.$model->id.'" data-toggle="tooltip" title="حذف این آگهی"><span class="glyphicon glyphicon-trash"></span></a>';}
			],
			'contentOptions'=>['class'=>'text-center']
		],
	],
	'summary'=>"نمایش {begin} - {end} از {totalCount} آگهی",
]):
GridView::widget
([
	'dataProvider'=>$dataProvider,
	'columns'=>
	[
		['class'=>'yii\grid\SerialColumn',
			'contentOptions'=>['style'=>'width:20px','class'=>'text-center']
		],
		'onvan','tozihat',$newCol,
		['class'=>'yii\grid\ActionColumn',
			'buttons'=>
			[
				'view'=>function($url,$model){return '<a class="agahi-action" href="'.Yii::$app->homeUrl.'agahi/details" id="'.$model->id.'" data-toggle="tooltip" title="مشاهده ی کامل این آگهی"><span class="glyphicon glyphicon-eye-open"></span></a>';},
				'update'=>function($url,$model){return '<a class="agahi-action" href="'.Yii::$app->homeUrl.'agahi/update" id="'.$model->id.'" data-toggle="tooltip" title="ویرایش این آگهی"><span class="glyphicon glyphicon-pencil"></span></a>';},
				'delete'=>function($url,$model){return '<a class="agahi-action" href="'.Yii::$app->homeUrl.'agahi/delete" id="'.$model->id.'" data-toggle="tooltip" title="حذف این آگهی"><span class="glyphicon glyphicon-trash"></span></a>';}
			],
			'contentOptions'=>['class'=>'text-center']
		],
	],
	'summary'=>"نمایش {begin} - {end} از {totalCount} آگهی",
]);
?>

  <!-- Modal -->
  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 align="center" class="modal-title">حذف آگهی</h4>
        </div>
        <div align="center" class="modal-body">
          <h5>آیا مطمئن هستید؟</h5>
          <br>
          <div class="form-group">
	          <span id="yes" a_id url class="delete-action btn btn-danger ">بـلـه</span>
	          <span id="no" class="delete-action btn btn-info ">خـیـر</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
        </div>
      </div>
    </div>
  </div>
<input type="hidden" id="enum-session" value="<?=Yii::$app->session['enum']?>">
<?php 
$js=<<<js
var enum_s = $('#enum-session').val();
	if(enum_s == "admin"){
		$('tr th:nth-child(7)').html('وضعیت');
	}
	else{
		$('tr th:nth-child(4)').html('وضعیت');
		$('.not-submited-agahi').css('float','none');
		$('.submited-agahi').css('float','none');
		$('tr td:nth-child(4)').css('text-align','center');
	} 
$('th a').click(function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	return false;
});
$('[data-toggle="tooltip"]').tooltip();
js;
$this->registerJs($js);
 ?>