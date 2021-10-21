var $window = $(window),
    $document = $(document);
$.fn.exists = function() {
    return this.length > 0;
};

_BMWEB.backToTop = function(){
	if ($('#back-to-top').length > 0) {
		var scrollTrigger = 200, // px
			backToTop = function () {
				var scrollTop = $(window).scrollTop();
				if (scrollTop > scrollTrigger) {
					$('#back-to-top').addClass('show');
				} else {
					$('#back-to-top').removeClass('show');
				}
			};
		backToTop();
		$(window).on('scroll', function () {
			backToTop();
		});
		$('#back-to-top').on('click', function (e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 700);
		});
	}

	if($('.top-copy').length > 0){
		$('.top-copy').on('click', function (e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 700);
		});
	}
}

_BMWEB.aweOwl = function() {
	var owl = $('.owl-carousel.in-home');
  	owl.each( function(){
		var xs_item = $(this).attr('data-xs-items');
		var md_item = $(this).attr('data-md-items');
		var lg_item = $(this).attr('data-lg-items');
		var sm_item = $(this).attr('data-sm-items');	
		var margin=$(this).attr('data-margin');
		var dot=$(this).attr('data-dot');
		var nav=$(this).attr('data-nav');
		var height=$(this).attr('data-height');
		var play=$(this).attr('data-play');
		var loop=$(this).attr('data-loop');
		var animateOut=$(this).attr('data-animateOut');
		var animateIn=$(this).attr('data-animateIn');
		
		if (typeof margin !== typeof undefined && margin !== false) {    
		} else{
			margin = 30;
		}
		if (typeof xs_item !== typeof undefined && xs_item !== false) {    
		} else{
			xs_item = 1;
		}
		if (typeof sm_item !== typeof undefined && sm_item !== false) {    

		} else{
			sm_item = 3;
		}	
		if (typeof md_item !== typeof undefined && md_item !== false) {    
		} else{
			md_item = 3;
		}
		if (typeof lg_item !== typeof undefined && lg_item !== false) {    
		} else{
			lg_item = 3;
		}

		if (loop == 1) { loop = true; } else{ loop = false; }
		if (dot == 1) { dot = true; } else{ dot = false; }
		if (nav == 1) { nav = true; } else{ nav = false; }
		if (play == 1) { play = true; } else{ play = false; }
		if (animateOut ==0 ) { animateOut = false; }
		if (animateIn ==0) { animateIn = false; }
		
		$(this).owlCarousel({
			loop: loop,
			margin:Number(margin),
			responsiveClass:true,
			dots:dot,
			nav:nav,
			navText: ['<div class="owlleft"><svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;"><polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline></svg></div>','<div class="owlright"><svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;"><polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline></svg></div>'],
			autoplay:play,
			autoplayTimeout: 4000,
			smartSpeed: 3000,
			autoplayHoverPause:true,
			autoHeight:false,
			animateOut: animateOut,
			animateIn: animateIn,
			responsive:{
				0:{
					items:Number(xs_item)				
				},
				600:{
					items:Number(sm_item)				
				},
				1000:{
					items:Number(md_item)				
				},
				1200:{
					items:Number(lg_item)				
				}
			}
		})
	});

	/*$('.owl-carousel.home-slider').on('change.owl.carousel', function(e) {
	    var index = e.item.index;
	   	console.log(index);
	   	$('.box-slider').removeClass('animated fadeInRight');
    	$('.box-slider').eq(index).addClass('animated fadeInRight');
	});*/
};
_BMWEB.slickPage = function(){
	if($('.slick-in-product').length > 0){
		$('.slick-in-product').slick({
		  	dots: false,
		  	slidesToShow: 2,
		  	slidesToScroll: 1,
		  	infinite: true,
  			speed: 1000,
		  	autoplay: true,
		  	autoplaySpeed: 4000,
		  	vertical: true
		});
	}
	$('ul.why-list > li[data-slide]').click(function() {
		$('ul.why-list > li[data-slide]').removeClass('active');
		$(this).addClass('active');
	   	var slideno = $(this).data('slide');
	   	$('.slick-why').slick('slickGoTo', slideno - 1);
	 });
	if($('.slick.slick-page').length > 0){
		$('.slick.slick-page').each(function() {
			var dots = $(this).attr('data-dots');
			var infinite = $(this).attr('data-infinite');
			var speed = $(this).attr('data-speed');
			var vertical = $(this).attr('data-vertical');
			var arrows = $(this).attr('data-arrows');
			var autoplay = $(this).attr('data-autoplay');
			var autoplaySpeed = $(this).attr('data-autoplaySpeed');
			var centerMode =  $(this).attr('data-centerMode');
			var centerPadding =  $(this).attr('data-centerPadding');
			var slidesDefault =  $(this).attr('data-slidesDefault');
			var responsive =  $(this).attr('data-responsive');
			var xs_item = $(this).attr('data-xs-items');
			var md_item = $(this).attr('data-md-items');
			var lg_item = $(this).attr('data-lg-items');
			var sm_item = $(this).attr('data-sm-items');
			var slidesDefault_ar = slidesDefault.split(":");
			var xs_item_ar = xs_item.split(":");
			var sm_item_ar = sm_item.split(":");
			var md_item_ar = md_item.split(":");
			var lg_item_ar = lg_item.split(":");
			var to_show = slidesDefault_ar[0];
			var to_scroll = slidesDefault_ar[1];
			if (responsive == 1) { responsive = true; } else{ responsive = false; }
			if (dots == 1) { dots = true; } else{ dots = false; }
			if (arrows == 1) { arrows = true; } else{ arrows = false; }
			if (infinite == 1) { infinite = true; } else{ infinite = false; }
			if (autoplay == 1) { autoplay = true; } else{ autoplay = false; }
			if (centerMode == 1) { centerMode = true; } else{ centerMode = false; }
			if (vertical == 1) { vertical = true; } else{ vertical = false; }
			if (typeof speed !== typeof undefined && speed !== false) {    
			} else{ speed = 300; }
			if (typeof autoplaySpeed !== typeof undefined && autoplaySpeed !== false) {    
			} else{ autoplaySpeed = 2000; }
			if (typeof centerPadding !== typeof undefined && centerPadding !== false) {    
			} else{ centerPadding = "0px"; }
			var reponsive_json = [{
			      	breakpoint: 1024,
			      	settings: {
			        	slidesToShow: Number(lg_item_ar[0]),
			        	slidesToScroll: Number(lg_item_ar[1])
			      	}
			    },{
			      	breakpoint: 992,
			      	settings: {
			        	slidesToShow: Number(md_item_ar[0]),
			        	slidesToScroll: Number(md_item_ar[1])
			      	}
			    },{
			      	breakpoint: 768,
			      	settings: {
				        slidesToShow: Number(sm_item_ar[0]),
				        slidesToScroll: Number(sm_item_ar[1])
			      	}
			    },{
			      	breakpoint: 480,
			      	settings: {
			        	slidesToShow: Number(xs_item_ar[0]),
			        	slidesToScroll: Number(xs_item_ar[1])
			      	}
				}];
			if(responsive==1){
				$(this).slick({
					dots: dots,
					infinite: infinite,
					arrows: arrows,
					speed: Number(speed),
					vertical: vertical,
					slidesToShow: Number(to_show),
					slidesToScroll: Number(to_scroll),
					autoplay: autoplay,
					autoplaySpeed: Number(autoplaySpeed),
					responsive: reponsive_json
				});
			}else{
				$(this).slick({
					dots: dots,
					infinite: infinite,
					arrows: arrows,
					speed: Number(speed),
					vertical: vertical,
					slidesToShow: Number(to_show),
					slidesToScroll: Number(to_scroll),
					autoplay: autoplay,
					autoplaySpeed: Number(autoplaySpeed)
				});
			}
		});
	}
	
}
_BMWEB.aweOwlProduct = function() {
  	$('.owl-carousel.in-product').each( function(){
		var xs_item = $(this).attr('data-xs-items');
		var md_item = $(this).attr('data-md-items');
		var lg_item = $(this).attr('data-lg-items');
		var sm_item = $(this).attr('data-sm-items');	
		var margin=$(this).attr('data-margin');
		var dot=$(this).attr('data-dot');
		var nav=$(this).attr('data-nav');
		var height=$(this).attr('data-height');
		var play=$(this).attr('data-play');
		var loop=$(this).attr('data-loop');
		var center=$(this).attr('data-center');
		
		if (typeof margin !== typeof undefined && margin !== false) {    
		} else{
			margin = 30;
		}
		if (typeof xs_item !== typeof undefined && xs_item !== false) {    
		} else{
			xs_item = 1;
		}
		if (typeof sm_item !== typeof undefined && sm_item !== false) {    

		} else{
			sm_item = 3;
		}	
		if (typeof md_item !== typeof undefined && md_item !== false) {    
		} else{
			md_item = 3;
		}
		if (typeof lg_item !== typeof undefined && lg_item !== false) {    
		} else{
			lg_item = 3;
		}

		if (loop == 1) { loop = true; } else{ loop = false; }
		if (dot == 1) { dot = true; } else{ dot = false; }
		if (nav == 1) { nav = true; } else{ nav = false; }
		if (play == 1) { play = true; } else{ play = false; }
		if (center == 1) { center = true; } else{ center = false; }

		$(this).owlCarousel({
			loop: loop,
			margin:Number(margin),
			responsiveClass:true,
			dots:dot,
			nav:nav,
			autoplay:play,
			navText: ["<div class='owlleft-icon'><img src='images/arrow-left.jpg' alt='arrow-left' /></div>","<div class='owlright-icon'><img src='images/arrow-right.jpg' alt='arrow-right' /></div>"],
			autoplayTimeout: 4000,
			smartSpeed: 3000,
			autoplayHoverPause: true,
			autoHeight: false,
			center: center,
			responsive:{
				0:{
					items:Number(xs_item)				
				},
				600:{
					items:Number(sm_item)				
				},
				1000:{
					items:Number(md_item)				
				},
				1200:{
					items:Number(lg_item)				
				}
			}
		})
	});
};

