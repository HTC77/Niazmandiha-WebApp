<?php use bigpaulie\social\share\Share; ?>
<div class="show-detail" style="position: relative;">
<div class="row">
	<div class="col-xl-5 col-lg-5 col-md-7 col-sm-12 col-xs-12">
	<div class="pictures-box">
		<div class="selected-picture">
			<?php if ($model->pic=='no'): ?>
				<img src="/web/img/nopic.png">
			<?php else: 
				$pictures= explode('|', $model->pic);
				echo '<img src="/web/uploads/'.$pictures[0].'">';
				?>
			<?php endif ?>
		</div>
		<div class="pictures-details">
		<?php if (isset($pictures)): ?>
			<?php foreach ($pictures as $pic): ?>
				<img src="/web/uploads/<?=$pic?>">	
			<?php endforeach ?>
		<?php endif ?>
		</div>
	</div>
	</div><!-- col -->
	<div class="col-xl-7 col-lg-7 col-md-5 col-sm-12 col-xs-12">
	<div class="details-box">
		<h4 style="padding-right:7px;padding-top:17px;color: #777;font-family: yekan;">مشخصات آگهی شماره: <?=$model->id?></h4>
		<hr>
		<div class="detail-title">
			<h2><?=$model->onvan?></h2>
		</div>
		<div class="detail-descript">
			<h3><?=$model->tozihat?></h3>
			<br>
		</div>
		<div class="detail-other-desc">
				<h4 style="color: orange;font-family:yekan;">اطلاعات آگهی:</h4>
			<b style="color: green">قیمت: 
			<?php 
				try {
                  echo '<strong style="color: black;">'.number_format($model->price).'  تومان </strong>';
                } catch (Exception $e) {
                  echo '<strong style="color: black;">'.$model->price.'</strong>';
                }
			?></b>
			<br>
			<b style="color: green">شهر: <strong style="color: black;"><?=$model->city->persian_name?></strong></b>
			<br>
			<b style="color: green">محله: <strong style="color: black;"><?=$model->mahale->name?></strong></b>
			<br>
			<b style="color: green">دسته: <strong style="color: black;"><?=$model->cat->parents->onvan.'>'.$model->cat->onvan?></strong></b>
			<br>
			<b style="color: green">تاریخ: <strong style="color: black;"><?=$model->tarikh?></strong></b>
			
			<br>
			<br>
			<h4 style="color: orange;font-family:yekan;">اطلاعات تماس:</h4>
			<b style="color: green">نام: <strong style="color: #337ab7"><?=$model->user->name.' '.$model->user->family?></strong></b>
			<br>
			<b style="color: green">شماره تماس: <a href="tel:<?=$model->user->tel?>"><strong><?=$model->user->tel?></strong></a></b>
			<br>
			<b style="color: green;text-decoration: none;">ایمیل: <a href="mailto:<?=$model->user->email?>"><strong><?=$model->user->email?></strong></a></b>
		</div>
	<div class="social-share pull-left"><?=Share::widget(); ?></div>
	</div>
	</div><!-- col -->
	<div class="form-group" style="clear: both;float: right;margin: 60px 15px 5px 0;">
		<a href="#myModal" data-toggle="modal" class="btn btn-warning">گزارش این آگهی</a>
	</div>
	<div  style="clear: both;float: right;margin: 10px 15px;" id="report-message" class="alert alert-info pull-right"></div>
</div><!-- row -->
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!--Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 align="center" class="modal-title">&nbsp;گزارش آگهی</h4>
			</div>
			<div class="modal-body form-group">
				<h5 align="center"> دلیل گزارش:</h5>
				<select class="form-control" id="selected-report">
				<?php foreach ($report as $report): ?>
					<option value="<?=$report->id?>"><?=$report->name?></option>
				<?php endforeach ?>
				</select>
				<div align="center"><div id="save-report" a-id="<?=$model->id?>" class="btn btn-primary" >ثبت گزارش</div></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">برگشت</button>
			</div>
		</div>
	</div>
</div>
