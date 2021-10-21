var lastChecked = null;
function changeSlug(name,el,url='',title='',title_seo=''){
    var res = name.split("_");

    if($('#checkUrl'+res[1]).is(':checked')){
        // console.log('Khóa không cho thay đổi link');
        return false;
    }else{
        // console.log('Cho thay đổi link');
        var v = $('#'+name).val();
        var slug = getSlug(v);
        $('#'+el).val(slug);
        if(url!=''){
            $('#'+url).text(slug);
        }
        var seo = $('#'+title_seo).val();
        if(seo!=''){
            $('#'+title).text(seo);
        }else{
            $('#'+title).text(v);
        }
    }
}
function changeSeo(name,el,ty){
    var v = $('#'+name).val();
    if(ty=='null'){
        $('#'+el).text(v);
    }else{
        if(v!=''){
            $('#'+el).text(v);
        }else{
            $('#'+el).text($('#'+el).val());
        }
    }
}
function changeUrl(name,el){
    var v = $('#'+name).val();
    v = getSlug(v,'-');
    $('#'+name).val(v);
    $('#'+el).text(v);
}
function countChar(el) {
    var o = $('#'+el);
    var v = o.val();
    var min = parseInt(o.data('min'));
    var max = parseInt(o.data('max'));
    var len = parseInt(v.length);
    if(len < min || len > max){
        $('#status_'+el).removeClass('text-success').addClass('text-danger').text('Không tốt');
    }else{
        $('#status_'+el).removeClass('text-danger').addClass('text-success').text('Khá tốt');
    }
    $('#count_'+el).text(len);
}
function onChangePage(id,table,type,el_show,field_change){
    var data = {
        val: id,
        table: table,
        type: type,
        field_change: field_change
    };
    $.ajax({
        url: 'ajax/load_change.php',
        type: 'POST',
        data: data,
        success: function(da){
            $('#'+el_show).html(da);
        }
    });
}
function checkStatus(table,id,val,field,com,types,act){
    $.ajax ({
        type: "POST",
        url: "ajax/update_status.php",
        data: {i:id,t:table,v:val,f:field,co:com,ty:types,ac:act},
        dataType: 'json',
        success: function(result) {
            if(result.status==1){
                console.log('Đã cập nhật trạng thái');
            }else{
                alert('Bạn không có quyền check trạng thái này');
                location.reload();
            }
        }
    });
}
function changeField(field,table,id,val){
     var data = {
        val: val,
        table: table,
        id: id,
        field: field
    };
    $.ajax({
        url: 'ajax/update_change.php',
        type: 'POST',
        data: data,
        success: function(da){
            
        }
    });
}
function changeQty(code,id,q){
    var _d = {
        i: id,
        c: code,
        q: q,
        a: 'edit'
    };
    $.ajax({
        url: 'ajax/cart_admin.php',
        type: 'POST',
        data: _d,
        dataType: 'json',
        success: function(data){
            $('#price'+code).html(data.total_product_str);
            $('#totalQty').html(data.total_qty);
            $('#totalPriceSub').html(data.total_price_str_sub);
            $('#totalPrice').html(data.total_price_str);
            $('.money-cart').priceFormat({
                limit: 13,
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.',
                centsLimit: 0
            });
        }
    });
}
function GetMoneyText(a) {
    if (a <= 0) {
        return "0 đồng"
    }
    a = Math.round(a * 10) / 10;
    var b = "";
    var c = 0;
    if (a >= 1000000000) {
        c = Math.floor(a / 1000000000);
        b += c + " tỷ";
        a = a - (c * 1000000000)
    }
    if (a >= 1000000) {
        c = Math.floor(a / 1000000);
        b += c + " triệu ";
        a = a - (c * 1000000)
    }
    if (a >= 1000) {
        c = Math.floor(a / 1000);
        b += c + " ngàn ";
        a = a - (c * 1000)
    }
    a = Math.floor(a);
    if (a > 0) {
        b += a + " đồng";
    }
    return b.trim()
}
function onChangeSelect(e,p){
    $.ajax({
        url: 'ajax/load_item.php',
        type: 'POST',
        data: {p: p},
        success: function(data){
            $(e).html(data);
        }
    });
}

