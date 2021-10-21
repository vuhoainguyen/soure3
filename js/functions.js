function pushState(options,targetTitle,targetUrl) {
	window.history.pushState(options, targetTitle, targetUrl);
	/*get state console.log(window.history.state);*/
}
function goToByScroll(id) {
    id = id.replace("#", "");
    $('html,body').animate({
        scrollTop: $("#" + id).offset().top
    }, 'slow');
}
function doSearch(options) {
	if(!options) options = {};
	var url = '';
	$.each(options, function(k, v) {
		url += '&'+k+'='+v;
	});
	// url = url.substr(1);
	$.ajax({
		url: _BASE + 'tim-kiem'+url,
		type: 'GET',
		dataType: 'json',
		success: function(data){
			$('#search-body').html(data.res);
			$('#search-page').addClass('show-ajax');
			$('#search-page').html(data.page);
			_BMWEB.lazyloadImage();
		}
	});
	
}
function searchEnter(t){
	var k = t.val();
	var url;
	if(k!=''){
		url = '&keywords='+k;
		window.location.href = _BASE + 'tim-kiem'+url;
	}else{
		alert(lang.ban_chua_nhap_tu_khoa);
	}
}
function onChangeSelect(e,p){
    $.ajax({
        url: _BASE + 'ajax/load_item.php',
        type: 'POST',
        data: {p: p},
        success: function(data){
            $(e).html(data);
        }
    });
}
function loadScrollPage(url,type,width,height,ele){
	var a=!1;
	$(window).scroll(function(){
		$(window).scrollTop()>10 && !a&&($('#'+ele).load('ajax/load_addons.php?url='+url+'&width='+width+'&height='+height+'&type='+type),a=!0)
	});
}
function getResult(url,eShow='',rCount=0) {
	$.ajax({
		url: _BASE + '/' + url,
		type: "GET",
		data: {
			rowcount: rCount,
			eShow: eShow,
		},
		success: function(data){
			$(eShow).html(data);
			_BMWEB.lazyloadImage();
		}
   });
}