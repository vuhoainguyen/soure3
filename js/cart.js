function addCart(el) {
    $.ajax({
        url: _BASE + 'carts.js',
        type: 'post',
        data: $(el).serialize(),
        dataType: 'json',
        success: function(data) {
            var _html = data.template;
            $('#cart-modal').html(_html);
            var _htmlm = data.templatem;
            $('#cart-position').html(_htmlm);

            $('#count-cart').html(data['total-product']);
            $('#count-cart-head').html(data['total-product']);
            $('#load-numb-page').html(data['total-product']);
            $('#load-price-page').html(data['total-price']);
            $('#load-price-page').priceFormat({
                limit: 13,
                prefix: '',
                centsLimit: 0
            });
        }
    });

    var magnificPopup = $.magnificPopup.instance;
    magnificPopup.close();
    setTimeout(function() {
        loadPopupCart();
    }, 500);
}
function addCartPayMent(el) {
    $.ajax({
        url: _BASE + 'carts.js',
        type: 'post',
        data: $(el).serialize(),
        dataType: 'json',
        success: function(data) {
            var _html = data.template;
            $('#cart-modal').html(_html);
            var _htmlm = data.templatem;
            $('#cart-position').html(_htmlm);
            $('#count-cart').html(data['total-product']);
            $('#count-cart-head').html(data['total-product']);
            window.location.href = _BASE + 'carts/thanh-toan';
        }
    });

}

function loadCart() {
    $.ajax({
        url: _BASE + 'carts.js',
        type: 'post',
        data: { act: 'loadCart' },
        dataType: 'json',
        success: function(data) {
            var _htmlm = data.templatem;
            $('#cart-position').html(_htmlm);
        }
    });
}
function couponCart(coupon,evt=false,check=1,dis=0) {
    $.ajax({
        url: _BASE + 'carts.js',
        type: 'post',
        data: { coupon: coupon, check: check, dis: dis, act: 'couponCart' },
        dataType: 'json',
        success: function(data) {
            $('#price-coupon').html(data['percents-price-string']);
            $('#total-order').html(data['price-all-string']);
            if(data.status==200){
                if(evt==true){
                    $('#coupon').addClass('success').attr('readonly', 'readonly');
                }
                $('.error-coupon').html('<span class="success">'+data['message']+'</span>');
            }else{
                $('.error-coupon').html('<span class="error">'+data['message']+'</span>');
            }
           
        }
    });
}
function loadPopupCart() {
    $.magnificPopup.open({
        items: {
            src: '#cart-modal',
        },
        type: 'inline',
        alignTop: true,
        mainClass: 'mfp-zoom-in',
        fixedContentPos: true,
        closeOnBgClick: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300
    });
}

function closePopup() {
    var magnificPopup = $.magnificPopup.instance;
    magnificPopup.close();
}

function eventUpdateCart(code, qty, pid) {
    var params = {
        code: code,
        qty: qty,
        pid: pid,
        act: 'updateCart'
    }
    $.ajax({
        url: _BASE + 'carts.js',
        type: 'post',
        data: params,
        dataType: 'json',
        success: function(data) {
            $('#price' + code).html(data['item-price-total-string']);
            $('#total-price-cart').html(data['total-price-string']);
            $('#total-price-cart1').html(data['total-price-string']);
            $('#cart-popup-count').html(data['total-product']);
            $('#count-cart').html(data['total-product']);
            $('#count-cart-head').html(data['total-product']);
        }
    });
}

