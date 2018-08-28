<div class="agahi-setting">
	<label>تغییر شهر برای نمایش آگهی</label>
	<div class="form-group">
		<select class="form-control" id="change_city">
			<?php foreach ($city as $city): ?>
				<?php if($city->id!=$city_id): ?>
					<option value="<?=$city->latin_name?>"><?=$city->persian_name?></option>
				<?php else: ?>
					<option selected value="<?=$city->latin_name?>"><?=$city->persian_name?></option>
			<?php endif;endforeach ?>
		</select>
	</div>
	<div class="form-group">	
		<div class="btn btn-success" id="chenge_set">ثبت تنظیمات</div>
	</div>
</div>