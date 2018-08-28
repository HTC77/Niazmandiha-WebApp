$(document).ready(function() {
	$('#users-captcha').attr('autocomplete','off');
	$('#loginform-captcha').attr('autocomplete','off');
	var url="http://localhost/web/";
	var width=$(window).width();
	var pagination_url='';
	var backbtn=false;
	var mahale_pagination_url='';
	var chu=window.location.href;
	if($('.navbar').height() > 53 && $('.navbar').height() < 141)
	{
		$('body').css('margin-top','115px');
	}else if ($('.navbar').height() > 141 && $('.navbar').height() < 143)
	{
		$('body').css('margin-top','160px');
	}
	else{
		$('body').css('margin-top','0px');
	}
	$(window).resize(function(){
		if($('.navbar').height() > 53 && $('.navbar').height() < 141)
		{
			$('body').css('margin-top','115px');
		}else if ($('.navbar').height() > 141 && $('.navbar').height() < 143)
		{
			$('body').css('margin-top','160px');
		}
		else{
			$('body').css('margin-top','0px');
		}
	});
	if(!chu.includes('city') && $('#change-city').val()==null){
		$.post(url+'site/cities',function(res){
			res=JSON.parse(res);
			if(res){
				$.each(res,function(i){
					if(res[i].persian_name!=undefined && i!=res.length-1)
					res[i].persian_name!=res[res.length-1].persian_name? $('#change-city').append('<option value="'+res[i].latin_name+'" class="form-control">'+res[i].persian_name+'</option>'):$('#change-city').append('<option selected value="'+res[i].latin_name+'" class="form-control">'+res[i].persian_name+'</option>');
				});
			}
		});
	}
	function getParents(){
		$.post(url+'category/getparent',{get_parent:'true'},function(res){
		res=JSON.parse(res);
		if(res!=[]){
			$('#categories').empty();
			$('.btn-back').css('display','none');
			$('#categories').append('<li id="parent_0"><a href="#">همه دسته ها</a></li>' );
			$.each(res,function(i){
				$('#categories').append('<li id="parent_'+res[i].id+'"> <a href="#" >'+res[i].onvan+'</a></li>' );
			});
		}		
		});
	}
	function getAgahi(res){
		var agahi_html="";
		$.each(res,function(i){
			if(res[i].pic=="no")
			{
				res[i].pic=url+'img/nopic.png';
			}
			else
			{
				res[i].pic=url+'uploads/'+res[i].pic.split('|',1);
			}
				agahi_html+='<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
					agahi_html+='<article>';
						agahi_html+='<div class="agahi-item">';
							agahi_html+='<div class="agahi-details">';
								agahi_html+='<div class="onvan" id="row_agahi-'+res[i].id+'">';
									agahi_html+='<p>'+res[i].onvan+'</p>';
								agahi_html+='</div>';
								agahi_html+='<div class="pic">';
									agahi_html+='<a target="_blank" href="site/details/id/'+res[i].id+'">';
										agahi_html+='<img width="100%" height="100%" src="'+res[i].pic+'">';
									agahi_html+='</a>';
								agahi_html+='</div>';
								agahi_html+='<div class="mahale"><strong>'+res[i].mahale+'</strong></div>';
								agahi_html+='<div class="date">'+res[i].tarikh+'</div>';
							agahi_html+='</div>';
							var re = /^[آ-ِیA-Za-z]+$/;
							if(!re.test(res[i].price))res[i].price+=' تومان';
							agahi_html+='<div class="price"><span>قیمت: '+res[i].price+'</span></div>';
						agahi_html+='</div>';
					agahi_html+='</article>';
				agahi_html+='</div>';
			$('.agahiha .row').append(agahi_html);
			agahi_html='';
		});
	}
	var parent_id='';
	var child_id='';
	var limit=0; 
	var req='';
	var txt;
	var picture;
	var mahale;
	$(document).on('click','li[id^="parent_"]',function(){
		parent_id=$(this).attr('id');
		parent_id=parent_id.substring(parent_id.lastIndexOf('_')+1);
			if(parent_id==0){
				$('#search-form #search-txt').val('');
				$('#search-form #search-mahale').val('');
				$('#search-form #search-picture').prop('checked',false);
				req='';
				limit=0;
				$.post('agahi/get',{get_agahi:true,lim:limit},function(res){
				$('.agahiha .row').empty();
				res=JSON.parse(res);
				if(res!=[]){
					getAgahi(res);
				}
				});
			}
			else{	
				$.post(url+'category/getchild',{get_child:'true',p_id:parent_id},function(res){
					res=JSON.parse(res);
					$('#categories').empty();
					if(res!=[])
					{	
						$('.btn-back').css('display','block');backbtn=true;
						$.each(res,function(i){
							$('#categories').append('<li id="child_'+res[i].id+'"> <a href="#" >'+res[i].onvan+'</a></li>' );
						});
					}
				});
			}
	});//parent_
	
	$('.btn-back').click(function(){
		getParents();
	});

	$(document).on('click','li[id^="child_"]',function(){
		req='getchild';
		limit=0;
		child_id=$(this).attr('id');
		child_id=child_id.substring(child_id.lastIndexOf('_')+1);
		$.post('agahi/getwithchild',{get_with_child:true,ch_id:child_id,lim:limit},function(res){
			$('.agahiha .row').empty();
			res=JSON.parse(res);
			if(res!=[]){
				$('#search-form #search-txt').val('');
				$('#search-form #search-mahale').val('');
				$('#search-form #search-picture').prop('checked',false);
				getAgahi(res);
			}
			else{
				$('.agahiha .row').empty();
			}
		});
	});//child_

	var chu=window.location.href;
	chu=chu.lastIndexOf('/');
	if(chu==20){//check if home page
		var lastHeight=0;		
		$(window).scroll(function(){
			var docScrolled=$(this).height()+$(this).scrollTop();
			var docHeight=document.body.offsetHeight;
			if(docScrolled>=docHeight && docHeight!=lastHeight){
				lastHeight=docHeight;
				if(req==''){
					limit+=8;
					$.post('agahi/get',{get_agahi:true,lim:limit},function(res){
						res=JSON.parse(res);
						if(res!=[]){
							getAgahi(res);
						}
					});
				}else if(req=='getchild'){
					limit+=8;
					$.post('agahi/getwithchild',{get_with_child:true,ch_id:child_id,lim:limit},function(res){
						res=JSON.parse(res);
						if(res!=[]){
							getAgahi(res);
						}
					});
				}else if(req=='search'){
					limit+=8;
					$.post('agahi/getwithsearch',{get_with_search:true,text:txt,m_id:mahale,pic:picture,lim:limit},function(res){
						res=JSON.parse(res);
						if(res!=[]){
							getAgahi(res);
						}
					});
				}//else search
			}//if scroll-top
		});//if window scroll
	}//check if is home page

	$('#search-form').on('beforeSubmit',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		//get categories
		if(backbtn){
			getParents();
			backbtn=false;
		}
		txt=$('#search-txt').val();
		mahale=$('#search-mahale').val();
		picture=$('#search-picture').is(':checked')?true:false;
		req='search';
		limit=0;
		$.post('agahi/getwithsearch',{get_with_search:true,text:txt,m_id:mahale,pic:picture,lim:limit},function(res){
			$('.agahiha .row').empty();
			res=JSON.parse(res);
			if(res!=[]){
				getAgahi(res);
			}
			if($('.agahiha .row').is(':empty')){
					$('.agahiha .row').append('<div align="center" style="color:yellow"> <h4>نتیجه ای پیدا نشد.</h4>	</div>');
			}
		});
		return false;
	});//Search form

	function render(view){
		$('.admin-content').load(url+view,function(){
			if(view.includes('city')){
				$('tr th:nth-child(5)').html('محله ها');
			}else if(view.includes('agahi')){
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
			}
		});
	}
	function fullRender(url){
		$('.admin-content').load(url);
	}
	function mahaleRender(url){
		$('#myModal .modal-body').load(url,function(){
			$('th a').click(function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
				return false;
			});
			$('[data-toggle="tooltip"]').tooltip();
		});
	}
	$('.admin-items a').click(function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var page=$(this).attr("href");
		pagination_url='/web/'+page;
		$.post('/web/agahi/session',{pg:'/web/'+page,action:'create'});
		render(page);
		return false;
	});

	$(document).on('click','.agahi-action',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id=$(this).attr("id");
		var url=$(this).attr("href");
		if(url.includes("details")){
			$.post(url,{a_id:id},function(res){	
				res=JSON.parse(res);
				if(res!=[]){
					$('#myModal .modal-header h4').html('&nbsp;مشاهده کامل آگهی شماره '+id);
					$('#myModal .modal-body').html(res);
					$('#myModal').modal('show');
				}
			});
		}if(url.includes("delete")){
			$('#deleteModal .modal-header h4').html('&nbsp;حذف آگهی شماره '+id);
			$('#deleteModal #yes').attr({'a_id':+id,'url':url});
			$('#deleteModal').modal('show');
		}if(url.includes("update")){
			$.post(url,{a_id:id},function(res){				
			if(res!=[]){
				$('#myModal .modal-header h4').html('&nbsp;ویرایش آگهی شماره '+id);
				$('#myModal .modal-body').html(res);
				$('#myModal').modal('show');
			}
			});
		}
		return false;
	});

	$(document).on('click','.user-action',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id=$(this).attr("id");
		var url=$(this).attr("href");
		if(url.includes("delete")){
			$('#deleteUserModal .modal-header h4').html('&nbsp;حذف کاربر شماره '+id);
			$('#deleteUserModal #yes').attr({'u_id':+id,'url':url});
			$('#deleteUserModal').modal('show');
		}if(url.includes("update")){
			$.post(url,{u_id:id},function(res){				
			if(res!=[]){
				$('#myModal .modal-header h4').html('&nbsp;ویرایش کاربر شماره '+id);
				$('#myModal .modal-body').html(res);
				$('#myModal').modal('show');
			}
			});
		}
		return false;
	});
	$(document).on('click','.city-action',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id=$(this).attr("id");
		var url=$(this).attr("href");
		if(url.includes("delete")){
			$('#deleteCityModal #yes').attr({'c_id':+id,'url':url});
			$('#deleteCityModal .modal-header h4').html('&nbsp;حذف شهر شماره '+id);
			$('#deleteCityModal').modal('show');
		}if(url.includes("update")){
			$.post(url,{c_id:id},function(res){				
			if(res!=[]){
				$('#myModal .modal-header h4').html('&nbsp;ویرایش شهر شماره '+id);
				$('#myModal .modal-body').html(res);
				$('#myModal').modal('show');
			}
			});
		}
		return false;
	});
	$(document).on('click','.mahale-action',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id=$(this).attr("id");
		var url=$(this).attr("href");
		if(url.includes("delete")){
			$('#deleteMahaleModal .modal-header h4').html('&nbsp;حذف محله شماره '+id);
			$('#deleteMahaleModal #yes').attr({'m_id':+id,'url':url});
			$('#deleteMahaleModal').modal('show');
		}if(url.includes("update")){
			$.post(url,{m_id:id,pgu:pagination_url,m_pgu:mahale_pagination_url},function(res){				
			if(res!=[]){
				$('#updateMahaleModal .modal-header h4').html('&nbsp;ویرایش محله شماره '+id);
				$('#updateMahaleModal .modal-body').html(res);
				$('#updateMahaleModal').modal('show');
			}
			});
		}
		return false;
	});


	$(document).on('click','#deleteModal .delete-action',function(){
		var d_id=$(this).attr("id");
		if(d_id=='yes'){
			var id=$(this).attr("a_id");
			var url=$(this).attr("url");
			$.post(url,{a_id:id},function(res){
				$('#deleteModal').modal('hide');
				if(pagination_url!=''){
					fullRender(pagination_url);
				}else{
					render('agahi/view');
				}
			});
		}else{
			$('#deleteModal').modal('hide');
		}
	});
	$(document).on('click','#deleteUserModal .delete-action',function(){
		var d_id=$(this).attr("id");
		if(d_id=='yes'){
			var id=$(this).attr("u_id");
			var url=$(this).attr("url");
			$.post(url,{u_id:id},function(res){
				$('#deleteUserModal').modal('hide');
				if(pagination_url!=''){
					fullRender(pagination_url);
				}else{
					render('users/view');
				}
			});
		}else{
			$('#deleteUserModal').modal('hide');
		}
	});
	$(document).on('click','#deleteCityModal .delete-action',function(){
		var d_id=$(this).attr("id");
		if(d_id=='yes'){
			var id=$(this).attr("c_id");
			var url=$(this).attr("url");
			$.post(url,{c_id:id},function(res){
				$('#deleteCityModal').modal('hide');
				if(pagination_url!=''){
					fullRender(pagination_url);
				}else{
					render('city/view');
				}
			});
		}else{
			$('#deleteCityModal').modal('hide');
		}
	});
	$(document).on('click','#deleteMahaleModal .delete-action',function(){
		var d_id=$(this).attr("id");
		if(d_id=='yes'){
			var id=$(this).attr("m_id");
			var url=$(this).attr("url");
			$.post(url,{m_id:id},function(res){
				if(pagination_url!=''){
					fullRender(pagination_url);
				}else{
					render('city/view');
				}
				mahaleRender(mahale_pagination_url);
				$('#deleteMahaleModal').modal('hide');
			});
		}else{
			$('#deleteMahaleModal').modal('hide');
		}
	});

	$(document).on('click','#change_taeed',function(){
		var ok=$(this).attr("data-ok")=='true'?1:0;
		var id=$(this).attr("data-id");
		var taeed_html='<input type="checkbox" checked="true" id="change_taeed" name="change_taeed" data-ok="false" data-id="'+id+'"/>تأیید'+'<span class="submited-agahi">تأیید شده</span>';
		var notTaeed_html='<input type="checkbox" id="change_taeed" name="change_taeed" data-ok="true" data-id="'+id+'"/>تأیید '+'<span class="not-submited-agahi">تأیید نشده</span>';	
		$.post(url+'agahi/changetaeed',{a_id:id,a_state:ok},function(res){
			res=JSON.parse(res);
			if(res==true){
				if(ok==1){
					$('tr[data-key="'+id+'"] td:nth-child(7)').html(taeed_html);
				}else{
					$('tr[data-key="'+id+'"] td:nth-child(7)').html(notTaeed_html);
				}
			}
		});
	});
	$(document).on('click','#chenge_set',function(){
		var city_id=$('#change_city').val();
		$.post(url+'agahi/setting',{city:city_id});
	});
	$('.pictures-details img').click(function(){
		var src=$(this).attr("src");
		$('.selected-picture').html('<img src="'+src+'" width="100%" height="100%">');
	});
	$('#save-report').click(function(){
		var report_id=$('#selected-report').val();
		var agahi_id=$(this).attr("a-id");
		$.post('/web/report/savereport',{r_id:report_id,a_id:agahi_id},function(res){
			res=JSON.parse(res);
			if(res){
				$('#report-message').css('display','block');
				$('#report-message').html('<h4>.با تشکر! گزارش شما با موفقیت ثبت شد</h4>');
				$('#myModal').modal('hide');
			}else{
				$('#report-message').css('display','block');
				$('#myModal').modal('hide');
				$('#report-message').html('<h4>.با تشکر!  گزارش شما قبلاً ثبت شده است</h4>');
			}
		})
	});
	$(document).on('click','.report-action',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var res=false;
		var report_id=$(this).attr("id");
		$.post('/web/report/delete',{r_id:report_id},function(res){
			res=JSON.parse(res);
			if(res){
				if(pagination_url!=''){
					fullRender(pagination_url);
				}else{
					render('report/index');
				}
			}
		});
		return false;
	});

	$(document).on('click','.v-mahale .pagination a',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		mahale_pagination_url=$(this).attr('href');
		mahaleRender(mahale_pagination_url);
		return false;
	});
	$(document).on('click','.pagination a',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		pagination_url=$(this).attr('href');
		$.post('/web/agahi/session',{pg:pagination_url,action:'create'});
		fullRender(pagination_url);
		return false;
	});

	$(document).on('click','.m-action',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id=$(this).attr("id");
		var url=$(this).attr("href");
		var city=$(this).attr("city");
		$.post('/web/city/session',{c_id:id},function(){
			$.post(url,function(res){				
			if(res!=[]){
				mahale_pagination_url=url;
				$('#myModal .modal-header h4').html('&nbsp;ویرایش محله های شهر '+city);
				$('#myModal .modal-body').html(res);
			}
			});
		});
		return false;
	});
	$(document).on('click','.admin-nav  a',function(e){
		var url=$(this).attr("href");
		e.preventDefault();
		e.stopImmediatePropagation();
		$.post('/web/agahi/session',{action:'remove'},function(){
			window.location.replace(url);
		});
		return false;
	});
	$(document).on('change','#change-city',function(){
		var city_val=$(this).val();
		$.post(url+'site/cities',{city:city_val},function(){
			window.location.replace(url);
		});
	});
	$(document).on('click','.report-agahi tr td:nth-child(3)',function(){
		var id=$(this).html();
		$.post(url+'agahi/update',{a_id:id},function(res){				
		if(res!=[]){
			$('#myModal .modal-header h4').html('&nbsp;ویرایش آگهی شماره '+id);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
		});
	});
	$(document).on('click','#updateMahaleModal .modal-footer .btn',function(){
		
			$('#updateMahaleModal').modal('hide');
			
	});
	$(document).on('click','#deleteMahaleModal .modal-footer .btn',function(){
		
			$('#deleteMahaleModal').modal('hide');

	});
	$(document).on('click','#updateMahaleModal .modal-header .close',function(){
			
			$('#updateMahaleModal').modal('hide');
				
	});
	$(document).on('click','#deleteMahaleModal .modal-header .close',function(){
		
			$('#deleteMahaleModal').modal('hide');

	});
	$(document).on('click','#newPasswordModal .modal-header .close',function(){
			
			$('#newPasswordModal').modal('hide');

	});
	$(document).on('click','.create-new-password',function(){
		var id=$(this).attr('id');
		$.post('/web/users/assignpassword',{u_id:id},function(res){				
			if(res!=[]){
				$('#newPasswordModal .modal-header h4').html('&nbsp;تخصیص پسورد جدید برای کاربر شماره '+id);
				$('#newPasswordModal .modal-body').html(res);
				$('#newPasswordModal').appendTo('body').modal('show');
			}
		});
	});
});