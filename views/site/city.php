<?php

/* @var $this yii\web\View */

$this->title = 'انتخاب شهر';
?>
<h1 align="center">لطفاً شهر خود را انتخاب نمایید</h1>
<div align="center" class="city">
  <ul>
	  <?php if($city!=null): foreach ($city as $city):?>
	  <li><a href="<?=Yii::$app->homeUrl.$city->latin_name?>"><?=$city->persian_name ?></a></li>
	  <?php endforeach; endif;?>
  </ul>           
</div>