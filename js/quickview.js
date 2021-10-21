function quickView(id) {
    $.ajax({
        url: _BASE + 'quickview.js',
        type: 'post',
        data: { id: id },
        dataType: 'json',
        success: function(data) {
            var _html = '';
            var count_img = data.listPhoto.length;
            var count_color = data.color.length;
            var count_size = data.size.length;
            var price_old = 0;
            if(data.price_old!=0){
                price_old = data.price_old;
            }else{
                price_old = 0;
            }
            var status = ''; //<div class="status">' + lang.tinh_trang + ': <span class="status-class">' + data.status_product + '</span></div>
            var _photo = '';
            _photo += '<div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="' + data.photo + '" data-image="' + data.photo + '"><img src="' + data.thumb + '" alt="' + data.name + '"></a></div></div>';
            $.each(data.listPhoto, function(i, v) {
                _photo += '<div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="' + v.photo + '" data-image="' + v.photo + '"><img src="' + v.thumb + '" alt="' + data.name + '"></a></div></div>';
            });

            _html += '<div id="quickview-product">';
            _html += '<form method="post" data-role="add-to-cart" enctype="multipart/form-data" onsubmit="return false" name="product-actions-' + data.id + '" id="product-actions-' + data.id + '">';
            _html += '<div id="content" class="row d-flex flex-wrap justify-content-start">';
            _html += '<div class="col-5 item left" id="photo-quickview-detail"><div class="img-top"><a href="' + data.photo + '" class="MagicZoom" id="Zoom-1" data-options="variableZoom: true;expand: off; hint: always; " ><img src="' + data.photo + '" alt="' + data.name + '"/></a></div>';
            if (count_img > 0) {
                _html += '<div class="img-bottom"><div class="slider-detail owl-carousel owl-theme not-aweowl">' + _photo + '</div></div>';
            }
            _html += '</div>';
            _html += '<div class="col-7 item right">';
            _html += '<div class="header"><h3>' + data.name + '</h3></div>';
            _html += '<div class="quickview-info">';
            _html += '<div class="status-page"><div class="status">SKU: <span class="status-class">' + data.code + '</span></div><div class="status">' + lang.danh_muc + ': <span class="status-class">' + data.list_name + '...</span></div>'+status+'</div>';
            _html += '<div class="reviews">' + data.rating + '</div>';
            _html += '<div class="prices">\
                        <span class="price"><span id="load-Price-Quickview" class="money-format">' + data.price_text + '</span>₫</span>\
                        <span class="old-price">' + data.price_old_text + '₫</span>\
                    </div>';
            _html += '</div>';

            if( data.trademark != ''){
                _html += '<div class="info-product margin-bottom-10">';
                   _html += '<span>Thương hiệu: </span> <span>' + data.trademark + '</span>';
                _html += '</div>';
            }
            if( data.specification != ''){
                _html += '<div class="info-product margin-bottom-10">';
                   _html += '<span>Quy cách: </span> <span>' + data.specification + '</span>';
                _html += '</div>';
            }

            _html += '<div class="product-description"><div class="rte">' + data.descs + '</div><a href="' + data.alias + '" class="view-more" title="' + lang.chi_tiet + '">' + lang.chi_tiet + ' <i class="fa fa-angle-right"></i></a></div>';
            
            if(_CART_ADVANCE==1){
                if (count_color > 0) {
                    _html += '<div class="element"><div class="head">' + lang.mau_sac + ': </div><div class="cont">';
                    $.each(data.color, function(i, v) {
                        var ck = '';
                        var price = 0;
                        if(v.price==0){
                            price = data.price;
                        }else{
                            price = v.price;
                        }
                        if (i == 0) { ck = 'checked'; }
                        _html += '<div class="el color-img-quickview" data-priceold="'+price_old+'" data-price="'+price+'" data-id="' + v.id + '">\
                        <input id="swatch-0-' + v.id + '" type="radio" name="option1" ' + ck + ' value="' + v.id + '">\
                        <label for="swatch-0-' + v.id + '">' + v.name + '</label>\
                    </div>';
                    });
                    _html += '</div></div>';
                }
                if (count_size > 0) {
                    _html += '<div class="element"><div class="head">' + lang.kich_thuoc + ': </div><div class="cont">';
                    $.each(data.size, function(i, v) {
                        var ck = '';
                        if (i == 0) { ck = 'checked'; }
                        _html += '<div class="el">\
                        <input id="swatch-0-' + v.id + '" type="radio" name="option2" ' + ck + ' value="' + v.id + '">\
                        <label for="swatch-0-' + v.id + '">' + v.name + '</label>\
                    </div>';
                    });
                    _html += '</div></div>';
                }
            }
            
            _html += '<div class="qty-ant btn-number">\
                <label>Số lượng:</label>\
                <div class="custom custom-btn-numbers form-control">\
                    <button onclick="var result = document.getElementById(\'qty\'); var qty = result.value; if( !isNaN(qty) &amp; qty > 1 ){ result.value--; loadPriceCart(\'#qty\', \'#product-price\', document.getElementById(\'price\').value); }else { return false; }" class="btn-minus btn-cts" type="button">–</button>\
                    <input type="text" class="qty input-text" id="qty" name="quantity" size="4" value="1" maxlength="3">\
                    <button onclick="var result = document.getElementById(\'qty\'); var qty = result.value; if( !isNaN(qty)){ result.value++; loadPriceCart(\'#qty\', \'#product-price\', document.getElementById(\'price\').value); }else { return false; }" class="btn-plus btn-cts" type="button">+</button>\
                </div>\
            </div>\
            <div class="btn-mua">\
                <input type="hidden" id="price" name="price" value="' + data.price + '">\
                <input type="hidden" name="act" value="addcart">\
                <input type="hidden" name="id" value="' + data.id + '">\
                <button type="submit" data-role="addtocart" data-el="#product-actions-' + data.id + '" class="buy add-to-cart"><span class="txt-main">' + lang.mua_ngay_voi_gia + ' <b class="product-price money-format" id="product-price">' + data.price_text + '</b><b>₫</b></span><span class="text-add">' + lang.dat_mua_giao_tan_noi + '</span></button>\
            </div>\
        </div>\
        </div></form><button title="Close (Esc)" type="button" class="mfp-close">×</button></div>';
            $('#quickview-modal').html(_html);
            MagicZoom.start('Zoom-1');
            $('.slider-detail').owlCarousel({
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
    });
    $.magnificPopup.open({
        items: {
            src: '#quickview-modal',
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

function loadPriceCart(el_id, el_show, price) {
    var n = parseInt($(el_id).val());
    var p = parseInt(price);
    var t = n * p;
    $(el_show).html(t);
    $('.money-format').priceFormat({
        limit: 13,
        prefix: '',
        centsLimit: 0
    });
}