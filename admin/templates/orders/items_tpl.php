<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
    $start_month  = date('m/d/Y',mktime(0, 0, 0, date("m")-1,   date("d"),   date("Y")));
    $end_month  = date('m/d/Y',mktime(0, 0, 0, date("m")+1,   date("d"),   date("Y")));
    $row_setting = $d->rawQueryOne("select *, address_vi as address, company_vi as company, title_vi as title, keywords_vi as keywords, description_vi as description from #_settings limit 0,1");
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.html?com=orders&act=man<?=$url_type?>">Danh sách</a></li>
            <li class="breadcrumb-item active"><?=$csetting['name']?></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Danh sách <?=$csetting['name']?></h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?=$func->messagePage($_GET['message'])?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-5 mb-2">
                            <h6 class="fs-17 font-weight-600 mb-0">Danh sách</h6>
                        </div>
                        <div class="col-md-5 text-right">
                            <a class="btn btn-danger w-100p deleteChoose mb-1" href="index.html?com=orders&act=delete<?=$url_type?>" role="button">Xóa chọn</a>
                            <?php if($config['order']['export-list']==true){ ?>
                            <a class="btn btn-primary btn-export-orders w-100p ml-1 mb-1" href="#" role="button">Xuất file</a>
                            <?php } ?>
                            <a class="btn btn-success w-100p ml-1 mb-1" href="index.html?com=orders&act=add<?=$url_type?>" role="button">Tạo đơn hàng</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="index.html" method="get" name="form-thongke" id="form-thongke" accept-charset="utf-8">
                        <input type="hidden" name="com" value="orders">
                        <input type="hidden" name="act" value="man">
                        <input type="hidden" name="type" value="<?=$_GET['type']?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Từ khóa</label>
                                    <input class="form-control" type="text" name="keyword" value="<?=(isset($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']):''?>" placeholder="Nhập từ khóa...." data-toggle="tooltip" data-placement="top" title="Nhập mã đơn hàng, họ tên, email, điện thoại, địa chỉ" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Thời gian (m/d/Y)</label>
                                    <input class="form-control daterange" type="text" name="daterange" value="<?=($_GET['daterange']) ? $start_month.' - '.$end_month:''?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-weight-600">Trạng thái đơn hàng</label>
                                    <select class="form-control basic-single" name="order_status" id="order_status">
                                        <option value="0">Chọn trạng thái đơn hàng</option>
                                        <?php for($i=0;$i<count($items_status);$i++){ ?>
                                        <option value="<?=$items_status[$i]['id']?>" <?=($_GET['order_status']==$items_status[$i]['id']) ? 'selected':''?>><?=$items_status[$i]['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-weight-600">Trạng thái thanh toán</label>
                                    <select class="form-control basic-single" name="payment_status" id="payment_status">
                                        <option value="200">Chọn trạng thái thanh toán</option>
                                        <?php foreach ($config['order']['payment'] as $k1 => $v1) { ?>
                                        <option value="<?=$k1?>" <?=($k1==$_GET['payment_status']) ? 'selected':''?>><?=$v1?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-weight-600">-------</label>

                                    <button type="submit" class="btn btn-fill btn-primary w-100">Thống kê / tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table display table-striped table-hover table-border">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <div class="check-table" >
                                            <input id="checkAll" type="checkbox" class="checkboxAll">
                                            <label for="checkAll" class="pl-0"></label>
                                        </div>
                                    </th>
                                    <th>Mã đơn hàng</th>
                                    <th>Thời gian</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th width="73">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #f5f5f5;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php foreach ($items as $k => $v) { $status_order = $func->getFieldId($v['order_status'],'order_status'); $item_orders = $func->getOrderDetails($v['id']);  $item_returns = $func->getOrderReturns($v['id']);
                                ?>
                                <tr id="order-<?=$v['code']?>" class="item-tr <?=($v['view']==1) ? '':'font-bold'?>" data-id="<?=$v['id']?>" data-view="<?=$v['view']?>" data-table="orders">
                                    <td>
                                        <div class="check-table">
                                            <input id="checkbox<?=$v['id']?>" name="chon" class="checker" type="checkbox" value="<?=$v['id']?>">
                                            <label for="checkbox<?=$v['id']?>" class="pl-0"></label>
                                        </div>
                                    </td>
                                    <td class="check-line"><?=$v['code']?></td>
                                    <td class="check-line"><?=$v['createdAt']?></td>
                                    <td class="check-line"><?=$v['email']?></td>
                                    <td class="check-line"><?=$v['phone']?></td>
                                    <td class="check-line"><?=$func->moneyFormat($v['total_price'],'')?></td>
                                    <td class="check-line">
                                        <span class="label label-sm <?=$status_order['classname']?>"><?=$status_order['name_vi']?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php /*<a href="index.html?com=orders&act=edit<?=$url_type?>&id=<?=$v['id']?>" class="btn btn-success-soft btn-sm mr-1"><i class="typcn typcn-eye-outline"></i></a>*/ ?>
                                        <a href="index.html?com=orders&act=delete<?=$url_type?>&id=<?=$v['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" class="btn btn-danger-soft btn-sm"><i class="typcn typcn-trash"></i></a>
                                    </td>
                                </tr>
                                <tr class="item-trr none-order">
                                    <td colspan="8">
                                        <div class="process-bar-all" id="process<?=$v['id']?>"></div>

                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="information<?=$v['id']?>-tab" data-toggle="pill" href="#information<?=$v['id']?>" role="tab" aria-controls="information<?=$v['id']?>" aria-selected="true">Thông tin</a>
                                            </li>
                                            <?php if(count($item_returns)){ ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="return-orders<?=$v['id']?>-tab" data-toggle="pill" href="#return-orders<?=$v['id']?>" role="tab" aria-controls="return-orders<?=$v['id']?>" aria-selected="false">Lịch sử trả hàng</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="information<?=$v['id']?>" role="tabpanel" aria-labelledby="information<?=$v['id']?>-tab">
                                                <div class="order-box">
                                                    <div class="row" style="min-width: 932px;">
                                                        <div class="coll-4" style="width: calc(100% / 3); padding: 0px 10px;">
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-4 mb-0 order-title">Mã đơn:</label>
                                                                <div class="col-md-8 order-title"><strong><?=$v['code']?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-4 mb-0 order-title">Thời gian:</label>
                                                                <div class="col-md-8 order-title"><strong><?=$v['createdAt']?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-4 mb-0 order-title">Trạng thái đơn:</label>
                                                                <div class="col-md-8 order-title">
                                                                    <select name="order_status<?=$v['id']?>" id="order_status<?=$v['id']?>" class="form-control status-select">
                                                                        <?php foreach ($items_status as $k1 => $v1) { ?>
                                                                        <option value="<?=$v1['id']?>" <?=($v1['id']==$v['order_status']) ? 'selected':''?>><?=$v1['name_vi']?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-4 mb-0 order-title">Thanh toán:</label>
                                                                <div class="col-md-8 order-title">
                                                                    <select name="payment_status<?=$v['id']?>" id="payment_status<?=$v['id']?>" class="form-control status-select">
                                                                        <?php foreach ($config['order']['payment'] as $k1 => $v1) { ?>
                                                                        <option value="<?=$k1?>" <?=($k1==$v['payment_status']) ? 'selected':''?>><?=$v1?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                $city = $apiPlace->getPlaceId('id','place_citys',$v['id_city'],"id, name_vi as name");
                                                                $dist = $apiPlace->getPlaceId('id','place_dists',$v['id_dist'],"id, name_vi as name");
                                                                if($v['other_address']==1){
                                                                    $city_other = $apiPlace->getPlaceId('id','place_citys',$v['id_city_other'],"id, name_vi as name");
                                                                    $dist_other = $apiPlace->getPlaceId('id','place_dists',$v['id_dist_other'],"id, name_vi as name");
                                                                }
                                                            ?>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-4 mb-0 order-title">Tỉnh thành:</label>
                                                                <div class="col-md-8 order-title"><strong><?=($v['other_address']==0) ? $city['name']:$city_other['name']?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-4 mb-0 order-title">Quận huyện:</label>
                                                                <div class="col-md-8 order-title"><strong><?=($v['other_address']==0) ? $dist['name']:$dist_other['name']?></strong></div>
                                                            </div>
                                                        </div>
                                                        <div class="coll-4" style="width: calc(100% / 3); padding: 0px 10px;">
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-3 mb-0 order-title">Họ tên:</label>
                                                                <div class="col-md-9 order-title"><strong><?=($v['other_address']==0) ? $v['fullname']:$v['fullname_other']?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-3 mb-0 order-title">Email:</label>
                                                                <div class="col-md-9 order-title"><strong><?=($v['other_address']==0) ? $v['email']:$v['email_other']?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-3 mb-0 order-title">Điện thoại:</label>
                                                                <div class="col-md-9 order-title"><strong><?=($v['other_address']==0) ? $v['phone']:$v['phone_other']?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-3 mb-0 order-title none-border">Địa chỉ:</label>
                                                                <div class="col-md-9 order-title none-border" data-toggle="tooltip" data-placement="top" title="<?=($v['other_address']==0) ? $v['address']:$v['address_other']?>"><strong><?=($v['other_address']==0) ? $v['address']:$v['address_other']?></strong></div>
                                                            </div>
                                                            <?php 
                                                                $payment_text = $func->getFieldId($v['payment'],'posts');
                                                            ?>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-3 mb-0 order-title none-border">Thanh toán:</label>
                                                                <div class="col-md-9 order-title none-border"><strong><?=($v['payment']!=1) ? $payment_text['name_vi']:'Thanh toán tại cửa hàng'?></strong></div>
                                                            </div>
                                                            <div class="row" style="flex-wrap: nowrap;">
                                                                <label class="col-md-3 mb-0 order-title none-border">Nội dung:</label>
                                                                <div class="col-md-9 order-title none-border" data-toggle="tooltip" data-placement="top" title="<?=$v['notes']?>"><strong><?=$v['notes']?></strong></div>
                                                            </div>
                                                        </div>
                                                        <div class="coll-4" style="width: calc(100% / 3); padding: 0px 10px;">
                                                            <div class="row">
                                                                <label class="col-md-3 mb-0 order-title none-border">Ghi chú:</label>
                                                                <div class="col-md-9 order-title none-border">
                                                                    <textarea rows="4" cols="80" class="form-control" name="note<?=$v['id']?>" id="note<?=$v['id']?>"><?=$item['description_'.$k]?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="order-box mt-2">
                                                    <table class="table display bg-white table-hover table-order-detail">
                                                        <thead>
                                                            <tr class="table-success">
                                                                <th>Mã hàng</th>
                                                                <th style="max-width: 300px;">Tên hàng</th>
                                                                <th>Size</th>
                                                                <th>Color</th>
                                                                <th>Số lượng</th>
                                                                <th>Đơn giá</th>
                                                                <th>Thành tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php  $qty = 0; foreach ($item_orders as $k1 => $v1) { $qty += $v1['qty']; ?>
                                                            <tr>
                                                                <td><?=$v1['code']?></td>
                                                                <td style="max-width: 400px;"><?=$v1['name']?></td>
                                                                <td><?=$v1['size_name']?></td>
                                                                <td><?=$v1['color_name']?></td>
                                                                <td><?=$v1['qty']?></td>
                                                                <td><?=$func->moneyFormat($v1['price'],'')?></td>
                                                                <td><?=$func->moneyFormat($v1['price']*$v1['qty'],'')?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="order-box">
                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col-auto"></div>
                                                        <div class="col-auto">
                                                            <table class="table none-table-order">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right">Tổng số lượng:</td>
                                                                        <td class="text-right"><?=$qty?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right">Tổng tiền hàng:</td>
                                                                        <td class="text-right"><?=$func->moneyFormat($v['total_price']+$v['sale_off'],'')?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right">Giảm giá hóa đơn:</td>
                                                                        <td class="text-right"><?=($v['sale_off']==0) ? '0':$func->moneyFormat($v['sale_off'],'')?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right">Khách cần trả:</td>
                                                                        <td class="text-right"><?=$func->moneyFormat($v['total_price'],'')?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if(count($item_returns)){ ?>
                                            <div class="tab-pane fade" id="return-orders<?=$v['id']?>" role="tabpanel" aria-labelledby="return-orders<?=$v['id']?>-tab">
                                                <div class="order-box">
                                                    <table class="table display bg-white table-hover table-order-detail">
                                                        <thead>
                                                            <tr class="table-success">
                                                                <th>Mã trả hàng</th>
                                                                <th>Ngày trả</th>
                                                                <th>Số tiền</th>
                                                                <th>Trạng thái</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($item_returns as $k1 => $v1) { ?>
                                                            <tr>
                                                                <td><?=$v1['code']?></td>
                                                                <td><?=$v1['createdAt']?></td>
                                                                <td><?=$func->moneyFormat($v1['total_price'],'')?></td>
                                                                <td><?=($v1['status']=='datra') ? 'Đã trả':'Chưa trả'?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        

                                        <div class="order-box mt-2">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto"></div>
                                                <div class="col-auto">
                                                    <button type="button" data-id="<?=$v['id']?>" class="btn btn-success btn-save-order w-100p mb-2 mr-1">
                                                        <i class="glyphicon glyphicon-floppy-disk"></i>
                                                        Lưu
                                                    </button>
                                                    <?php if(!$func->isReturnOrder($v['id'])){ ?>
                                                    <button type="button" data-id="<?=$v['id']?>" class="btn btn-success btn-save-return w-100p mb-2 mr-1">
                                                        <i class="glyphicon glyphicon-repeat"></i>
                                                        Trả hàng
                                                    </button>
                                                    <?php } ?>
                                                    <?php if($config['order']['bill-print']==true){ ?>
                                                    <button type="button" data-id="<?=$v['id']?>" data-title="Hóa đơn điện tử đơn hàng <?=$v['code']?>" class="btn btn-inverse btn-save-print w-100p mb-2 mr-1">
                                                        <i class="glyphicon glyphicon-print"></i>
                                                        In
                                                    </button>
                                                    <?php } ?>
                                                    <?php if($config['order']['export-detail']==true){ ?>
                                                    <button type="button" data-id="<?=$v['id']?>" class="btn btn-inverse btn-save-export w-100p mb-2 mr-1">
                                                        <i class="glyphicon glyphicon-save-file"></i>
                                                        Xuất file
                                                    </button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($config['order']['bill-print']==true){ ?>
                                        <div id="print-<?=$v['id']?>" style="max-width: 768px; margin: 0 auto; font-family: 'Arial';font-size: 13px; line-height: 20px;border: 1px solid #efefef; display: none;">
                                            <table style="width: 100%; border-collapse: collapse; padding: 10px; border: 1px solid #efefef; border-bottom: 0px solid #efefef;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 25%; text-align: center; padding: 10px 10px;">
                                                            <img src="<?=_upload_photo.$row_setting['favicon']?>" alt="">
                                                        </td>
                                                        <td style="width: 50%; text-align: center; padding: 10px 10px;">
                                                            <h4 style="padding: 0px; margin: 0px; line-height: 22px; font-size: 20px; color: #FF0000;">HÓA ĐƠN GIÁ TRỊ GIA TĂNG</h4>
                                                            <p style="padding: 0px; margin: 0px;">(Bản thể hiện hóa đơn điện tử)</p>
                                                            <p style="padding: 0px; margin: 0px;font-style: italic; font-size: 13px;">Ngày <?=date('d')?> Tháng <?=date('m')?> Năm <?=date('Y')?></p>
                                                        </td>
                                                        <td style="width: 25%; text-align: center; padding: 10px 10px;">
                                                            <p style="margin: 0px; padding: 0px; line-height: 20px; font-size: 13px; text-align: left;"><span>Mẫu số:</span> <span><?=$row_setting['denominator']?></span></p>
                                                            <p style="margin: 0px; padding: 0px; line-height: 20px; font-size: 13px; text-align: left;"><span>Ký hiệu:</span> <span><?=$row_setting['symbol']?></span></p>
                                                            <p style="margin: 0px; padding: 0px; line-height: 20px; font-size: 13px; text-align: left;"><span>Số:</span> <span><?=$v['code']?></span></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="width: 100%; border-collapse: collapse; border-top: 1px solid #efefef; border-left: 1px solid #efefef; border-right: 1px solid #efefef; padding: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 75%; text-align: left; padding: 10px 10px;">
                                                            <h4 style="padding: 0px; margin: 0px; text-transform: uppercase; line-height: 25px; margin-bottom: 5px; font-size: 20px; color: #FF0000;"><?=$row_setting['company']?></h4>
                                                            <p style="padding: 0px; margin: 0px;">Mã số thuế: <strong><?=$row_setting['tax_code']?></strong></p>
                                                            <p style="padding: 0px; margin: 0px;">Địa chỉ: <?=$row_setting['address']?></p>
                                                            <p style="padding: 0px; margin: 0px;">Điện thoại: <?=$row_setting['phone']?> - Website: <?=$row_setting['website']?></p>
                                                            <p style="padding: 0px; margin: 0px;">Số tài khoản:<?=$row_setting['blank']?></p>

                                                        </td>
                                                        <td style="width: 25%; text-align: right; padding: 10px 10px;">
                                                            <img src="qrcode_order.php?id=https://www.24h.com.vn/" alt="HÓA ĐƠN GIÁ TRỊ GIA TĂNG">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style="width: 100%; border-collapse: collapse; border-top: 1px solid #efefef; padding: 10px; border-left: 1px solid #efefef; border-right: 1px solid #efefef; padding: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 75%; text-align: left; padding: 10px 10px;">
                                                            <p style="padding: 0px; margin: 0px;">Tên người mua hàng: <?=$v['fullname']?></p>
                                                            <p style="padding: 0px; margin: 0px;">Điện thoại: <?=$v['phone']?></p>
                                                            <p style="padding: 0px; margin: 0px;">Địa chỉ: <?=$v['address']?></p>
                                                            <p style="padding: 0px; margin: 0px;">Hình thức thanh toán: <?=($v['payment']!=1) ? $payment_text['name_vi']:'Thanh toán tại cửa hàng'?></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="width: 100%; border-collapse: collapse; border-top: 1px solid #efefef; padding: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="padding: 5px 10px; width: 3%; border: 1px solid #efefef; ">STT</th>
                                                        <th style="padding: 5px 10px; width: 37%; border: 1px solid #efefef">Tên hàng hóa / dịch vụ</th>
                                                        <th style="padding: 5px 10px; border: 1px solid #efefef">Đơn vị tính</th>
                                                        <th style="padding: 5px 10px; border: 1px solid #efefef">Số lượng</th>
                                                        <th style="padding: 5px 10px; width: 15%; border: 1px solid #efefef">Đơn giá</th>
                                                        <th style="padding: 5px 10px; width: 15%; border: 1px solid #efefef;">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef;"><strong>1</strong></td>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef"><strong>2</strong></td>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef"><strong>3</strong></td>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef"><strong>4</strong></td>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef"><strong>5</strong></td>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef;"><strong>4 x 5</strong></td>
                                                    </tr>
                                                    <?php  $qty_in = 0; foreach ($item_orders as $k1 => $v1) { $qty_in += $v1['qty']; ?>
                                                    <tr>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef;"><?=($k1+1)?></td>
                                                        <td style="padding: 5px 10px; text-align: left; border: 1px solid #efefef"><?=$v1['name']?> <?=($v1['size']!=0) ? ' - Size: '.$v1['size_name']:''?> <?=($v1['color']!=0) ? ' - Color: '.$v1['color_name']:''?></td>
                                                        <td style="padding: 5px 10px; text-align: center; border: 1px solid #efefef">cái</td>
                                                        <td style="padding: 5px 10px; text-align: right; border: 1px solid #efefef"><?=$v1['qty']?></td>
                                                        <td style="padding: 5px 10px; text-align: right; border: 1px solid #efefef"><?=$func->moneyFormat($v1['price'],'')?></td>
                                                        <td style="padding: 5px 10px; text-align: right; border: 1px solid #efefef;"><?=$func->moneyFormat($v1['price']*$v1['qty'],'')?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;" colspan="5">Cộng tiền hàng:</td>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;"><?=$func->moneyFormat($v['total_price']+$v['sale_off'],'')?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;" colspan="5">Giảm giá hóa đơn:</td>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;"><?=$func->moneyFormat($v['sale_off'],'')?></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;" colspan="3">Thuế GTGT <span style="font-style: italic;">(VAT): 10%</span>:</td>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef;  text-align: right;" colspan="2">Tiền thuế GTGT:</td>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;"><?=$func->moneyFormat($v['total_price']/10,'')?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;" colspan="5">Tổng cộng tiền thanh toán:</td>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef; text-align: right;"><?=$func->moneyFormat($v['total_price']/10 + $v['total_price'],'')?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 5px 10px; border: 1px solid #efefef;" colspan="6">
                                                            <?php $total_p = $v['total_price']/10 + $v['total_price']; ?>
                                                            Số tiền viết bằng chữ: <?=$func->getMoneyText($total_p)?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="width: 100%; border-collapse: collapse; padding: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%; text-align: center; padding: 10px 10px;">
                                                            <p style="padding: 0px; margin: 0px; "><strong>Người mua hàng</strong></p>
                                                            <p style="padding: 0px; margin: 0px; padding-bottom: 100px; font-style: italic;">(Ký và ghi rõ họ tên)</p>
                                                        </td>
                                                        <td style="width: 50%; text-align: center; padding: 10px 10px;">
                                                            <p style="padding: 0px; margin: 0px; "><strong>Người bán hàng</strong></p>
                                                            <p style="padding: 0px; margin: 0px; padding-bottom: 100px; font-style: italic;">(Ký và ghi rõ họ tên)</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <nav aria-label="Page navigation example">
                                <?=$paging?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--/.body content-->