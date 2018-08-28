
<?php
$res='';
if($model->pic!='no'):
	$picture=explode('|',$model->pic);
	foreach ($picture as $pic) {
	 	$res.='<img src="/web/uploads/'.$pic.'" style="width:150px; height:150px;margin:10px;">';
	 } 
else:
	$res='<img src="/web/img/nopic.png" style="width:150px; height:150px;margin:10px;">';
endif;
 ?>

<?php $content=
yii\widgets\DetailView::widget([
	'model'=>$model,
	'attributes'=>[
		'onvan','tozihat','user.email','price',
		['label'=>'دسته و زیر دسته','value'=>$parent->onvan.'>'.$model->cat->onvan],
		'tarikh','city.persian_name','mahale.name',
		['label'=>'تصاویر','value'=>$res,'format'=>['html']],

	]
]);
echo json_encode($content);
 ?>