function eventDeleteCart(code) {
    var params = {
        code: code,
        act: 'deleteCart'
    }
    $.ajax({
        url: _BASE + 'carts.js',
        type: 'post',
        data: params,
        dataType: 'json',
        success: function(data) {
            $('#total-price-cart').html(data['total-price-string']);
            $('#total-price-cart1').html(data['total-price-string']);
            $('#cart-popup-count').html(data['total-product']);
            if (data.status == 0) {
                closePopup();
            }
        }
    });
}
_BMWEB.cartBtnHeader = function() {
    $('body').on('click', '.cart', function(event) {
        var el = $(this);
        if(el.hasClass('active')){
            el.removeClass('active');
        }else{
            el.addClass('active');
        }
    });
};
_BMWEB.cartAdd = function() {
    $('body').on('click', '.buy,.btn-buy', function(event) {
        event.preventDefault();
        var el = $(this).data('el');
        addCart(el);
    });
    $('body').on('click', '.btn-continus-h', function(event) {
        closePopup();
    });
    $('body').on('click', '.buypayment', function(event) {
        var el = $(this).data('el');
        addCartPayMent(el);
    });
};
_BMWEB.cartCoupon = function() {
    $('body').on('click', '#coupon-btn', function(event) {
        var coupon = $('#coupon').val();
        var dis = parseInt($(this).attr('data-rel'));
        couponCart(coupon,true,0,dis);
        if(dis==0){
            $(this).attr('data-rel',1);
            $(this).text('Bỏ áp dụng');
        }else{
            $('#coupon').removeClass('success').removeAttr('readonly');
            $('#coupon').val('');
            $(this).attr('data-rel',0);
            $(this).text('Áp dụng');
        }
    });

    $('body').on('keyup', '#coupon', function(event) {
        var coupon = $(this).val();
        couponCart(coupon,false,1,0);
    });
};
_BMWEB.cartUpdate = function() {
        $('body').on('click', '.btn-minus,.btn-plus', function(event) {
            var code = $(this).parents('.box-cart-qty').find('input[name=code]').val();
            var pid = $(this).parents('.box-cart-qty').find('input[name=variantId]').val();
            var qty = $(this).parents('.box-cart-qty').find('#qtyItemP' + code).val();
            if(!$(this).hasClass('numb-detail')){
                eventUpdateCart(code, qty, pid);
                loadCart();
            }
        });

        $('body').on('click', '.btn-minus1,.btn-plus1', function(event) {
            var code = $(this).parents('.box-cart-qty').find('input[name=code]').val();
            var pid = $(this).parents('.box-cart-qty').find('input[name=variantId]').val();
            var qty = $(this).parents('.box-cart-qty').find('#qty' + code).val();
            if(!$(this).hasClass('numb-detail')){
                eventUpdateCart(code, qty, pid);
                loadCart();
            }
        });
};
_BMWEB.cartDelete = function() {
    $('body').on('click', '.remove-item-cart', function(event) {
        var code = $(this).data('code');
        eventDeleteCart(code);
        $('#row' + code).remove();
        $('#rowm' + code).remove();
    });

};
_BMWEB.checkPayment = function() {
    $('input[type=radio][name=payment]').on('change', function() {
        var v = $(this).val();
        $('.payment-desc').stop().slideUp(300);
        $('#payment' + v).stop().slideDown(300);
    });

};

_BMWEB.checkTransport = function(){
    $('input[type=checkbox][name=other_address]').on('change', function(event) {
        event.preventDefault();
        if($(this).is(':checked')){
            $('#order_address_form').removeClass('d-none');
        }else{
            $('#order_address_form').addClass('d-none');
        }
    });
}
_BMWEB.collapsedOrder = function(){
    $('body').on('click', '.collapsed-order', function(event) {
        event.preventDefault();
        var _o = $(this);
        if(_o.hasClass('active')){
            _o.removeClass('active');
            _o.parents('.box-order').find('.collapse-in').stop().slideUp();
        }else{
            _o.addClass('active');
            _o.parents('.box-order').find('.collapse-in').stop().slideDown();
        }
    });
}

_BMWEB.productProperties = function(){
    if($('.color-img').length > 0){
        $('body').on('click', '.color-img', function(event) {
            var _o  = $(this);
            var _price = parseInt(_o.data('price'));
            var _priceold = parseInt(_o.data('priceold'));
            
            $('#load-Price').html(_price);
            if(_priceold!=0){
                $('#load-Price-Sale').html(_priceold - _price);
            }

            $.ajax({
                url: _BASE + 'ajax/load_photo.php',
                type: 'POST',
                dataType: 'json',
                data: {id: _o.data('id')},
                success: function(data){
                    $('#photo-view-detail').html(data.gal);
                    MagicZoom.start('Zoom-1');
                    _BMWEB.owlDetail();
                }
            });
            $('.money-format').priceFormat({
                limit: 13,
                prefix: '',
                centsLimit: 0
            });
        });
    }
}
_BMWEB.productQuickviewProperties = function(){
    $('body').on('click', '.color-img-quickview', function(event) {
        var _o  = $(this);
        var _price = parseInt(_o.data('price'));
        var _priceold = parseInt(_o.data('priceold'));
        $('#qty').val(1);
        $('#load-Price-Quickview').html(_price);
        $('#product-price').html(_price);
        $('#price').val(_price);
        /*if(_priceold!=0){
            $('#load-Price-Sale').html(_priceold - _price);
        }*/
        $.ajax({
            url: _BASE + 'ajax/load_photo.php',
            type: 'POST',
            dataType: 'json',
            data: {id: _o.data('id')},
            success: function(data){
                $('#photo-quickview-detail').html(data.gal);
                MagicZoom.start('Zoom-1');
                _BMWEB.owlDetail();
            }
        });
        $('.money-format').priceFormat({
            limit: 13,
            prefix: '',
            centsLimit: 0
        });
    });
}
$document.ready(function() {
    _BMWEB.productQuickviewProperties();
    _BMWEB.productProperties();
    _BMWEB.collapsedOrder();
    _BMWEB.cartBtnHeader();
    _BMWEB.cartCoupon();
    _BMWEB.checkTransport();
    _BMWEB.cartAdd();
    _BMWEB.cartUpdate();
    _BMWEB.cartDelete();
    _BMWEB.checkPayment();
});