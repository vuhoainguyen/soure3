<?php
    ini_set('max_execution_time', 3000000);
    class cartFrontEnd{
        private $d;
        private $config;
        private $table='products';
        private $table_properties='product_properties';
        private $name='cart';

        public function __construct($d, $config){
            $this->d = $d;
            $this->config = $config;
        }

        public function addToCart($pid,$color=0,$size=0,$q=1){
            if($pid<1 or $q<1) return;
            $code = md5($pid.$color.$size);
            if(is_array($_SESSION[$this->name])){
                if($this->productExists($code,$q)) return;
                $max = count($_SESSION[$this->name]);
                $_SESSION[$this->name][$max]['productid']=$pid;
                $_SESSION[$this->name][$max]['qty']=$q;
                $_SESSION[$this->name][$max]['color']=$color;
                $_SESSION[$this->name][$max]['size']=$size;
                $_SESSION[$this->name][$max]['code']=$code;
                return count($_SESSION[$this->name]);	
            }else{
                $_SESSION[$this->name] = array();
                $_SESSION[$this->name][0]['productid']=$pid;
                $_SESSION[$this->name][0]['qty']=$q;
                $_SESSION[$this->name][0]['color']=$color;
                $_SESSION[$this->name][0]['size']=$size;
                $_SESSION[$this->name][0]['code']=$code;
                return count($_SESSION[$this->name]);	
            }
        }
        
        public function productExists($code,$q){
            $max=count($_SESSION[$this->name]);
            $flag=0;
            for($i=0;$i<$max;$i++){
                if($code==$_SESSION[$this->name][$i]['code']){
                    $_SESSION[$this->name][$i]['qty'] = $_SESSION[$this->name][$i]['qty'] + $q;
                    $flag=1;
                    break;
                }
            }
            return $flag;
        }

        public function getPriceProperties($pid,$code){
            $max=count($_SESSION[$this->name]);
            $price=0;
            for($i=0;$i<$max;$i++){
                if($code==$_SESSION[$this->name][$i]['code']){
                    if($_SESSION[$this->name][$i]['color']!=0){
                        $price = $this->getPropertiesName($_SESSION[$this->name][$i]['color'],'price');
                        if($price!=0){
                            $price = $price;
                        }else{
                            $price = $this->getPrice($pid);
                        }
                    }else{
                        $price = $this->getPrice($pid);
                    }
                    break;
                }
            }
            return $price;
        }


        public function updateQuality($code,$q){
            $max=count($_SESSION[$this->name]);
            $flag = 0;
            for($i=0;$i<$max;$i++){
                if($code==$_SESSION[$this->name][$i]['code']){
                    $_SESSION[$this->name][$i]['qty'] = $q;
                    $flag = 1;
                    break;
                }
            }
            return $flag;
        }

        public function removeProduct($code){
            $max=count($_SESSION[$this->name]);
            for($i=0;$i<$max;$i++){
                if($code==$_SESSION[$this->name][$i]['code']){
                    unset($_SESSION[$this->name][$i]);
                    break;
                }
            }
            $_SESSION[$this->name]=array_values($_SESSION[$this->name]);
        }

        public function getTotalQuality(){
            $max = count($_SESSION[$this->name]);
            $sum = 0;
            for($i=0;$i<$max;$i++){
                $q = $_SESSION[$this->name][$i]['qty'];
                $sum += $q;
            }
            return $sum;
        }
        public function getPrice($pid){
            $sql = "select price from #_".$this->table." where id='".$pid."'";
            $row = $this->d->rawQueryOne($sql);
            return $row['price'];
        }
        public function getTotalOrder(){
            $max=count($_SESSION[$this->name]);
            $sum=0;
            for($i=0;$i<$max;$i++){
                $pid = $_SESSION[$this->name][$i]['productid'];
                $code = $_SESSION[$this->name][$i]['code'];
                $q = $_SESSION[$this->name][$i]['qty'];
                $color = $_SESSION[$this->name][$i]['color'];
                $price = ($color!=0) ? $this->getPriceProperties($pid,$code):$this->getPrice($pid);
                $sum += $price*$q;
            }
            return $sum;
        }

        public function getProductImg($pid,$lang,$url,$config_url,$size){
            $sql = "select photo, name_$lang as name from #_".$this->table." where id='".$pid."'";
            $row = $this->d->rawQueryOne($sql);
            $hinhanh = $row['photo'];
            return '<img src="'.$config_url.$url.$hinhanh.'?v='.time().'" alt="'.$row['name'].'" width="'.$size.'">';
        }
        public function getProduct($pid){
            $sql = "select * from #_products where id='".$pid."'";
            $row = $this->d->rawQueryOne($sql);
            return $row;
        }
        public function getProductName($pid,$field){
            $sql = "select $field from #_".$this->table." where id='".$pid."'";
            $row = $this->d->rawQueryOne($sql);
            return $row[$field];
        }
        public function getPropertiesName($pid,$field){
            $sql = "select $field from #_".$this->table_properties." where id='".$pid."'";
            $row = $this->d->rawQueryOne($sql);
            return $row[$field];
        }
        public function getTemplateCartP($lang,$config_url,$title,$pid){
            global $func;
            $result = $this->getCart();
            $template = '<div id="popup-cart">
                <div class="title-cart">
                    <span class="your-product">'._ban_da_them.' <span class="cart_name_style">[ <span class="cart-name"><a href="'.$this->getProductName($pid,'alias_'.$lang).'" title="">'.$title.'</a> </span>]</span> '._vao_gio_hang_thanh_cong.' ! </span>
                </div>
                <div class="wrap-popup">
                    <div class="title-quantity"><span class="cart-status" onclick="window.location.href=\'carts/gio-hang\';">'._gio_hang_cua_ban_co.' <span class="cart-popup-count" id="cart-popup-count">'.$result['total-product'].'</span> '._sanpham.' </span><i class="fa fa-caret-right" aria-hidden="true"></i></div>';
                    $template .= '<div class="content-cart">';
                        $template .= '<div class="thead-popup">
                                            <div style="width: 53%;" class="th text-left">'._sanpham.'</div>
                                            <div style="width: 15%;" class="th text-center">'._don_gia.'</div>
                                            <div style="width: 15%;" class="th text-center">'._so_luong.'</div>
                                            <div style="width: 17%;" class="th text-center">'._thanh_tien.'</div>
                                        </div>';
                        $template .= '<div class="tbody-popup">';
                            for ($i=0;$i<$result['count-cart'];$i++) {
                                $_pid = $result['cart'][$i]['productid'];
                                $_qty = $result['cart'][$i]['qty'];
                                $_color = $result['cart'][$i]['color'];
                                $_size = $result['cart'][$i]['size'];
                                $_code = $result['cart'][$i]['code'];
                                $_price = ($_color!=0) ? $this->getPriceProperties($_pid,$_code):$this->getPrice($_pid);
                                $_name = $this->getProductName($_pid,'name_'.$lang);
                                $_alias = $this->getProductName($_pid,'alias_'.$lang);

                                $_n_color = $this->getPropertiesName($_color,'name_'.$lang);
                                $_n_size = $this->getPropertiesName($_size,'name_'.$lang);

                                $_title = $_name;
                                if($this->config['cart']['advance']==true){
                                    if($_color!=0){
                                        $_title .= ' - '.$_n_color;
                                    }
                                    if($_size!=0){
                                        $_title .= ' - Size '.$_n_size;
                                    }
                                }
                                $template .= '<div class="tr" id="row'.$_code.'">
                                                    <div style="width: 53%;" class="td flex text-left">
                                                        <div class="img">
                                                            <a class="product-image" href="'.$_alias.'" title="'.$_title.'">
                                                                '.$this->getProductImg($_pid,$lang,_upload_product_l,$config_url,50).'
                                                            </a>
                                                        </div>
                                                        <div class="item-info">
                                                            <p class="item-name"><a class="text2line" href="'.$_alias.'" title="'.$_title.'">'.$_title.'</a></p>
                                                            <a href="javascript:;" class="remove-item-cart" title="'._xoa.'" data-code="'.$_code.'">
                                                                <i class="fa fa-close"></i>&nbsp;&nbsp;'._xoa.'
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div style="width: 15%;" class="td text-center">
                                                        <div class="item-price"><span class="price">'.$this->numbMoney($_price, '').' ₫</span></div>
                                                    </div>
                                                    <div style="width: 15%;" class="td text-center">
                                                        <div class="qty_inputt box-cart-qty check_">
                                                            <input class="code" type="hidden" name="code" value="'.$_code.'">
                                                            <input class="variantID" type="hidden" name="variantId" value="'.$_pid.'">
                                                            <button onclick="var result = document.getElementById(\'qtyItemP'.$_code.'\'); var qtyItem'.$_code.' = result.value; if( !isNaN( qtyItem'.$_code.' ) &amp;&amp; qtyItem'.$_code.' > 1 ) result.value--;return false;" class="num1 reduced items-count btn-minus btn-minus" type="button">-</button>
                                                            <input type="text" maxlength="12" min="0" readonly="" class="input-text number-sidebar qtyItemP'.$_code.'" id="qtyItemP'.$_code.'" name="Lines" size="4" value="'.$_qty.'">
                                                            <button onclick="var result = document.getElementById(\'qtyItemP'.$_code.'\'); var qtyItemP'.$_code.' = result.value; if( !isNaN( qtyItemP'.$_code.' )) result.value++;return false;" class="num2 increase items-count btn-plus btn-plus" type="button">+</button>
                                                        </div>
                                                    </div>
                                                    <div style="width: 17%;" class="td text-center">
                                                        <div class="item-price"><span class="price" id="price'.$_code.'">'.$this->numbMoney($_price*$_qty, '').' ₫</span></div>
                                                    </div>
                                                </div>';
                            }
                        $template .= '</div>';
                        $template .= '<div class="tfoot-popup">
                                            <div class="tfoot-popup">
                                                <span class="popup-total">'._tong_tien_thanh_toan.': <span class="total-price" id="total-price-cart">'.$this->numbMoney($result['total-price'],'').' ₫</span></span>
                                            </div>
                                            <div class="tfoot-popup">
                                                <a class="button btn-proceed-checkout" title="'._thuc_hien_thanh_toan.'" href="carts/thanh-toan"><span>'._thuc_hien_thanh_toan.'</span></a>
                                                <a class="button btn-continus-h" title="'._tiep_tuc_mua_hang.'"><span><span>'._tiep_tuc_mua_hang.'</span></span></a>
                                            </div>
                                        </div>';
                    $template .= '</div>';
                    $template .= '</div><button title="Close (Esc)" type="button" class="mfp-close">×</button></div>';
            return $template;
        }
        public function getTemplateCartM($lang,$config_url){
            global $func;
            $result = $this->getCart();
            $templatem = '';
            if($result['count-cart']>0){
                $templatem .= '<ul class="list-item-cart">';
                for ($i=0;$i<$result['count-cart'];$i++) {
                    $_pid = $result['cart'][$i]['productid'];
                    $_qty = $result['cart'][$i]['qty'];
                    $_color = $result['cart'][$i]['color'];
                    $_size = $result['cart'][$i]['size'];
                    $_code = $result['cart'][$i]['code'];
                    $_price = ($_color!=0) ? $this->getPriceProperties($_pid,$_code):$this->getPrice($_pid);
                    $_name = $this->getProductName($_pid, 'name_'.$lang);
                    $_alias = $this->getProductName($_pid, 'alias_'.$lang);
                    $_title = $_name;
                    $_n_color = $this->getPropertiesName($_color,'name_'.$lang);
                    $_n_size = $this->getPropertiesName($_size,'name_'.$lang);

                    $_title = $_name;
                    if($this->config['cart']['advance']==true){
                        if($_color!=0){
                            $_title .= ' - '.$_n_color;
                        }
                        if($_size!=0){
                            $_title .= ' - Size '.$_n_size;
                        }
                    }
                    $templatem .= '<li id="rowm'.$_code.'" class="item productid-'.$_code.'">
                                        <div class="border-list">
                                            <div class="detail-img"><a class="product-image" href="'.$_alias.'" title="'.$_title.'">
                                            '.$this->getProductImg($_pid,$lang,_upload_product_l,$config_url,40).'
                                            </a></div>
                                            <div class="detail-item">
                                                <div class="product-details">
                                                    <p class="product-name"> <a class="text2line" href="'.$_alias.'" title="'.$_title.'">'.$_title.'</a>
                                                    </p>
                                                </div>
                                                <div class="product-details-bottom"><span class="price" id="pricem'.$_code.'">'.$this->numbMoney($_price, '').' ₫</span><a href="javascript:;" data-code="'.$_code.'" title="'._xoa.'" class="remove-item-cart fa fa-times">&nbsp;</a>
                                                    <div class="quantity-select box-cart-qty qty_drop_cart">
                                                        <input class="code" type="hidden" name="code" value="'.$_code.'">
                                                        <input class="variantID" type="hidden" name="variantId" value="'.$_pid.'">
                                                        <button onclick="var result = document.getElementById(\'qty'.$_code.'\'); var qty'.$_code.' = result.value; if( !isNaN( qty'.$_code.' ) &amp;&amp; qty'.$_code.' > 1 ) { result.value--; }else{ return false; }" class="btn_reduced reduced items-count btn-minus1" type="button">–</button>
                                                        <input type="text" maxlength="12" min="1" class="input-text number-sidebar qty'.$_code.'" id="qty'.$_code.'" name="Lines" size="4" value="'.$_qty.'">
                                                        <button onclick="var result = document.getElementById(\'qty'.$_code.'\'); var qty'.$_code.' = result.value; if( !isNaN( qty'.$_code.' )) result.value++;return false;" class="btn_increase increase items-count btn-plus1" type="button">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>';
                }
                $templatem .= '</ul>';
                $templatem .= '<div class="totalm"><div class="top-subtotal">'._tong_tien.': <span class="price" id="total-price-cart1">'.$this->numbMoney($this->getTotalOrder(),'').' ₫</span></div></div>';
                $templatem .= '<div class="totalm"><a href="carts/thanh-toan" class="btn btn-primary"><span>'._tien_hanh_thanh_toan.'</span></a><a href="carts/gio-hang" class="btn btn-white"><span>'._di_den_gio_hang.'</span></a></div>';
            }else{
                $templatem .= '<p>'._gio_hang_rong.'.</p>';
            }
            
            return $templatem;
        }

        public function getTemplateCartG($lang,$config_url){
            global $func;
            $result = $this->getCart();
            $template = '<div id="cart-page">';
                    $template .= '<div class="content-cart">';
                        $template .= '<div class="thead-popup">
                                            <div style="width: 53%;" class="th text-left">'._ten_san_pham.'</div>
                                            <div style="width: 15%;" class="th text-center">'._don_gia.'</div>
                                            <div style="width: 15%;" class="th text-center">'._so_luong.'</div>
                                            <div style="width: 17%;" class="th text-center">'._thanh_tien.'</div>
                                        </div>';
                        $template .= '<div class="tbody-popup">';
                            for ($i=0;$i<$result['count-cart'];$i++) {
                                $_pid = $result['cart'][$i]['productid'];
                                $_qty = $result['cart'][$i]['qty'];
                                $_color = $result['cart'][$i]['color'];
                                $_size = $result['cart'][$i]['size'];
                                $_code = $result['cart'][$i]['code'];
                                $_price = ($_color!=0) ? $this->getPriceProperties($_pid,$_code):$this->getPrice($_pid);
                                $_name = $this->getProductName($_pid,'name_'.$lang);
                                $_alias = $this->getProductName($_pid,'alias_'.$lang);

                                $_n_color = $this->getPropertiesName($_color,'name_'.$lang);
                                $_n_size = $this->getPropertiesName($_size,'name_'.$lang);
                                
                                $_title = $_name;
                                if($this->config['cart']['advance']==true){
                                    if($_color!=0){
                                        $_title .= ' - '.$_n_color;
                                    }
                                    if($_size!=0){
                                        $_title .= ' - Size '.$_n_size;
                                    }
                                }
                                $template .= '<div class="tr" id="row'.$_code.'">
                                                    <div style="width: 53%;" class="td flex text-left">
                                                        <div class="img">
                                                            <a class="product-image" href="'.$_alias.'" title="'.$_title.'">
                                                                '.$this->getProductImg($_pid,$lang,_upload_product_l,$config_url,40).'
                                                            </a>
                                                        </div>
                                                        <div class="item-info">
                                                            <p class="item-name"><a class="text2line" href="'.$_alias.'" title="'.$_title.'">'.$_title.'</a></p>
                                                            <p><a  class="remove-item-cart" title="'._xoa.'" data-code="'.$_code.'">
                                                                <i class="fa fa-close"></i>&nbsp;&nbsp;Xoá
                                                            </a></p>
                                                        </div>
                                                    </div>
                                                    <div style="width: 15%;" class="td text-center">
                                                        <div class="item-price"><span class="price">'.$this->numbMoney($_price, '').' ₫</span></div>
                                                    </div>
                                                    <div style="width: 15%;" class="td text-center">
                                                        <div class="qty_inputt box-cart-qty check_">
                                                            <input class="code" type="hidden" name="code" value="'.$_code.'">
                                                            <input class="variantID" type="hidden" name="variantId" value="'.$_pid.'">
                                                            <button onclick="var result = document.getElementById(\'qtyItemP'.$_code.'\'); var qtyItem'.$_code.' = result.value; if( !isNaN( qtyItem'.$_code.' ) &amp;&amp; qtyItem'.$_code.' > 1 ) result.value--;return false;" class="num1 reduced items-count btn-minus btn-minus" type="button">-</button>
                                                            <input type="text" maxlength="12" min="0" readonly="" class="input-text number-sidebar qtyItemP'.$_code.'" id="qtyItemP'.$_code.'" name="Lines" size="4" value="'.$_qty.'">
                                                            <button onclick="var result = document.getElementById(\'qtyItemP'.$_code.'\'); var qtyItemP'.$_code.' = result.value; if( !isNaN( qtyItemP'.$_code.' )) result.value++;return false;" class="num2 increase items-count btn-plus btn-plus" type="button">+</button>
                                                        </div>
                                                    </div>
                                                    <div style="width: 17%;" class="td text-center">
                                                        <div class="item-price"><span class="price" id="price'.$_code.'">'.$this->numbMoney($_price*$_qty, '').' ₫</span></div>
                                                    </div>
                                                </div>';
                            }
                        $template .= '</div>';
                        $template .= '<div class="tfoot-popup">
                                            <div class="tfoot-popup">
                                                <span class="popup-total">'._tong_tien_thanh_toan.': <span class="total-price" id="total-price-cart">'.$this->numbMoney($result['total-price'],'').' ₫</span></span>
                                            </div>
                                            <div class="tfoot-popup">
                                                <a class="button btn-proceed-checkout" title="'._thuc_hien_thanh_toan.'" href="carts/thanh-toan"><span>'._thuc_hien_thanh_toan.'</span></a>
                                                <a href="san-pham" class="button" title="'._tiep_tuc_mua_hang.'"><span><span>'._tiep_tuc_mua_hang.'</span></span></a>
                                            </div>
                                        </div>';
                    $template .= '</div>';
            $template .= '</div>';
            return $template;
        }
        public function getTemplateCheckout($lang,$config_url){
            global $func;
            $result = $this->getCart();
            if($result['count-cart']>0){
                $template = '<ul id="cart-list">';
                for ($i=0;$i<$result['count-cart'];$i++) {
                    $_pid = $result['cart'][$i]['productid'];
                    $_qty = $result['cart'][$i]['qty'];
                    $_color = $result['cart'][$i]['color'];
                    $_size = $result['cart'][$i]['size'];
                    $_code = $result['cart'][$i]['code'];
                    $_price = ($_color!=0) ? $this->getPriceProperties($_pid,$_code):$this->getPrice($_pid);
                    $_name = $this->getProductName($_pid,'name_'.$lang);
                    $_alias = $this->getProductName($_pid,'alias_'.$lang);
                    $_n_color = $this->getPropertiesName($_color,'name_'.$lang);
                    $_n_size = $this->getPropertiesName($_size,'name_'.$lang);

                    $_title = $_name;
                    if($this->config['cart']['advance']==true){
                        if($_color!=0){
                            $_title .= ' - '.$_n_color;
                        }
                        if($_size!=0){
                            $_title .= ' - Size '.$_n_size;
                        }
                    }
                    $template .= '<li class="tr">
                                        <div style="width: 74%;" class="td d-flex text-left">
                                            <div class="img">
                                                <a class="product-image" href="'.$_alias.'" title="'.$_title.'">
                                                    '.$this->getProductImg($_pid,$lang,_upload_product_l,$config_url,50).'
                                                </a>
                                                <span>'.$_qty.'</span>
                                            </div>
                                            <div class="item-info">
                                                <p class="item-name"><a class="text2line" href="'.$_alias.'" title="'.$_title.'">'.$_title.'</a></p>
                                            </div>
                                        </div>
                                        <div style="width: 25%;" class="td text-center">
                                            <div class="item-price"><span class="price">'.$this->numbMoney($_price*$_qty, '').' ₫</span></div>
                                        </div>
                                    </li>';
                }
                $template .= '</ul>';
            }else{
                $template = '';
            }
            return $template;
        }
        public function getCart(){
            $result['cart'] = $_SESSION['cart'];
            $result['count-cart'] = count($_SESSION['cart']);
            $result['total-price'] = $this->getTotalOrder();
            $result['total-product'] = $this->getTotalQuality();
            return $result;
        }
        public function numbMoney($val,$car='đ'){
            return number_format($val,0, ',', '.').''.$car;
        }
    }
?>