$(window).on('load', function(){
    class_ = localStorage.getItem('v');
    $('body').removeAttr('class').addClass('theme-' + class_);
});
$(document).ready(function() {
    $('body').on('click', '.click-submit', function(event) {
        $('input[name=save-add]').val($(this).attr('data-id'));
    });
    $('.change_alias').each(function(index, el) {
        var o = $(this);
        o.on('change', function(event) {
            event.preventDefault();
            var ob = $(this);
            var oi = ob.data('id');
            if(!$(this).is(':checked')){
                var ov = $('#name_'+oi).val();
                ov = getSlug(ov,'-');
                $('#alias_'+oi).val(ov);
                $('#url_seo_'+oi).text(ov);

            }
        });
    });

     $('body').on('click', '#login-btn', function(event) {
        var username = $('#username').val();
        var password = $('#password').val();
        var remember = $('#remember').val();
        var url = $('#login-form').attr('action');
        if (username && password){
            $.ajax({
                type: 'POST',
                url: 'ajax/users.php',
                data: {'username_log':username, 'password_log':password},
                dataType: 'json',
                success: function(data) {
                    if(data.status==200){
                        $.toast({
                            heading: '[' + data.status + '] Thông báo đăng nhập',
                            text: data.message,
                            position: 'top-right',
                            stack: false,
                            icon: 'success',
                            afterHidden: function () {
                                window.location.href = data.url;
                            }
                        });
                    }else{
                        $.toast({
                            heading: '[' + data.status + '] Thông báo lỗi đăng nhập',
                            text: data.message,
                            position: 'top-right',
                            stack: false,
                            icon: 'error'
                        });
                    }
                }
            });
        }
        else {
            return true;
        }
        return false;
    });
    if( $(".basic-multiple").length > 0){
        $(".basic-multiple").select2();
    }
   
    $('body').on('click', '.md-export', function(event) {
        event.preventDefault();
        var _o = $(this);
        var _h = _o.attr('href');
        window.location.href = _h;
    });
    $('#summernote').summernote({
        height: 200, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });
    $('.daterange').daterangepicker({
        opens: 'right',
        "applyButtonClasses": "btn-success",
        "cancelClass": "btn-light",
        "autoUpdateInput": false,
        "locale": {
          "cancelLabel": 'Clear'
        }
    }, function (start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    $('.daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('.start-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: false,
        locale: {
          format: 'DD/MM/YYYY'
        }
    }, function (start, end, label) {
        var years = moment().diff(start, 'years');
        console.log("You are " + years + " years old!");
    });
    $('.end-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: false,
        startDate: $('#end_date').attr('data-time'),
        locale: {
          format: 'DD/MM/YYYY'
        }
    }, function (start, end, label) {
        var years = moment().diff(start, 'years');
        console.log("You are " + years + " years old!");
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('body').on('keyup', '.update-numb', function(event) {
        event.preventDefault();
        var _o = $(this);
        var dataForm = {
            i:_o.data('id'),
            t:_o.data('table'),
            v:_o.val()
        };
        $.ajax({
            url: 'ajax/update_numb.php',
            type: 'POST',
            data: dataForm,
            dataType: 'json',
            success: function(data){
            }
        });
    });
    $('body').on('click', '#submit-tags', function(event) {
        event.preventDefault();
        var dataForm = $( "#form-tags" ).serialize();
        $.ajax({
            url: 'ajax/add_tag.php',
            type: 'POST',
            data: dataForm,
            dataType: 'json',
            success: function(data){
                $('#rowLog').html(data.htmlalert);
            }
        });
    });
    $('body').on('click', '#load-tags', function(event) {
        event.preventDefault();
        location.reload();
    });
    $('body').on('click', '.btn-save-export', function(event) {
        var _o = $(this);
        var _i = _o.data('id');
        window.location.href = 'ajax/export_order_detail.php?id='+_i;
    });
    $('body').on('click', '.btn-export-orders', function(event) {
        event.preventDefault();
        var _o = $(this);
        window.location.href = 'ajax/export_orders.php';
    });
    $('body').on('click', '.btn-save-print', function(event) {
        var _o = $(this);
        var _i = _o.data('id');
        var _t = _o.data('title');
        var contents = $("#print-"+_i).html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        frameDoc.document.write('<html><head><title>' + _t + '</title>');
        frameDoc.document.write('</head><body>');
        // frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    });
    $('body').on('keyup', '.update-qty', function(event) {
        var _o = $(this);
        changeQty(_o.data('code'),_o.data('pid'),_o.val());
    });
     $('body').on('click', '.btn-save-return', function(event) {
        var _o = $(this);
        var _i = _o.data('id');
        var _d = {
            i: _o.data('id'),
            a: 'return'
        };
        $.ajax({
            url: 'ajax/product.php',
            type: 'POST',
            data: _d,
            dataType: 'json',
            beforeSend: function() {
                $('#process'+_i).css('display','block').animate({width: '100%'}, 500);
            },
            success: function(data){
                setTimeout(function(){
                    $('#process'+_i).css('display','none').animate({width: '0%'}, 500);
                },500);
                setTimeout(function(){
                    location.reload();
                },800);
            }
        });
    });
    $('body').on('click', '.btn-save-order', function(event) {
        var _o = $(this);
        var _i = _o.data('id');
        var _o_t = $('#order_status'+_i).val();
        var _p_t = $('#payment_status'+_i).val();
        var _n = $('#note'+_i).val();
        var _d = {
            i: _o.data('id'),
            o_t: _o_t,
            p_t: _p_t,
            n: _n,
            a: 'save'
        };
        $.ajax({
            url: 'ajax/product.php',
            type: 'POST',
            data: _d,
            dataType: 'json',
            beforeSend: function() {
                $('#process'+_i).css('display','block').animate({width: '100%'}, 500);
            },
            success: function(data){
                setTimeout(function(){
                    $('#process'+_i).css('display','none').animate({width: '0%'}, 500);
                },700);
            }
        });
    });
    $('body').on('click', '.btn-remove', function(event) {
        var _o = $(this);
        var _d = {
            i: _o.data('pid'),
            c: _o.data('code'),
            a: 'delete'
        };
        $.ajax({
            url: 'ajax/cart_admin.php',
            type: 'POST',
            data: _d,
            dataType: 'json',
            success: function(data){
                _o.parents('tr#product'+_o.data('code')).remove();
                $('#totalQty').html(data.total_qty);
                $('#totalPriceSub').html(data.total_price_str_sub);
                $('#totalPrice').html(data.total_price_str);
                if(data.count==0){
                    location.reload();
                }
            }
        });
    });
    $('body').on('click', '.minus-btn', function(event) {
        var _o = $(this);
        var number_giohang = _o.next('input').val();
        if(number_giohang > 1){
            var number_change = parseInt(number_giohang) - 1;
            _o.next('input').val(number_change);
            changeQty($(this).data('code'),$(this).data('pid'),number_change);
        }
    });
    $('body').on('click', '.plus-btn', function(event) {
        var _o = $(this);
        var number_giohang = _o.prev('input').val();
        if(number_giohang < 1000){
            var number_change = parseInt(number_giohang) + 1;
            _o.prev('input').val(number_change);
            changeQty($(this).data('code'),$(this).data('pid'),number_change);
        }
    });
    $('body').on('keyup', '.sale-off', function(event) {
        var _o = $(this);
        var _d = {
            v: _o.val(),
            a: 'sale_off'
        };
        $.ajax({
            url: 'ajax/cart_admin.php',
            type: 'POST',
            data: _d,
            dataType: 'json',
            success: function(data){
               $('#totalPrice').html(data.total_price_str);
            }
        });
    });
    $('body').on('click', '.add-click', function(event) {
        var _o = $(this);
        var _i = _o.data('id');
        var _d = {
            i: _i,
            co: $('#color'+_i).val(),
            si: $('#size'+_i).val(),
            q: _o.data('qty'),
            a: 'add'
        };
        $.ajax({
            url: 'ajax/cart_admin.php',
            type: 'POST',
            data: _d,
            dataType: 'json',
            success: function(data){
                $('#loadAddCart').html(data.html);
                $('.money-cart').priceFormat({
                    limit: 13,
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    centsLimit: 0
                });
            }
        });
    });
    $('.money-cart').priceFormat({
        limit: 13,
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit: 0
    });
    /*$('.money-form').mask('000.000.000.000.000', {reverse: true});*/
    $('.money-form').priceFormat({
        limit: 13,
        prefix: '',
        centsLimit: 0
    });
    $('.skin-square .i-check input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
    $.validate();
    $(".select-customer").select2({
        placeholder: "Chọn khách hàng",
        allowClear: true
    });
    $('.checker-status').on( "click", function(){
      var v = $(this).val();
      var i = $(this).data('id');
      var t = $(this).data('table');
      var f = $(this).data('field');
      var com = $(this).attr("data-com");
      var types = $(this).attr("data-types");
      var act = $(this).attr("data-act");
      if($(this).is(':checked')){
        var arr = $('input[name="status'+i+'[]"]:checked').map(function(){
          return this.value;
        }).get().join(",");
      }else{
        var arr = $('input[name="status'+i+'[]"]:checked').map(function(){
          return this.value;
        }).get().join(",");
      }
      checkStatus(t,i,arr,f,com,types,act);
    });
    $('body').on('change', '#load_user', function(event) {
        var _o = $(this);
        var _d = {
            i: _o.val(),
        };
        $.ajax({
            url: 'ajax/load_info.php',
            type: 'POST',
            data: _d,
            dataType: 'json',
            success: function(data){
                console.log(data);
                if(data.status=200){
                    $('#email').val(data.item.email);
                    $('#phone').val(data.item.phone);
                    $('#address').val(data.item.address);
                    $('#fullname').val(data.item.fullname);
                    $('#id_city').val(data.item.id_city);
                    $('#id_dist').html(data.dist_option);
                }
            }
        });
    });
    $('body').on('click', '.click-cog', function(event) {
        if($(this).hasClass('active')){
            $('.color-themes-page').removeClass('active');
            $(this).removeClass('active');
        }else{
            $('.color-themes-page').addClass('active');
            $(this).addClass('active');
       }
    });
    $('body').on('click', '.color-themes-page li', function(event) {
        var o = $(this);
        var v = o.attr('class');
        var c = o.attr('data-color');
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem('v',v);
            localStorage.setItem('c',c);
            class_ = localStorage.getItem('v');
            color_ = localStorage.getItem('c');
            
            if(typeof chart_order !== "undefined"){
                window.setTimeout(function() {
                  chart_order.updateOptions({
                    colors: ['#'+color_]
                  });
                 
                }, 100);
            }
             if(typeof apexMixedChart !== "undefined"){
                window.setTimeout(function() {
                  apexMixedChart.updateOptions({
                    colors: ['#'+color_]
                  });
                }, 100);
            }

            $('body').removeAttr('class').addClass('theme-' + class_);
            
        } else {
            console.log('Sorry! No Web Storage support.');
        }

        /*var o = $(this);
        var v = o.attr('class');
        var c = o.attr('data-color');
        $.ajax({
            url: 'ajax/update_theme.php',
            type: 'POST',
            data: {v: v,c: c},
            success: function(data){
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        });*/
    });
    $('body').on('click', '.check-line', function(event) {
        var _o = $(this);
        if(_o.parent('.item-tr').hasClass('br-active')){
            _o.parent('.item-tr').removeClass('br-active');
            _o.parent('.item-tr').next('.item-trr').addClass('none-order').removeClass('bdr-active');
        }else{
            $('.item-tr').removeClass('br-active');
            $('.item-trr').addClass('none-order').removeClass('bdr-active');
            _o.parent('.item-tr').addClass('br-active');
            _o.parent('.item-tr').next('.item-trr').addClass('bdr-active').removeClass('none-order');
        }
        var _d = {
            i: _o.parent('.item-tr').data('id'),
            t: _o.parent('.item-tr').data('table'),
            v: 1
        };
        var v = _o.parent('.item-tr').data('view');
        if(v==0){
            $.ajax({
                url: 'ajax/check_view.php',
                type: 'POST',
                data: _d,
                dataType: 'json',
                success: function(data){
                    _o.parent('.item-tr').removeClass('font-bold');
                    _o.parent('.item-tr').attr('view',1);
                }
            });
        }
    });
    $('.deleteImg').click(function(event) {
        event.preventDefault();
        var _o = $(this);
        var _d = {
            t: _o.data('table'),
            p: _o.data('path'),
            i: _o.data('id'),
            f: _o.data('field')
        };
        $.confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa!',
            buttons: {
                success: {
                    text: 'Đồng ý!',
                    btnClass: 'btn-blue',
                    action: function(){
                        $.ajax({
                            url: 'ajax/delete_img.php',
                            type: 'POST',
                            data: _d,
                            dataType: 'json',
                            success: function(data){
                                if(data.status==200){
                                    _o.parents('.hinhanh').remove();
                                }
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Hủy ngay!',
                    btnClass: 'btn-red'
                }
            }
        });
    });
    $('.deleteImgMulti').click(function(event) {
        event.preventDefault();
        var _o = $(this);
        var _d = {
            t: _o.data('table'),
            p: _o.data('path'),
            i: _o.data('id'),
        };
        $.confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa!',
            buttons: {
                success: {
                    text: 'Đồng ý!',
                    btnClass: 'btn-blue',
                    action: function(){
                        $.ajax({
                            url: 'ajax/delete_img.php',
                            type: 'POST',
                            data: _d,
                            dataType: 'json',
                            success: function(data){
                                if(data.status==200){
                                    _o.parents('.imgMulti').remove();
                                }
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Hủy ngay!',
                    btnClass: 'btn-red'
                }
            }
        });
    });
    $('.basic').DataTable({
        iDisplayLength: 8,
        language: {
            oPaginate: {
                sNext: '<i class="ti-angle-right"></i>',
                sPrevious: '<i class="ti-angle-left"></i>'
            }
        },
        columnDefs: [
            { "orderable": false, "targets": 0 }
        ]
    });
    $('.nav-ngonngu li a').click(function(event) {
        var lang = $(this).attr('href');
        $('.nav-ngonngu li a').removeClass('active');
        $(this).addClass('active');
        $('.lang_hidden').removeClass('active');
        $('.lang_'+lang).addClass('active');
        return false;
    });
    var $chkboxes = $('.checker');
    $chkboxes.click(function(e) {
    if (!lastChecked) {
      lastChecked = this;
      return;
    }
    if (e.shiftKey) {
      var start = $chkboxes.index(this);
      var end = $chkboxes.index(lastChecked);
      $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', this.checked);
    }
    lastChecked = this;
    });
    $(".checkboxAll").click(function(){
      $('input.checker').not(this).prop('checked', this.checked);
    });
    $(".deleteChoose").click(function(event) {
        event.preventDefault();
        var h = $(this).attr('href');
        $.confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa!',
            autoClose: 'cancel|8000',
            buttons: {
                success: {
                    text: 'Đồng ý!',
                    btnClass: 'btn-blue',
                    action: function(){
                        var listid="";
                        $("input[name='chon']").each(function(){
                            if (this.checked) listid = listid+","+this.value;
                        })
                        listid=listid.substr(1);
                        if (listid=="") {
                            $.alert('Bạn chưa chọn mục nào');
                        }else{
                            window.location = h + "&listid=" + listid
                        }
                    }
                },
                cancel: {
                    text: 'Hủy ngay!',
                    btnClass: 'btn-red'
                }
            }
        });
    });
    $('.btn-send').click(function(event) {
        var listid="";
        $("input[name='chon']").each(function(){
            if (this.checked) listid = listid+","+this.value;
        })
        listid=listid.substr(1);
        if (listid=="") {
            $.alert('Bạn chưa chọn mục nào');
        }else{
            $('#form-newsletter').append('<input type="hidden" value="'+listid+'" name="listid" />')
        }
        $.confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn gửi!',
            autoClose: 'cancel|8000',
            buttons: {
                success: {
                    text: 'Đồng ý!',
                    btnClass: 'btn-blue',
                    action: function(){
                        $('#form-newsletter').submit();
                    }
                },
                cancel: {
                    text: 'Hủy ngay!',
                    btnClass: 'btn-red'
                }
            }
        });
    });
    $('.ck_editor').each(function(index, el) {
        var id = $(this).attr('id');
        CKEDITOR.replace(id, {
            extraPlugins: 'codemirror,sourcedialog,video,youtube,lineheight',
            height: $(this).attr('data-height'),
            entities: false,
            uiColor : '#EAEAEA',
            skin: 'moono',
            basicEntities: false,
            entities_greek: false,
            entities_latin: false,
            filebrowserBrowseUrl: 'assets/plugins/ckfinder/ckfinder.html'
        });
    });
    $('#files').getEvali({
        limit: 20,
        maxSize: 50,
        extensions: ['image/*'],
        addMore: true,
        enableApi: false,
        dragDrop: true,
        changeInput: '<div class="fileuploader-input">' + '<div class="fileuploader-input-inner">' + '<div class="fileuploader-main-icon"></div>' + '<h3 class="fileuploader-input-caption"><span>${captions.feedback}</span></h3>' + '<p>${captions.or}</p>' + '<div class="fileuploader-input-button"><span>${captions.button}</span></div>' + '</div>' + '</div>',
        theme: 'dragdrop',
        captions: {
            feedback: '(Click để tải ảnh hoặc kéo thả ảnh vào đây)',
            feedback2: '(Click để tải ảnh hoặc kéo thả ảnh vào đây)',
            drop: '(Click để tải ảnh hoặc kéo thả ảnh vào đây)',
            or: '-hoặc-',
            button: 'Chọn ảnh',
        },
        thumbnails: {
            item:   '<li class="fileuploader-item file-has-popup">' + 
                        '<div class="columns">' + 
                            '<div class="column-info">' +
                                '<div class="column-thumbnail">${image}<span class="fileuploader-action-popup"></span></div>' +
                                '<div class="column-title">' + 
                                    '<div title="${name}">${name}</div>' + 
                                    '<span>${size2}</span>' + 
                                '</div>' +
                            '</div>' +
                            '<div class="column-act">' + 
                                '<div class="column-actions">' + 
                                    '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' + 
                                '</div>'+ 
                                '<div class="numb-fileuploader"><input class="form-control-small" placeholder="Số thứ tự" name="numb[]" /></div>' + 
                            '</div>' +
                            '<div class="column-alt">' + 
                                '<div class="numb-alt"><input class="form-control-small" placeholder="Tên hình" name="alt_vi[]" /></div>' + 
                            '</div>' +
                        '</div>' + 
                    '</li>',
            onImageLoaded: function(item) {
                if (!item.html.find('.fileuploader-action-edit').length) item.html.find('.fileuploader-action-remove').before('<a class="fileuploader-action fileuploader-action-popup fileuploader-action-edit" title="Edit"><i></i></a>')
            }
        },
        /*editor: {
            cropper: {
                ratio: '1:2',
                minWidth: 100,
                minHeight: 200,
                showGrid: true
            }
        }*/
    });


});

