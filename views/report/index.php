<?php 
use yii\grid\Gridview;
 ?>
<div class="report-agahi">
 <?=
GridView::widget
([
	'dataProvider'=>$dataProvider,
	'columns'=>
	[
		['class'=>'yii\grid\SerialColumn',
			'contentOptions'=>['style'=>'width:20px','class'=>'text-center']
		],
		'report.name','agahi_id','ip',
		['class'=>'yii\grid\ActionColumn',
			'buttons'=>
			[	'view'=>function($url,$model){return '';},
				'update'=>function($url,$model){return'';},
				'delete'=>function($url,$model){return '<a class="report-action" href="'.Yii::$app->homeUrl.'report/delete" id="'.$model->id.'" data-toggle="tooltip" title="حذف این گزارش"><span class="glyphicon glyphicon-trash"></span></a>';}
			],
			'contentOptions'=>['class'=>'text-center']
		],
	],
	'summary'=>"نمایش {begin} - {end} از {totalCount} گزارش",
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
$this->registerJs($js);
 ?>