_BMWEB.lazyloadImage = function() {
  	setTimeout(function(){
		var i = $("[data-lazyload]");
		i.length > 0 && i.each(function() {
			var i = $(this), e = i.attr("data-lazyload");
			i.appear(function() {
				i.removeAttr("height").attr("src", e);
			}, {
				accX: 0,
				accY: 168
			}, "easeInCubic");
		});
		var e = $("[data-lazyload2]");
		e.length > 0 && e.each(function() {
			var i = $(this), e = i.attr("data-lazyload2");
			i.appear(function() {
				i.css("background-image", "url(" + e + ")");
			}, {
				accX: 0,
				accY: 168
			}, "easeInCubic");
		});
	},100);
};

_BMWEB.addSubscribe = function(){
	if($('#subscribe-form').exists()){
		$("#subscribe-form").validate({
			rules: {
				email: {
					required: true,
					validateEmail: true,
					email: true
				},phone: {
					required: true
				}
			},
			messages: {
				email: {
					required: lang.chua_nhap_email,
					validateEmail: lang.email_chua_dung_dinh_dang,
					email: lang.email_chua_dung_dinh_dang
				},phone: {
					required: lang.chua_nhap_dien_thoai
				}
			},
			submitHandler: function(form) {
			    var o = $("#subscribe-form").find('#email');
			    var p = $("#subscribe-form").find('#phone');
				$.ajax({
					url: 'ajax/subscribe.php',
					type: 'POST',
					dataType: 'json',
					data: {v: o.val(),p: p.val(), t:'email'},
					success: function(res){
						if(res.status==200){
							alert(res.message);
							location.reload();
						}else{
							alert(res.message);
						}
					}
				});
			}
		});

		$.validator.addMethod("validateEmail", function (value, element) {
            return this.optional(element) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(value);
        }, lang.email_sai_dinh_dang);
		
	}

	if($('#contact-support').exists()){
		$("#contact-support").validate({
			rules: {
				'data[phone]': {
					required: true,
					minlength: 10
				},'data[fullname]': {
					required: true
				},'data[content]': {
					required: true
				},'data[email]': {
					required: true,
					email: true
				}
			},
			messages: {
				'data[phone]': {
					required: lang.chua_nhap_dien_thoai,
					minlength: lang.dien_thoai_sai_dinh_dang
				},'data[fullname]': {
					required: lang.chua_nhap_ho_ten
				},'data[content]': {
					required: lang.chua_nhap_noi_dung
				},'data[email]': {
					required: lang.chua_nhap_email,
					email: lang.email_chua_dung_dinh_dang
				}
			},
			submitHandler: function(form) {
			   form.submit();
			}
		});
	}
	if($('#contact-support-popup').exists()){
		$("#contact-support-popup").validate({
			rules: {
				'data[phone]': {
					required: true,
					minlength: 10
				},'data[fullname]': {
					required: true
				},'data[content]': {
					required: true
				},'data[email]': {
					required: true,
					email: true
				}
			},
			messages: {
				'data[phone]': {
					required: lang.chua_nhap_dien_thoai,
					minlength: lang.dien_thoai_sai_dinh_dang
				},'data[fullname]': {
					required: lang.chua_nhap_ho_ten
				},'data[content]': {
					required: lang.chua_nhap_noi_dung
				},'data[email]': {
					required: lang.chua_nhap_email,
					email: lang.email_chua_dung_dinh_dang
				}
			},
			submitHandler: function(form) {
			   form.submit();
			}
		});
	}
}

