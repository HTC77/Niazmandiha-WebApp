<?php
/* @var $this yii\web\View */
use app\controllers\UsersController;
$session=Yii::$app->session;
if(isset(Yii::$app->session['pagination_url']) && Yii::$app->session['pagination_url']!=''):
?>
<input id="pgu" type="hidden" name="pgu" value="<?=Yii::$app->session['pagination_url']?>">
<?php 
$this->registerJs(
		"var url=$('#pgu').val();
		$('.admin-content').load(url);"
		);
 ?>
<?php endif; ?>
	<div class="col-lg-9 col-md-7 col-sm-7  col-xs-12">
	<div class="admin-content">
		
	</div>
	</div>
	<div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
		<div class="admin-items">
			<div class="admin-item">
				<span class="glyphicon glyphicon-list-alt"></span><span>&nbsp;مدیریت آگهی</span>
				<li><a href="agahi/create">ایجاد</a></li>
				<li><a href="agahi/view">ویرایش</a></li>
			</div>
			<div class="admin-item">
				<span class="glyphicon glyphicon-cog"></span><span>&nbsp;مدیریت تنظیمات</span>
				<li><a href="agahi/setting">ویرایش تنظیمات</a></li>
			</div>
			<div class="admin-item">
				<span class="glyphicon glyphicon-flag"></span><span>&nbsp;مدیریت گزارشات</span>
				<li><a href="report/index">ویرایش گزارشات</a></li>
			</div>
			<div class="admin-item">
					<span class="glyphicon glyphicon-info-sign"></span><span>&nbsp;مشخصات من</span>
					<li><a href="users/changepassword">تغییر رمز عبور</a></li>
					<li><a href="users/updateprofile">ویرایش اطلاعات</a></li>
			</div>
			<?php if (Yii::$app->session['enum']=='admin'): ?>
				<div class="admin-item">
					<span class="glyphicon glyphicon-user"></span><span>&nbsp;مدیریت کاربران</span>
					<li><a href="users/create">ایجاد کابر</a></li>
					<li><a href="users/view">ویرایش کاربران</a></li>
				</div>
				<div class="admin-item">
					<span class="glyphicon glyphicon-th-list"></span><span>&nbsp;مدیریت دسته بندی ها</span>
					<li><a href="category/create">ایجاد</a></li>
					<li><a href="category/edit">ویرایش</a></li>
				</div>
				<div class="admin-item">
					<span class="glyphicon glyphicon-globe"></span><span>&nbsp;مدیریت شهرها و محله ها</span>
					<li><a href="city/create">ایجاد شهر</a></li>
					<li><a href="city/createmahale">ایجاد محله</a></li>
					<li><a href="city/view">ویرایش شهر ها و محله ها</a></li>
				</div>
			<?php endif ?>
			
		</div>
	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!--Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">برگشت</button>
			</div>
		</div>
	</div>
</div>
