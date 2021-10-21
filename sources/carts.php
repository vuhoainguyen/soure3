<?php
    if($func->isAjax()){
        $act =  addslashes($_POST['act']);
        switch ($act) {
            case 'addcart':
                $pid = $_POST['id'];
                $qty = $_POST['quantity'];
                $color = $_POST['option1'];
                $size = $_POST['option2'];
                $code = md5($pid.$color.$size);
                $apiCart->addToCart($pid,$color,$size,$qty);
                $name = $apiCart->getProductName($pid,'name_'.$lang);
                $result['cart'] = $_SESSION['cart'];
                $result['count-cart'] = count($_SESSION['cart']);
                $result['total-price'] = $apiCart->getTotalOrder();
                $result['total-product'] = $apiCart->getTotalQuality();
                $result['item']['id'] = $pid;
                $result['item']['name'] = $name;
                $result['item']['quality'] = $qty;
                $result['item']['price'] = ($color!=0) ? $apiCart->getPriceProperties($pid,$code):$apiCart->getPrice($pid);

                $result['item']['color']['id'] = $apiCart->getPropertiesName($color,'id');
                $result['item']['color']['name'] = $apiCart->getPropertiesName($color,"name_$lang");
                $result['item']['size']['id'] = $apiCart->getPropertiesName($size,'id');
                $result['item']['size']['name'] = $apiCart->getPropertiesName($size,"name_$lang");
                
                $title = $name;
                if($color!=0){ $title .= ' - '.$apiCart->getPropertiesName($color,"name_$lang"); }
                if($size!=0){ $title .= ' - '.$apiCart->getPropertiesName($size,"name_$lang"); }

                $result['template'] = $apiCart->getTemplateCartP($lang,$config_base,$title,$pid);
                $result['templatem'] = $apiCart->getTemplateCartM($lang,$config_base);
                echo json_encode($result);
                break;
            
            case 'updateCart':
                $code = (string)$_POST['code'];
                $qty = (string)$_POST['qty'];
                $pid = (int)$_POST['pid'];
                $apiCart->updateQuality($code,$qty);
                $price = $apiCart->getPriceProperties($pid,$code);
                $result['cart'] = $_SESSION['cart'];
                $result['count-cart'] = count($_SESSION['cart']);
                $result['item-price'] = (int)$price;
                $result['item-price-total'] = (int)$price*$qty;
                $result['item-price-total-string'] = $func->moneyFormat($price*$qty,'').'₫';
                $result['total-price'] = $apiCart->getTotalOrder();
                $result['total-price-string'] = $func->moneyFormat($apiCart->getTotalOrder(),'').'₫';
                $result['total-product'] = $apiCart->getTotalQuality();
                echo json_encode($result);
                break;
            case 'deleteCart':
                $code = (string)$_POST['code'];
                $apiCart->removeProduct($code);
                $price = $apiCart->getPriceProperties($pid,$code);
                $result['cart'] = $_SESSION['cart'];
                $result['count-cart'] = count($_SESSION['cart']);
                $result['total-price'] = $apiCart->getTotalOrder();
                $result['total-price-string'] = $func->moneyFormat($apiCart->getTotalOrder(),'').'₫';
                $result['total-product'] = $apiCart->getTotalQuality();
                $result['status'] = ($result['count-cart']==0) ? 0:1;
                echo json_encode($result);
                break;
            case 'loadCart':
                $result['templatem'] = $apiCart->getTemplateCartM($lang,$config_base);
                echo json_encode($result);
                break;

            case 'couponCart':
                $dis = (int)htmlspecialchars($_POST['dis']);
                $check = (int)htmlspecialchars($_POST['check']);
                $coupon = htmlspecialchars($_POST['coupon']);
                $coupon_time = strtotime(date('d-m-Y'));
                if($dis==1){
                    $result['total-price'] = $apiCart->getTotalOrder();
                    $result['percents-price'] = 0;
                    $result['percents-price-string'] = $func->moneyFormat(0,'');
                    $result['price-all'] = $apiCart->getTotalOrder();
                    $result['price-all-string'] = $func->moneyFormat($result['price-all'],'');
                    unset($_SESSION['coupon']);
                    $result['status'] = 202;
                    $result['message'] = _thong_bao_xoa_ma_giam_gia_thanh_cong;
                }else{
                    $result['total-price'] = $apiCart->getTotalOrder();
                    $coupon_item  =  $d->rawQueryOne("select * from #_coupons where code=? and start_date<=? and end_date>=? and qty>0 and price_start<=? and price_end>? and find_in_set ('hienthi',status)",array($coupon,$coupon_time,$coupon_time,$result['total-price'],$result['total-price']));
                    if(!empty($coupon_item)){
                        $result['status'] = 200;
                        $result['percents'] = $coupon_item['percents'];
                        
                        $result['percents-price'] = round($coupon_item['percents']*$apiCart->getTotalOrder()/100);
                        $result['percents-price-string'] = $func->moneyFormat($result['percents-price'],'');
                        $result['price-all'] = $apiCart->getTotalOrder()-$result['percents-price'];
                        $result['price-all-string'] = $func->moneyFormat($result['price-all'],'');
                        if($check==0){
                            $_SESSION['coupon']['percents'] = $result['percents'];
                            $_SESSION['coupon']['percents-price'] = $result['percents-price'];
                            $_SESSION['coupon']['price-all'] = $result['price-all']; 
                            $_SESSION['coupon']['code'] = $coupon_item['code'];
                        }
                        $result['message'] = _thong_bao_su_dung_ma_giam_gia;
                    }else{
                        $result['percents-price'] = 0;
                        $result['percents-price-string'] = $func->moneyFormat(0,'');
                        $result['price-all'] = $apiCart->getTotalOrder();
                        $result['price-all-string'] = $func->moneyFormat($result['price-all'],'');
                        $result['status'] = 201;
                        $result['message'] = _thong_bao_su_dung_ma_giam_gia_qua_han;
                        if($check==0){
                            unset($_SESSION['coupon']);
                        }
                    }
                }

                echo json_encode($result);
                break;
                
            default:
                break;
        }
        
    }else{
        $act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
        if($act=='thanh-toan'){
            if(count($_SESSION['cart'])==0){
                $func->transfer(_cart_payment_empty,$config_base);
            }
            if(!empty($_POST)){
                $order_n = date('dmY').'DH';
                $order_new = $d->rawQueryOne("select id,code from #_orders where code like '$order_n%' order by id desc limit 0,1");
                if(empty($order_new['id'])){ $order_rand = 1001; }else{ $order_rand =  substr($order_new['code'],10)+1; }
                $order_code = date('dmY').'DH'.$order_rand;
                $data = array();
                $post = $_POST;
                if($post){
                    foreach ($post as $k => $v) {
                        if(!empty($post[$k])){
                            $data[$k] = htmlspecialchars($v);
                        }
                    }
                }
                if(isset($post['other_address'])){
                    $data['other_address'] = 1;
                }
                if($_SESSION['coupon']){
                    $data['sale_off'] = $_SESSION['coupon']['percents-price'];
                    $data['coupon_percent'] = $_SESSION['coupon']['percents'];
                    $data['total_price'] = $_SESSION['coupon']['price-all'];
                }else{
                    $data['total_price'] = $apiCart->getTotalOrder();
                }
                $data['code'] = $order_code;
                $data['order_status'] = 1;
                $data['status'] = 'hienthi';
                $data['createdAt'] = $d->now();
                $data['type'] = 'don-hang';

                $city = $apiPlace->getPlaceId('id','place_citys',$data['id_city'],"id, name_$lang as name");
                $dist = $apiPlace->getPlaceId('id','place_dists',$data['id_dist'],"id, name_$lang as name");
                $body = '<table style="width: 768px; margin: 0 auto;"><tr><td><table border="1" cellpadding="0" cellspacing="0" style="font-family:Arial, Geneva, sans-serif; font-size:12px;border-collapse: collapse; border: 1px solid #DDD;" width="100%">
                    <tr style="background:#FFFFFF; border:  border: 1px solid #FFF; " >
                        <th colspan="4" align="center" style="height: 65px;  border: 1px solid #DDD; padding: 10px; box-sizing: border-box; text-transform: uppercase; font-size: 20px;">'._thong_tin_don_hang.' <span style="font-weight: bold;">['.$order_code.']</span></th>
                    </tr>';
                if(isset($post['other_address'])){
                    $city_other = $apiPlace->getPlaceId('id','place_citys',$data['id_city_other'],"id, name_$lang as name");
                    $dist_other = $apiPlace->getPlaceId('id','place_dists',$data['id_dist_other'],"id, name_$lang as name");
                    $body .=    '<tr style="background:#f6f6f6;border: 1px solid #DDD;">
                                    <th colspan="2" align="left" style="height: 25px; padding: 10px 10px;"><span style="font-weight: bold;">'._thong_tin_nhan_hang.'</span></th>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._ngay_dat.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.date('d/m/Y').'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._ho_ten.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['fullname_other'].'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._dia_chi.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['address_other'].'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._dien_thoai.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['phone_other'].'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">Email :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['email_other'].'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._tinh_thanh.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$city_other['name'].'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._quan_huyen.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$dist_other['name'].'</td>
                                </tr>
                                <tr bgcolor="#fbfbfb">
                                    <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._ghi_chu.' :</th>
                                    <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['notes'].'</td>
                                </tr>';
                }else{
                    $body .= '<tr style="background:#f6f6f6;border: 1px solid #DDD;">
                                <th colspan="2" align="left" style="height: 25px; padding: 10px 10px;"><span style="font-weight: bold;">'._thong_tin_dat_hang.'</span></th>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._ngay_dat.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.date('d/m/Y').'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._ho_ten.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['fullname'].'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._dia_chi.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['address'].'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._dien_thoai.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['phone'].'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">Email :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['email'].'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._tinh_thanh.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$city['name'].'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._quan_huyen.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$dist['name'].'</td>
                            </tr>
                            <tr bgcolor="#fbfbfb">
                                <th align="left" width="20%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none;">'._ghi_chu.' :</th>
                                <td width="80%" style="height: 25px; padding: 10px; box-sizing: border-box; border: none; border-right: 1px solid #DDD;" align="right">'.$data['notes'].'</td>
                            </tr>';
                }
                $body .='</table><br/>';
                $body .='<table border="1" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;border-collapse: collapse; border: 1px solid #DDD;" width="100%">';
                if(is_array($_SESSION['cart'])){
                    $body.= '<tr bgcolor="#f6f6f6" style="color:#333;height: 55px;border-collapse: collapse; background:#f6f6f6; border: 1px solid #DDD">
                                <td align="center" style="width:4%; border: 1px solid #DDD">'._hinh.'</td>
                                <td align="center" style="border: 1px solid #DDD; padding: 0px 10px;">'._ten_san_pham.'</td>
                                <td align="center" style="border: 1px solid #DDD; padding: 0px 10px;">'._gia_ban.'</td>
                                <td align="center" style="border: 1px solid #DDD; padding: 0px 10px;">'._so_luong.'</td>
                                <td align="center" style="border: 1px solid #DDD">'._thanh_tien.'</td>
                            </tr>';
                    $max=count($_SESSION['cart']);
                    for($i=0;$i<$max;$i++){
                        $_pid=$_SESSION['cart'][$i]['productid'];
                        $_q=$_SESSION['cart'][$i]['qty'];
                        $_color = $_SESSION['cart'][$i]['color'];
                        $_size = $_SESSION['cart'][$i]['size'];
                        $_code=$_SESSION['cart'][$i]['code'];
                        $_price = ($_color!=0) ? $apiCart->getPriceProperties($_pid,$_code):$apiCart->getPrice($_pid);
                        $_name = $apiCart->getProductName($_pid,'name_'.$lang);
                        $_alias = $apiCart->getProductName($_pid,'alias_'.$lang);
                        $_n_color = $apiCart->getPropertiesName($_color,'name_'.$lang);
                        $_n_size = $apiCart->getPropertiesName($_size,'name_'.$lang);

                        $_title .= $_name;
                        if($_color!=0){
                            $_title .= ' - '.$_n_color;
                        }
                        if($_size!=0){
                            $_title .= ' - Size '.$_n_size;
                        }
                        if($_q==0) continue;
                        $body   .= '<tr style="text-align: center">
                                        <td width="3%" align="center" style="border: 1px solid #DDD; padding: 10px; box-sizing: border-box;">
                                            '.$apiCart->getProductImg($_pid,$lang,_upload_product_l,$config_base,50).'
                                        </td>
                                        <td width="29%" align="center" style="border: 1px solid #DDD; padding: 10px; box-sizing: border-box;">
                                            <h4 style="font-size: 13px; font-weight: 700; padding: 0px; margin: 0px;">'.$_title.'</h4>
                                        </td>
                                        <td width="29%" align="center" style="border: 1px solid #DDD; padding: 10px; box-sizing: border-box;">
                                            <p>'.$func->moneyFormat($_price,'').'<sup>đ</sup></p>
                                        </td>
                                        <td width="29%" align="center" style="border: 1px solid #DDD; padding: 10px; box-sizing: border-box;">
                                            <p>'.$_q.'</p>
                                        </td>
                                        <td width="15%" align="center" style="border: 1px solid #DDD; padding: 10px; box-sizing: border-box;">
                                            <p>'.$func->moneyFormat($_price*$_q,'').'<sup>đ</sup></p>
                                        </td>';
                        $body   .= '</tr>';
                    }
                    $body   .=  '<tr>
                                    <td colspan="6" style="background:#f6f6f6; height:25px; text-align:right; padding:10px; border: 1px solid #DDD;">
                                        <p>'._tam_tinh.': '.$func->moneyFormat($apiCart->getTotalOrder(),'').'<sup>đ</sup></p>
                                    </td>
                                </tr>';
                    if($_SESSION['coupon']){
                    $body   .=  '<tr>
                                    <td colspan="6" style="background:#f6f6f6; height:25px; text-align:right; padding:10px; border: 1px solid #DDD;">
                                        <p>'._giam_gia.': '.$func->moneyFormat($data['sale_off'],'').'<sup>đ</sup></p>
                                    </td>
                                </tr>';
                    }
                    $body .='<tr>
                                <td colspan="6" style="background:#f6f6f6; height:25px; text-align:right; padding:10px; border: 1px solid #DDD;">
                                    <p>'._thanh_tien.': '.$func->moneyFormat($data['total_price'],'').'<sup>đ</sup></p>
                                </td>
                            </tr>';
                }else{
                    $body.='<tr bgColor="#FFFFFF"><td>'._cart_payment_empty.'</td>';
                }
                $body.='</table></td></tr></table>';
                $data['body_carts'] = htmlspecialchars($body);
                $data['body_codes'] = base64_encode($data['code']);
                $id_insert = $d->insert('orders', $data);
                if ($id_insert) {
                    if(count($_SESSION['cart'])>0){
                        foreach ($_SESSION['cart'] as $k => $v) {
                            $color_name = $apiCart->getPropertiesName($v['color'],'name_'.$lang);
                            $size_name = $apiCart->getPropertiesName($v['size'],'name_'.$lang);
                            $product = $func->getFieldId($v['productid'],'products');
                            $data_order['code'] = $product['code'];
                            $data_order['name'] = $product['name_'.$lang];
                            $data_order['id_product'] = $product['id'];
                            $data_order['price'] = $product['price'];
                            $data_order['color'] = $v['color'];
                            $data_order['color_name'] = $color_name;
                            $data_order['size'] = $v['size'];
                            $data_order['size_name'] = $size_name;
                            $data_order['qty'] = $v['qty'];
                            $data_order['createdAt'] = $d->now();
                            $data_order['id_order'] = $id_insert;
                            $id_order = $d->insert('order_details', $data_order);
                        }
                    }

                    if($_SESSION['coupon']){
                        $d->rawQuery("update #_coupons set qty=qty-1 where code=?",array($_SESSION['coupon']['code']));
                    }
                    $result['status'] = 200;
                    $result['message'] = _thong_bao_them_du_lieu_thanh_cong.' id#'.$id_insert;
                    $message = base64_encode(json_encode($result));
                    $mail_send = array();
                    $mail_send[0] = $row_setting['email'];
                    $mail_send[1] = $post['email'];
                    if(isset($post['other_address'])){
                        $mail_send[2] = $post['email_other'];
                    }
                    if($func->sendMailIndex($row_setting['email'],_thong_bao_don_hang.' ['.$order_code.']',$body,$mail_send,null,null)){
                        unset($_SESSION['cart']);
                        unset($_SESSION['coupon']);
                        $func->redirect($config_base.'carts/xac-nhan&code='.$data['body_codes']);
                    }else{
                        $func->transfer(_thong_bao_he_thong_gui_don_hang_loi, $config_base.'carts/gio-hang');
                    }
                }else{
                    print_r($d->getLastError());
                    die;
                }
            }
        }elseif($act=='xac-nhan'){
            $code = base64_decode(htmlspecialchars($_GET['code']));
            $order_confirm = $d->rawQueryOne("select body_carts,body_checks,id from #_orders where code = '".$code."' order by id desc limit 0,1");
            if(!empty($_POST)){
                $check['body_checks'] = (int)$_POST['ok'];
                $d->where('id', (int)$_POST['id']);
                if ($d->update('orders', $check)) {
                    $func->redirect($config_base);
                }
            }
        }elseif($act=='gio-hang'){
            if(count($_SESSION['cart'])==0){
                $func->transfer(_cart_payment_empty,$config_base);
            }
        }
    }
?>