_BMWEB.addContact = function(){
	if($('#contact-form').exists()){
		$("#contact-form").validate({
			rules: {
				'data[fullname]': {
					required: true
				},
				'data[email]': {
					required: true,
					validateEmail2: true,
					email: true
				},
				'data[phone]': {
					required: true,
					validatePhone: true
				},
				'data[content]': {
					required: true
				},
			},
			messages: {
				'data[fullname]': {
					required: lang.chua_nhap_ho_ten
				},
				'data[email]': {
					required: lang.chua_nhap_email,
					validateEmail: lang.email_chua_dung_dinh_dang,
					email: lang.email_chua_dung_dinh_dang
				},
				'data[phone]': {
					required: lang.chua_nhap_dien_thoai,
					validateEmail: lang.dinh_dang_dien_thoai
				},
				'data[content]': {
					required: lang.chua_nhap_noi_dung
				}
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});

		$.validator.addMethod("validateEmail2", function (value, element) {
            return this.optional(element) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(value);
        }, lang.email_sai_dinh_dang);
        $.validator.addMethod("validatePhone", function (value, element) {
            return this.optional(element) || /^((09|03|07|08|05)+([0-9]{8}))+$/i.test(value);
        }, lang.dien_thoai_sai_dinh_dang);
		
	}
	
}

_BMWEB.changeSortby = function(){
	if($('#sort-by').exists()){
		$('body').on('click', '.change-sortby', function(event) {
			event.preventDefault();
			var o = $(this);
			var h = o.data('href');
			var s = o.data('sort');
			$('.change-sortby').removeClass('active');
			o.addClass('active');
			$('.show-sort-by').html(o.text() + ' <i class="fa fa-angle-down"></i>');
			var k = $('#keywords').val();
			var href = $('input[name=href]').val();
			var ks = '';
			if(k!=''){
				ks = '&keywords='+k;
			}
			pushState({sortby: s},'',h + ks + '&sortby='+s);
			doSearch({'href':href,  'alias':h, 'keywords': ks, 'sortby': s,'p':1});
		});
		$('body').on('click', 'a.page-link', function(event) {
			event.preventDefault();
			var o = $(this);
			var l = o.attr('href');
			var h = l.split("&");
			var options = {};
			var href = $('input[name=href]').val();
			options['href'] = href;
			$.each(h,function(i,v){
				if(i!=0){
					var f = v.split("=");
					options[f[0]] = f[1];
				}
			})
			pushState(options,'',l);
			console.log(options);

			doSearch(options);
		});
	}
	
}
_BMWEB.submitSearch = function(){
	$('input[role="search-input"]').keypress(function (e) {
	  if (e.which == 13) {
	    searchEnter($(this));
	  }
	});
	$('form[role=search] button').click(function (e) {
		var o = $(this).parent('form[role=search]').find('input[role="search-input"]');
	   	searchEnter(o);
	});
	$('input[role="search-input"]').placeholderTypewriter({text: placeholderText});
}
_BMWEB.owlDetail = function(){
	$('.product-detail-slider').owlCarousel({
        loop: false,
        margin: 5,
        responsiveClass: true,
        items: 4,
        dots: false,
        autoplay: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
    });
}
_BMWEB.tabDetail = function(){

	$(".e-tabs:not(.not-dqtab)").each( function(){
		$(this).find('.tabs-title li:first-child').addClass('current');
		$(this).find('.tab-content').first().addClass('current');
		$(this).find('.tabs-title li').click(function(){
			var tab_id = $(this).attr('data-tab');
			var url = $(this).attr('data-url');
			$(this).closest('.e-tabs').find('.tabs-title li').removeClass('current');
			$(this).closest('.e-tabs').find('.tab-content').removeClass('current');
			$(this).addClass('current');
			$(this).closest('.e-tabs').find("#"+tab_id).addClass('current');
		});    
	});

}

_BMWEB.addRegister = function(){
	if($('#regiter-form').exists()){
		$('#member_email').on('blur', function(event) {
			var _o = $(this);
			var _i = _o.val();
			$.ajax({
				url: _BASE + 'ajax/check_user.php',
				type: 'POST',
				dataType: 'json',
				data: { v: _i, e: 'not-exists' },
				success: function(data){
					if(data.status!=200){
						_o.addClass('error');
						if($('#member-email-error').length==0){
							_o.parent().append('<label id="member-email-error" style="display: block;" class="error">'+data.message+'</label>');
						}else{
							$('#member-email-error').css('display','block').html(data.message);
						}
					}else{
						_o.removeClass('error');
						$('#member-email-error').remove();
					}
				}
			});
			return false;
		});

		$("#regiter-form").validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
				'data[email]': {
					required: true,
					email: true
				},
				'data[phone]': {
					required: true,
					validatePhone: true
				},
				'data[password]': {
			        required: true,
			        validatePassword: true
			    },
			    'data[password-confirm]': {
			        required: true,
			        equalTo: "#member_password"
			    }
			},
			messages: {
				'data[email]': {
					required: lang.chua_nhap_email,
					validateEmail: lang.email_chua_dung_dinh_dang,
					email: lang.email_chua_dung_dinh_dang
				},
				'data[phone]': {
					required: lang.chua_nhap_dien_thoai,
					validatePhone: lang.dinh_dang_dien_thoai
				},
				'data[password]': {
		          required: lang.chua_nhap_mat_khau,
		          validateEmail: lang.mat_khau_khong_dung_dinh_dang
		        },
		        'data[password-confirm]': {
		          required: lang.chua_nhap_mat_khau_xac_nhan,
		          equalTo: lang.mat_khau_khong_trung
		        }
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});
        $.validator.addMethod("validatePhone", function (value, element) {
            return this.optional(element) || /^((09|03|07|08|05)+([0-9]{8}))+$/i.test(value);
        }, lang.dien_thoai_sai_dinh_dang);
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/i.test(value);
        }, lang.mat_khau_khong_dung_dinh_dang);
	}
}
_BMWEB.addLogin = function(){
	if($('#login-form').exists()){
		$("#login-form").validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
				'data[email]': {
					required: true,
					email: true
				},
				'data[password]': {
			        required: true,
			        validatePassword: true
			    }
			},
			messages: {
				'data[email]': {
					required: lang.chua_nhap_email,
					email: lang.email_chua_dung_dinh_dang
				},
				'data[password]': {
		          required: lang.chua_nhap_mat_khau
		        }
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});
	}
}
_BMWEB.addForgot = function(){
	if($('#forgot-form').exists()){
		$("#forgot-form").validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
				'data[email]': {
					required: true,
					email: true
				}
			},
			messages: {
				'data[email]': {
					required: lang.chua_nhap_email,
					email: lang.email_chua_dung_dinh_dang
				}
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});
	}
}
_BMWEB.addProfile = function(){
	if($('#profile-form').exists()){
		$("#profile-form").validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
				'data[address]': {
					required: true
				},
				'data[phone]': {
					required: true,
					validatePhone: true
				},
				'data[fullname]': {
					required: true
				}
			},
			messages: {
				'data[address]': {
					required: "Bạn chưa nhập địa chỉ"
				},
				'data[phone]': {
					required: lang.chua_nhap_dien_thoai,
					validatePhone: lang.dinh_dang_dien_thoai
				},
				'data[fullname]': {
		          required: lang.chua_nhap_mat_khau
		        }
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});
        $.validator.addMethod("validatePhone", function (value, element) {
            return this.optional(element) || /^((09|03|07|08|05)+([0-9]{8}))+$/i.test(value);
        }, lang.dien_thoai_sai_dinh_dang);
	}
}
_BMWEB.addResetPassword = function(){
	if($('#reset-password-form').exists()){
		$("#reset-password-form").validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
				'data[password-old]': {
			        required: true,
			        validatePassword: true
			    },
				'data[password]': {
			        required: true,
			        validatePassword: true
			    },
			    'data[password-confirm]': {
			        required: true,
			        equalTo: "#member_password"
			    }
			},
			messages: {
				'data[password-old]': {
		          required: lang.chua_nhap_mat_khau_cu,
		          validateEmail: lang.mat_khau_khong_dung_dinh_dang
		        },
				'data[password]': {
		          required: lang.chua_nhap_mat_khau,
		          validateEmail: lang.mat_khau_khong_dung_dinh_dang
		        },
		        'data[password-confirm]': {
		          required: lang.chua_nhap_mat_khau_xac_nhan,
		          equalTo: lang.mat_khau_khong_trung
		        }
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});
        $.validator.addMethod("validatePassword", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/i.test(value);
        }, lang.mat_khau_khong_dung_dinh_dang);
	}
}
_BMWEB.addAddress = function(){
	if($('#address-form').exists()){
		$("#address-form").validate({
			rules: {
				'data[address]': {
					required: true
				},
				'data[phone]': {
					required: true,
					validatePhone: true
				},
				'data[fullname]': {
					required: true
				},
				'data[id_city]': {
					required: true
				},
				'data[id_dist]': {
					required: true
				},
				'data[id_ward]': {
					required: true
				}
			},
			messages: {
				'data[address]': {
					required: lang.chua_nhap_ho_ten
				},
				'data[phone]': {
					required: lang.chua_nhap_dien_thoai,
					validatePhone: lang.dinh_dang_dien_thoai
				},
				'data[fullname]': {
		          required: lang.chua_nhap_mat_khau
		        },
				'data[id_city]': {
		          required: lang.chua_chon_tinh_thanh
		        },
				'data[id_dist]': {
		          required: lang.chua_chon_quan_huyen
		        },
				'data[id_ward]': {
		          required: lang.chua_chon_phuong_xa
		        }
			},
			submitHandler: function(form) {
			    fomr.submit();
			}
		});
        $.validator.addMethod("validatePhone", function (value, element) {
            return this.optional(element) || /^((09|03|07|08|05)+([0-9]{8}))+$/i.test(value);
        }, lang.dien_thoai_sai_dinh_dang);
	}
}
_BMWEB.checkDefaultAddress = function(){
	$('body').on('click', '.check-default', function(event) {
		event.preventDefault();
		var _o = $(this);
		var id = _o.data('id');
		var val = _o.data('val');
		var user = _o.data('user');
		var d = {
			id: id,
			val: val,
			user: user
		};
		$.ajax({
			url: 'ajax/check_default_address.php',
			type: 'POST',
			data: d,
			success: function(da){
				if(da==200){
					location.reload();
				}
			}
		});
	});
}
_BMWEB.collapsedFooter = function(){
	$('body').on('click', '.collapsed', function(event) {
		event.preventDefault();
		var _o = $(this);
		if(_o.hasClass('active')){
			_o.removeClass('active');
			_o.parents('.widget-ft').find('.collapse').stop().slideUp();
		}else{
			_o.addClass('active');
			_o.parents('.widget-ft').find('.collapse').stop().slideDown();
		}
	});
}
_BMWEB.listDatatable = function(){
	if($('.list-table').length){
		$('.list-table').DataTable({
	        searching: true,
	        ordering: true,
	        responsive: true,
	        scrollX: true,
	        pageLength: 25,
	        lengthChange: true,
	        lengthMenu: [
	            [10, 25, 50, 100, 200, -1],
	            [10, 25, 50, 100, 200, "All"]
	        ],
	        language: {
	            "decimal": "",
	            "emptyTable": lang.khong_co_du_lieu_trong_bang,
	            "info": lang.bat_dau + " _START_ " + lang.den + " _END_ " + lang.cua + " _TOTAL_ " + lang.muc,
	            "infoEmpty": lang.hien_thi + " 0 " + lang.den + " 0 " + lang.cua + " 0 " + lang.muc,
	            "infoFiltered": "(" + lang.duoc_loc_tu + " _MAX_ " + lang.tong_so_muc + ")",
	            "infoPostFix": "",
	            "thousands": ",",
	            "lengthMenu": lang.hien_thi + " _MENU_ " + lang.muc,
	            "loadingRecords": "Loading...",
	            "processing": "Processing...",
	            "search": lang.search + ":",
	            "zeroRecords": lang.khong_tim_thay_ket_qua,
	            "paginate": {
	                "first": lang.dau,
	                "last": lang.cuoi,
	                "next": lang.truoc,
	                "previous": lang.sau
	            },
	            "aria": {
	                "sortAscending": ": " + lang.kich_hoat_cot_tang_dan,
	                "sortDescending": ": " + lang.kich_hoat_cot_giam_dan
	            }
	        }
	    });
	}
}

_BMWEB.menuMobile = function(){
	$('body').on('click', 'span.btn-dropdown-menu', function() {
		var o = $(this);
		if(!o.hasClass('active')){
			o.addClass('active');
			o.next('.sub-menu').stop().slideDown(300);
		}else{
			o.removeClass('active');
			o.next('.sub-menu').stop().slideUp(300);
		}
	});	
	$('.menu-mobile').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$('.header-left-fixwidth').toggleClass('open-sidebar-menu');
		$('.opacity-menu').toggleClass('open-opacity');
	});
	$('.opacity-menu').click(function(e){
		$('.open-menu-header').removeClass('open-button');
		$('.header-left-fixwidth').removeClass('open-sidebar-menu');
		$('.opacity-menu').removeClass('open-opacity');
	});
}
_BMWEB.tabsProduct = function(){
	if($('.tabs').length > 0){
		$('body').on('click', '.tabs li', function() {
	        $('.tabs li').removeClass('active');
	        $(this).addClass('active');
	        $('.content-tab').css({height:'0',opacity:'0'});
	        var activeTab = $(this).attr('data-ref');
	        $(activeTab).css({height:'auto',opacity:'1'});
	        return false;
	    });
	    $('.tabs li:first').trigger('click');
	}
}
_BMWEB.tabsPage = function(){
	if($('.tabs-page').length > 0){
		$('body').on('click', '.tabs-page li', function() {
	        $('.tabs-page li').removeClass('active');
	        $(this).addClass('active');
	        $('.content-page').css({display:'none',opacity:'0'});
	        var activeTab = $(this).attr('data-ref');
	        $(activeTab).css({display:'block',opacity:'1'});
	        return false;
	    });
	    $('.tabs-page li:first').trigger('click');
	}
	if($('.tabs-click').length > 0){
		$('body').on('click', '.tabs-click', function() {
	        var idTab = $(this).attr('ref');
	        $('.tabs-click').removeClass('active');
	        $(this).addClass('active');
	        $(idTab).find('.content-tab').removeClass('show');
	        var activeTab = $(this).attr('rel');
	        var animateTab = $(this).attr('data-animate');
	        $(activeTab).addClass('show');
	        $(activeTab).find('.animate-div').css('opacity',0);
	        setTimeout(function(){
	        	$(activeTab).find('.animate-div').css('opacity',1).addClass(animateTab + ' animated');
	        },500);
	        return false;
	    });
	}
	if($('.tabs-why').length > 0){
		$('body').on('click', '.tabs-why', function() {
	        $('.tabs-why').removeClass('active');
	        $(this).addClass('active');
	        $('.content-tab-why').removeClass('show');
	        var activeTab = $(this).attr('rel');
	        $(activeTab).addClass('show');
	        return false;
	    });
	}

	if($('#tab-paging').length > 0){
		$('body').on('click', '.img-li', function() {
	        $(this).parents('.list-index').find('.img-li').removeClass('active');
	        $(this).addClass('active');
	        var id = $(this).data('id');
	        var el = $(this).data('el');
	        getResult("ajax/load_paging.php?listid=" + id,"#"+el,0);
	        return false;
	    });
	    $('.img-li:first').trigger('click');
	}
}
_BMWEB.popupIndex = function(){

	if($('#popup').length > 0){
		$('.open-popup').magnificPopup({
	      type:'inline',
	      midClick: true,
	      showCloseBtn: true,
	      closeOnBgClick: true,
	      closeBtnInside: true
	    });
	    setTimeout(function(){
	    	$('.open-popup').trigger('click');
	    },3000);
	}

	if($('.contact-popup-form').length>0){
		$(document).mouseup(function (e) {
		    var container = $(".contact-popup-form");
		    if (!container.is(e.target) && container.has(e.target).length === 0){
		        container.removeClass('active');
				$(".contact-popup-overlay").removeClass('active');
		    }
		});
		$('.popup-contact, a[href=#popup-contact]').click(function (e) {
			e.preventDefault();
			e.stopPropagation();
			$(".contact-popup-form").addClass('active');
			$(".contact-popup-overlay").addClass('active');
		});
	}
	if ($('.addThis_listSharing').length > 0) {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100) {
                $('.addThis_listSharing').addClass('is-show');
            } else {
                $('.addThis_listSharing').removeClass('is-show');
            }
        });
    }

}
_BMWEB.videoLoad = function(){
	if($('#video-load').length > 0){
		$('body').on('click', '.click-video', function() {
	        $('.list-video li').removeClass('active');
	        $(this).addClass('active');
	        var vl = $(this).attr('data-rel');
	        var id = $(this).attr('data-id');
	        $('#iframe-video').attr('src','https://www.youtube.com/embed/' + vl + '?rel=0&amp;autoplay=0&amp;wmode=transparent');
	        $.ajax({
	        	url: 'ajax/update_view.php',
	        	type: 'POST',
	        	dataType: 'html',
	        	data: {id: id,table:'videos'},
	        	success: function(data){
	        		$('#show-video'+id).html(data);
	        	}
	        });
	        return false;
	    });

	    $('body').on('change', '.change-video', function() {
	        var vl = $(this).val();
	        var id = $(this).find(':selected').data('id');
	        $('#iframe-video').attr('src','https://www.youtube.com/embed/' + vl + '?rel=0&amp;autoplay=0&amp;wmode=transparent');
	        $.ajax({
	        	url: 'ajax/update_view.php',
	        	type: 'POST',
	        	dataType: 'html',
	        	data: {id: id,table:'videos'},
	        	success: function(data){
	        		$('#show-video'+id).html(data);
	        	}
	        });
	        return false;
	    });
	}
}
_BMWEB.iconSearch = function(){
	$('body').on('click', '.search-icon', function() {
        if($(this).hasClass('active')){
        	$('#search-form').removeClass('open');
        	$(this).removeClass('active');
        	$(this).find('i').removeClass('fa-close').addClass('fa-search');
        }else{
        	$('#search-form').addClass('open');
        	$(this).addClass('active');
        	$(this).find('i').removeClass('fa-search').addClass('fa-close');
        }
        return false;
    });
}

_BMWEB.menuFixedTop = function(){
	$nav = $('.fixed-menu');
	$(window).scroll(function () {
		var h_slider = 0;
		var h_header = parseInt($('#header').height());
		if ($(this).scrollTop() > h_header) {
			$nav.addClass("fixed-open");
		} else {
			$nav.removeClass("fixed-open");
		}
	});
}



_BMWEB.clickFacebook = function(){
	$('body').on('click', '#quick-alo-Facebook', function(event) {
		event.preventDefault();
		$('.fanpage-fixed').addClass('show');
	});
	$('body').on('click', '.close-fanpage', function(event) {
		event.preventDefault();
		$('.fanpage-fixed').removeClass('show');
	});
}
_BMWEB.tocList = function(){
	if($(".toc-list").length > 0){
		$(".toc-list").toc({
	        content: "div#blog-detail",
	        headings: "h2,h3,h4"
	    });
	    $('.toc-list').find('a').click(function() {
	        var x = $(this).attr('data-rel');
	        goToByScroll(x);
	    });
	}
}
_BMWEB.clickPhone = function(){
	if($('#form-phone').length > 0){
		$('body').on('click', '#btn-phone', function(event) {
			event.preventDefault();
			var o = $(this);
			var v = $('#phone-res').val();
			var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
		    if(v !==''){
		        if (vnf_regex.test(v) == false) 
		        {
		            alert('Số điện thoại của bạn không đúng định dạng!');
		        }else{
		            $.ajax({
						url: 'ajax/subscribe.php',
						type: 'POST',
						dataType: 'json',
						data:  {p: v,t:'phone'},
						success: function(res){
							if(res.status==200){
								alert(res.message);
								location.reload();
							}else{
								alert(res.message);
							}
						}
					});
		        }
		    }else{
		        alert('Bạn chưa điền số điện thoại!');
		    }
			
		});
	}
}
_BMWEB.scrollNotIndex = function(){
	if(_INDEX==0){
		setTimeout(function(){
			$('html,body').animate({
		        scrollTop: $("#title-breadcrumbs").offset().top - 150
		    }, 'slow');
		},1000);
	}
}
_BMWEB.menuListPage = function(){
	$('body').on('click', '.menu-click-list', function() {
		var o = $(this);
		if(o.hasClass('active')){
			o.removeClass('active');
			$('.list-btn-position').removeClass('show');
			$('.opacity-menu-list').removeClass('open-opacity');
		}else{
			$('.opacity-menu-list').toggleClass('open-opacity');
			o.addClass('active');
			$('.list-btn-position').addClass('show');
		}
	});
	$('body').on('click', '.list-btn-position li span', function(e) {
		e.preventDefault();
		var o = $(this);
		if(o.hasClass('active')){
			o.removeClass('active');
			o.find('i').removeClass('fa-angle-left').addClass('fa-angle-right');
			o.next('ul').removeClass('open');
		}else{
			$('.list-btn-position li span').removeClass('active').find('i').removeClass('fa-angle-left').addClass('fa-angle-right');
			$('ul.list-btn-position').find('ul').removeClass('open');
			o.addClass('active').find('i').removeClass('fa-angle-right').addClass('fa-angle-left');
			o.next('ul').addClass('open');
		}
	});
	$('.opacity-menu-list').click(function(e){
		$('.menu-click-list').removeClass('active');
		$('.list-btn-position').removeClass('show');
		$('.opacity-menu-list').removeClass('open-opacity');
	});
}
$document.ready(function() {
	loadScrollPage('','maps','560','315','maps-load-frame');
	loadScrollPage(_LINK_YOUTUBE,'youtube','560','315','video-load-frame');
	_BMWEB.tocList();
	_BMWEB.clickFacebook();
	_BMWEB.slickPage();
	_BMWEB.iconSearch();
	_BMWEB.menuFixedTop();
	_BMWEB.collapsedFooter();
	_BMWEB.checkDefaultAddress();
	_BMWEB.scrollNotIndex();
	_BMWEB.menuListPage();
	/*
	_BMWEB.addAddress();
	_BMWEB.addResetPassword();
	_BMWEB.addProfile();
	_BMWEB.addForgot();
	_BMWEB.addLogin();
	_BMWEB.addRegister();
	_BMWEB.listDatatable();
	*/
	_BMWEB.clickPhone();
	_BMWEB.addContact();
	_BMWEB.submitSearch();
	_BMWEB.tabDetail();
	_BMWEB.changeSortby();
	_BMWEB.addSubscribe();
	_BMWEB.backToTop();
	_BMWEB.lazyloadImage();
	_BMWEB.owlDetail();
  	_BMWEB.aweOwl();
  	_BMWEB.aweOwlProduct();
  	_BMWEB.tabsProduct();
  	_BMWEB.tabsPage();
  	_BMWEB.videoLoad();
  	_BMWEB.popupIndex();
  	_BMWEB.menuMobile();
});
/*$(function() {
	var header = document.querySelector("#menu");

    var headroom = new Headroom(header, {
        tolerance: {
            down : 5,
            up : 0
        },
        offset : 5,
    });
    headroom.init();

    $(window).on("scroll", function() {
        if ($(window).scrollTop() > $('#top').innerHeight() + $('#header').innerHeight() + 20) {
            $("#menu").addClass("sticky");
        } else {
            $("#menu").removeClass("sticky")
        }
    });
});*/