<?php
    if($_GET['month']!='' && $_GET['year']!=''){
        $gt = $_GET['year'].'-'.$_GET['month'].'-'.'1';
        $date = strtotime($gt);
    } else {
        $date = strtotime(date('y-m-d')); 
    } 
    $day = date('d', $date);
    $month = date('m', $date);
    $year = date('Y', $date);
    $firstDay = mktime(0,0,0,$month, 1, $year);
    $title = strftime('%B', $firstDay);
    $dayOfWeek = date('D', $firstDay);
    $daysInMonth = cal_days_in_month(0, $month, $year);
    $timestamp = strtotime('next Sunday');
    $weekDays = array();
    for ($i = 0; $i < 7; $i++) {
        $weekDays[] = strftime('%a', $timestamp);
        $timestamp = strtotime('+1 day', $timestamp);
    }
    $blank = date('w', strtotime("{$year}-{$month}-01"));
    $gth = array();
    $doanhthu = array();
    for($i = 1; $i <= $daysInMonth; $i++){
        $k = $i+1;
        $begin = strtotime($year.'-'.$month.'-'.$i);
        $start_day = $year.'-'.$month.'-'.$i.' 00:00:00';
        if($i==$daysInMonth){
            if($month==12){
                $year_tt = $year+1;
                $end = strtotime($year_tt.'-1-1');
                $end_day = $year_tt.'-1-1'.' 00:00:00';
            } else {
                $month_tt = $month+1;
                $end = strtotime($year.'-'.$month_tt.'-1');
                $end_day = $year.'-'.$month_tt.'-1'.' 00:00:00';
            }
        } else {
            $end = strtotime($year.'-'.$month.'-'.$k);
            $end_day = $year.'-'.$month_tt.'-1'.' 00:00:00';
        }
        $query             =    "SELECT COUNT(*) AS todayrecord FROM #_counters WHERE tm>='$begin' and tm<'$end'"; 
        $todayrc  = $d->rawQueryOne($query); 
        $today_visitors     =    $todayrc['todayrecord']; 
        array_push($gth,$today_visitors);
        $start_day = date('Y-m-d',$begin).' 00:00:00';
        $end_day = date('Y-m-d',$end).' 00:00:00';
        $query_t =    "SELECT sum(total_price) AS total FROM #_orders WHERE UNIX_TIMESTAMP(createdAt) >= UNIX_TIMESTAMP('".$start_day."') and UNIX_TIMESTAMP(createdAt) <= UNIX_TIMESTAMP('".$end_day."')";
        $today_r  = $d->rawQueryOne($query_t);
        $toc = (!$today_r['total']) ? '0':$today_r['total'];
        array_push($doanhthu,$toc);
    }
    $sql_order = "SELECT * from #_orders where type=? and view=? order by id desc limit 0,10";
    $items = $d->rawQuery($sql_order,array('don-hang',0));
    $sql_setting = "SELECT * from #_settings limit 0,1";
    $items_setting = $d->rawQueryOne($sql_setting);
    $sql_order = "SELECT sum(qty) as total, name from #_order_details where id_order in (select id from #_orders where order_status=3) group by id_product order by id desc limit 0,10";
    $items_product = $d->rawQuery($sql_order);


    $sql_order = "select sum(total_price) as total from #_orders where order_status=3 ";
    $total_price = $d->rawQueryOne($sql_order);

    $sql_order = "select count(id) as total from #_orders where order_status=3 and payment_status=1";
    $order_success = $d->rawQueryOne($sql_order);

    $sql_order = "select count(id) as total from #_order_returns where find_in_set('datra',status)";
    $order_return = $d->rawQueryOne($sql_order);

    $sql_order = "select count(id) as total from #_orders where order_status=4";
    $order_cancel = $d->rawQueryOne($sql_order);
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Dashboard</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content" id="index-chart">
    <?php if($_SESSION['login']['role']==3){ ?>
        <?php if ($config['cart']['check']==true){ ?>
        <div class="row">
            <div class="col-md-12 col-lg-4 col-xl-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="wrap_bg_block_333_content">
                            <div class="count _1">
                                <svg class="total-revenue" style="width:50px;height:50px;">
                                    <use xlink:href="#total-revenue" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                </svg>
                            </div>
                            <div class="content">
                                <h2 style="color:#928fd2;" data-bind="sumTotalSales"><?=($total_price['total']!=0) ? $func->moneyFormat($total_price['total'],''):0?></h2>
                                Tổng doanh thu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="wrap_bg_block_333_content">
                            <div class="count _2">
                                <svg class="order-finalize" style="width:50px;height:50px; margin-left: 4px;">
                                    <use xlink:href="#order-finalize" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                </svg>
                            </div>
                            <div class="content">
                                <h2 style="color:#5EB858;" data-bind="sumTotalSales"><?=$order_success['total']?></h2>
                                Đơn hoàn thành
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="wrap_bg_block_333_content">
                            <div class="count _3">
                                <svg class="order-return" style="width:50px;height:50px; margin-top: 4px;">
                                    <use xlink:href="#order-return" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                </svg>
                            </div>
                            <div class="content">
                                <h2 style="color:#ffa939;" data-bind="sumTotalSales"><?=$order_return['total']?></h2>
                                Đơn hàng trả
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="wrap_bg_block_333_content">
                            <div class="count _4">
                                <svg class="order-cancel" style="width:50px;height:50px;">
                                    <use xlink:href="#order-cancel" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                </svg>
                            </div>
                            <div class="content">
                                <h2 style="color:#ff5246;" data-bind="sumTotalSales"><?=$order_cancel['total']?></h2>
                                Đơn hàng hủy
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="fs-18 font-weight-bold mb-0">Doanh thu tháng</h2>
                    </div>
                    <div class="card-body">
                        <form action="index.html" method="get" name="form-doanhthu" id="form-doanhthu" accept-charset="utf-8">
                            <input type="hidden" name="com" value="<?=$_GET['com']?>">
                            <input type="hidden" name="act" value="<?=$_GET['act']?>">
                            <input type="hidden" name="type" value="<?=$_GET['type']?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control basic-single" name="month" id="month">
                                            <option>Chọn tháng</option>
                                            <?php for($i=1;$i<=12;$i++){
                                                if($_GET['year']){
                                                    $selected = ($i==$_GET['month']) ? 'selected':'';
                                                }else{
                                                    $selected = ($i==date('m')) ? 'selected':'';
                                                }
                                            ?>
                                            <option value="<?=$i?>" <?=$selected?>>Tháng <?=$i?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control basic-single" name="year" id="year">
                                            <option>Chọn tháng</option>
                                            <?php for($i=2000;$i<=date(Y)+20;$i++){
                                                if($_GET['year']){
                                                    $selected = ($i==$_GET['year']) ? 'selected':'';
                                                }else{
                                                    $selected = ($i==date('Y')) ? 'selected':'';
                                                }
                                            ?>
                                            <option value="<?=$i?>" <?=$selected?>>Năm <?=$i?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-fill btn-primary">Thống kê</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="chart_revenue"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(count($items_product)>0){ ?>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="fs-18 font-weight-bold mb-0">Top 10 sản phẩm được mua nhiều nhất</h2>
                    </div>
                    <div class="card-body">
                        <div id="chart_order"></div>
                         <div class="table-responsive">
                            <table class="table display table-striped table-hover table-border mb-0">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng (Cái)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items_product as $k => $v) { ?>
                                    <tr>
                                        <td><?=$v['name']?></td>
                                        <td><?=$v['total']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if(count($items)>0){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Đơn hàng mới nhất</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display table-striped table-hover table-border mb-0">
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
                                                        <?php if($config['bill-print']==true){ ?>
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
                                            <?php if($config['bill-print']==true){ ?>
                                            <div id="print-<?=$v['id']?>" style="max-width: 768px; margin: 0 auto; font-family: 'Arial';font-size: 13px; line-height: 20px;border: 1px solid #efefef; display: none;">
                                                <table style="width: 100%; border-collapse: collapse; padding: 10px; border: 1px solid #efefef; border-bottom: 0px solid #efefef;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 25%; text-align: center; padding: 10px 10px;">
                                                                <img src="<?=_upload_photo.$items_setting['favicon']?>" alt="">
                                                            </td>
                                                            <td style="width: 50%; text-align: center; padding: 10px 10px;">
                                                                <h4 style="padding: 0px; margin: 0px; line-height: 22px; font-size: 20px; color: #FF0000;">HÓA ĐƠN GIÁ TRỊ GIA TĂNG</h4>
                                                                <p style="padding: 0px; margin: 0px;">(Bản thể hiện hóa đơn điện tử)</p>
                                                                <p style="padding: 0px; margin: 0px;font-style: italic; font-size: 13px;">Ngày <?=date('d')?> Tháng <?=date('m')?> Năm <?=date('Y')?></p>
                                                            </td>
                                                            <td style="width: 25%; text-align: center; padding: 10px 10px;">
                                                                <p style="margin: 0px; padding: 0px; line-height: 20px; font-size: 13px; text-align: left;"><span>Mẫu số:</span> <span><?=$items_setting['denominator']?></span></p>
                                                                <p style="margin: 0px; padding: 0px; line-height: 20px; font-size: 13px; text-align: left;"><span>Ký hiệu:</span> <span><?=$items_setting['symbol']?></span></p>
                                                                <p style="margin: 0px; padding: 0px; line-height: 20px; font-size: 13px; text-align: left;"><span>Số:</span> <span><?=$v['code']?></span></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="width: 100%; border-collapse: collapse; border-top: 1px solid #efefef; border-left: 1px solid #efefef; border-right: 1px solid #efefef; padding: 10px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 75%; text-align: left; padding: 10px 10px;">
                                                                <h4 style="padding: 0px; margin: 0px; text-transform: uppercase; line-height: 25px; margin-bottom: 5px; font-size: 20px; color: #FF0000;"><?=$items_setting['company']?></h4>
                                                                <p style="padding: 0px; margin: 0px;">Mã số thuế: <strong><?=$items_setting['tax_code']?></strong></p>
                                                                <p style="padding: 0px; margin: 0px;">Địa chỉ: <?=$items_setting['address']?></p>
                                                                <p style="padding: 0px; margin: 0px;">Điện thoại: <?=$items_setting['phone']?> - Website: <?=$items_setting['website']?></p>
                                                                <p style="padding: 0px; margin: 0px;">Số tài khoản:<?=$items_setting['blank']?></p>

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
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
<div style="display: none;">
    <svg id="total-revenue" width="100%" height="100%" x="12.5" y="10">
        <g id="Group_1639" data-name="Group 1639" transform="translate(-450 -449.846)">
            <g id="Group_1638" data-name="Group 1638" transform="translate(450 449.846)">
                <path id="Path_4153" data-name="Path 4153" d="M462.08,479.041a12.072,12.072,0,0,1,9.526-4.639,12.338,12.338,0,0,1,1.71.118v-2.581c-1.749,1.573-6.283,2.693-11.61,2.693-5.294,0-9.815-1.107-11.584-2.673v3.322C451.007,478.9,461.956,479.048,462.08,479.041Z" transform="translate(-450.084 -464.897)" fill="#928fd2"></path>
                <path id="Path_4154" data-name="Path 4154" d="M450.088,490.489l-.006,3.374c.426,1.874,4.377,3.394,9.494,3.728a11.91,11.91,0,0,1,1.468-4.429C456.018,493.077,451.779,492,450.088,490.489Z" transform="translate(-450.056 -477.535)" fill="#928fd2"></path>
                <path id="Path_4155" data-name="Path 4155" d="M450.068,509.224l-.007,3.211a.414.414,0,0,1,.059-.052c.124,2.07,4.547,3.767,10.228,4.01a12,12,0,0,1-.878-4.534v-.007C455.132,511.583,451.575,510.574,450.068,509.224Z" transform="translate(-450.042 -490.298)" fill="#928fd2"></path>
                <path id="Path_4156" data-name="Path 4156" d="M461.088,530.519c-5.124-.085-9.428-1.219-11.04-2.765l-.006,3.027c0,2.28,5.2,4.128,11.61,4.128a31.546,31.546,0,0,0,3.512-.19A12.2,12.2,0,0,1,461.088,530.519Z" transform="translate(-450.028 -502.922)" fill="#928fd2"></path>
                <ellipse id="Ellipse_8" data-name="Ellipse 8" cx="11.623" cy="4.121" rx="11.623" ry="4.121" fill="#928fd2"></ellipse>
                <path id="Path_4157" data-name="Path 4157" d="M495,484.7a10.473,10.473,0,1,0,10.477,10.47A10.477,10.477,0,0,0,495,484.7Zm.957,16.066v.662a.957.957,0,0,1-1.913,0v-.662a3.393,3.393,0,0,1-1.481-.911.959.959,0,0,1,.039-1.35.978.978,0,0,1,1.349.039,2.016,2.016,0,0,0,1.147.445,1.434,1.434,0,0,0-.1-2.863,3.343,3.343,0,0,1-.956-6.545v-.662a.957.957,0,1,1,1.913,0v.662a3.387,3.387,0,0,1,1.481.911.959.959,0,0,1-.039,1.35.93.93,0,0,1-1.35-.039,1.642,1.642,0,0,0-1.147-.445,1.433,1.433,0,0,0,.1,2.863,3.343,3.343,0,0,1,.957,6.546Z" transform="translate(-473.474 -473.642)" fill="#928fd2"></path>
            </g>
        </g>
    </svg>
    <svg id="total-profit" width="100%" height="100%" x="9" y="10">
        <path id="Path_4163" data-name="Path 4163" d="M34.061,27.618A7.013,7.013,0,0,0,32.845,29.8h-19.7a7.13,7.13,0,0,0-1.287-2.184H9.953a4.369,4.369,0,0,1-2.317-.677H7.007v2.093a3.558,3.558,0,0,0,1.06,2.348,3.184,3.184,0,0,0,1.886.677H36.062a3,3,0,0,0,2.945-3.025V26.452a4.316,4.316,0,0,1-2.945,1.166Z" fill="#0089ff" />
        <path id="Path_4164" data-name="Path 4164" d="M36.062,8.008H9.953A2.965,2.965,0,0,0,7.007,11V23.08a3.581,3.581,0,0,0,1.06,2.355,3.184,3.184,0,0,0,1.886.677H36.062a3,3,0,0,0,2.945-3.032V11A2.964,2.964,0,0,0,36.062,8.008Zm.754,11.678a6.743,6.743,0,0,0-3.971,4.167h-19.7A7.164,7.164,0,0,0,9.2,19.73V14.368a6.78,6.78,0,0,0,3.935-4.14H32.863a6.325,6.325,0,0,0,3.955,4.179v5.279Z" fill="#0089ff" />
        <path id="Path_4165" data-name="Path 4165" d="M22.984,11.7a5.351,5.351,0,1,0,5.19,5.349A5.27,5.27,0,0,0,22.984,11.7Zm.426,8.41v1H22.5v-.928a3.73,3.73,0,0,1-1.639-.425l.284-1.156a3.306,3.306,0,0,0,1.589.435c.547,0,.919-.218.919-.612,0-.376-.307-.613-1.016-.86-1.027-.357-1.724-.85-1.724-1.809a1.81,1.81,0,0,1,1.622-1.759v-.94h.95v.872a3.423,3.423,0,0,1,1.382.326l-.28,1.117a3.131,3.131,0,0,0-1.383-.336c-.623,0-.825.276-.825.553,0,.326.334.533,1.149.85,1.142.415,1.6.958,1.6,1.848A1.879,1.879,0,0,1,23.41,20.109Z" fill="#0089ff" />
        <path id="Path_4166" data-name="Path 4166" d="M34.061,33.566a7,7,0,0,0-1.216,2.183h-19.7a7.113,7.113,0,0,0-1.287-2.183H9.953a4.361,4.361,0,0,1-2.317-.678H7.007v2.094a3.558,3.558,0,0,0,1.06,2.348,3.191,3.191,0,0,0,1.886.678H36.062a3,3,0,0,0,2.945-3.027V32.4a4.311,4.311,0,0,1-2.945,1.166h-2Z" fill="#0089ff" />
    </svg>
    <svg id="gross-margin" width="100%" height="100%" x="9" y="10">
        <path id="Path_4158" data-name="Path 4158" d="M268.055,248.509l.178,7.357a2.858,2.858,0,0,1-1.4,2.539l-13.392,7.836,7.947,4.634a.921.921,0,0,0,.538.124.938.938,0,0,0,.742-.474l8.785-15.453a.959.959,0,0,0-.013-.971Z" fill="#928fd2" />
        <path id="Path_4159" data-name="Path 4159" d="M250.258,251.526a.371.371,0,0,0-.188-.052.358.358,0,0,0-.1.014.376.376,0,0,0-.23.179.388.388,0,0,0-.038.291.378.378,0,0,0,.694.093.392.392,0,0,0,.038-.292A.382.382,0,0,0,250.258,251.526Z" fill="#928fd2" />
        <path id="Path_4160" data-name="Path 4160" d="M257.344,255.094a.385.385,0,0,0-.267.47.375.375,0,0,0,.176.233.37.37,0,0,0,.287.039.385.385,0,0,0,.268-.47A.378.378,0,0,0,257.344,255.094Z" fill="#928fd2" />
        <path id="Path_4161" data-name="Path 4161" d="M266.359,255.913l-.222-9.159a.951.951,0,0,0-.449-.787l-.849-.525a2,2,0,0,0-.525,1.355,2.026,2.026,0,0,0,.183.84,2.87,2.87,0,0,1-1.367,3.786,2.758,2.758,0,0,1-1.183.265,2.819,2.819,0,0,1-2.552-1.65,7.834,7.834,0,0,1-.706-3.241,7.729,7.729,0,0,1,1.326-4.341l-2.043-1.264a.928.928,0,0,0-.957-.012l-16.545,9.681a.957.957,0,0,0-.343,1.3l7.937,13.933a.936.936,0,0,0,.813.476.92.92,0,0,0,.468-.128l16.545-9.681A.954.954,0,0,0,266.359,255.913Zm-16.289-1.77a2.264,2.264,0,0,1-2.178-1.693,2.294,2.294,0,0,1,.225-1.733,2.242,2.242,0,0,1,1.369-1.065,2.217,2.217,0,0,1,1.71.229,2.266,2.266,0,0,1,1.05,1.386,2.3,2.3,0,0,1-.225,1.734,2.244,2.244,0,0,1-1.369,1.064A2.209,2.209,0,0,1,250.07,254.143Zm2.433,5.217a.927.927,0,0,1-.243-.032.952.952,0,0,1-.663-1.164l2.511-9.5a.936.936,0,0,1,1.148-.672.951.951,0,0,1,.663,1.163l-2.511,9.5A.94.94,0,0,1,252.5,259.36Zm5.523-1.689a2.221,2.221,0,0,1-.583.078,2.264,2.264,0,0,1-2.178-1.693,2.291,2.291,0,0,1,1.594-2.8h0a2.252,2.252,0,0,1,2.76,1.615A2.289,2.289,0,0,1,258.026,257.671Z" fill="#928fd2" />
        <path id="Path_4162" data-name="Path 4162" d="M261.946,249.788a.926.926,0,0,0,.395-.088.956.956,0,0,0,.455-1.262,3.967,3.967,0,0,1-.357-1.641,3.844,3.844,0,1,1,7.687,0,3.979,3.979,0,0,1-.181,1.19l1.162,1.921a5.746,5.746,0,1,0-10.543-3.111,5.882,5.882,0,0,0,.532,2.441A.936.936,0,0,0,261.946,249.788Z" fill="#928fd2" />
    </svg>
    <svg id="shopping-turn" width="100%" height="100%" x="13" y="13">
        <g id="shopping-cart">
            <path id="Path_4152" data-name="Path 4152" d="M250.2,262.2a2.4,2.4,0,1,0,2.4,2.4A2.407,2.407,0,0,0,250.2,262.2ZM243,243v2.4h2.4l4.32,9.12-1.68,2.88a4.264,4.264,0,0,0-.24,1.2,2.407,2.407,0,0,0,2.4,2.4h14.4v-2.4H250.68a.258.258,0,0,1-.24-.24v-.12l1.08-2.04h8.88a2.189,2.189,0,0,0,2.04-1.2l4.32-7.8a.661.661,0,0,0,.24-.6,1.134,1.134,0,0,0-1.2-1.2H248.04l-1.08-2.4Zm19.2,19.2a2.4,2.4,0,1,0,2.4,2.4A2.407,2.407,0,0,0,262.2,262.2Z" transform="translate(-243 -243)" fill="#54cfe8" />
        </g>
    </svg>
    <svg id="customer-buy" width="100%" height="100%" x="13" y="13">
        <path id="Path_4129" data-name="Path 4129" d="M150.375,133.617a.934.934,0,0,0-.171-.056l-3.376-.775v-1.752a5.978,5.978,0,0,0,1.964-4.45V123.1a5.478,5.478,0,0,0-5.421-5.522h-.94a5.478,5.478,0,0,0-5.421,5.522v3.479a5.976,5.976,0,0,0,1.964,4.45v1.752l-3.376.775a.962.962,0,0,0-.171.056,3.939,3.939,0,0,0-2.344,3.621V139.3a1,1,0,0,0,.741.969l1.636.423a31.255,31.255,0,0,0,7.426.89,31.6,31.6,0,0,0,7.468-.893l1.625-.42a1,1,0,0,0,.74-.969v-2.062A3.939,3.939,0,0,0,150.375,133.617Z" transform="translate(-133.083 -117.583)" fill="#928fd2" />
    </svg>
    <svg id="order-finalize" width="100%" height="100%" x="13" y="13">
        <path id="Path_4119" data-name="Path 4119" d="M136.25,100.157v5.335h5.5Z" transform="translate(-124.066 -99.58)" fill="#5eb858" />
        <path id="Path_4120" data-name="Path 4120" d="M124.752,106.967a1,1,0,0,1-1.015-.985v-6.9H114.6a1,1,0,0,0-1.015.986v21.68a1,1,0,0,0,1.015.985h16.245a1,1,0,0,0,1.015-.985V106.967Zm-3.532,11.1-1.925,1.495a1.039,1.039,0,0,1-1.352-.073l-.77-.748a.966.966,0,0,1,0-1.394,1.037,1.037,0,0,1,1.435,0l.128.124,1.215-.945a1.038,1.038,0,0,1,1.429.154A.969.969,0,0,1,121.22,118.067Zm0-3.942-1.925,1.5a1.039,1.039,0,0,1-1.352-.073l-.77-.748a.965.965,0,0,1,0-1.393,1.037,1.037,0,0,1,1.435,0l.128.124,1.215-.945a1.039,1.039,0,0,1,1.429.154A.968.968,0,0,1,121.22,114.125Zm0-3.942-1.925,1.495a1.037,1.037,0,0,1-1.352-.073l-.77-.748a.965.965,0,0,1,0-1.393,1.037,1.037,0,0,1,1.435,0l.128.124,1.215-.945a1.04,1.04,0,0,1,1.429.154A.969.969,0,0,1,121.22,110.183Zm6.578,8.609h-4.062a.986.986,0,1,1,0-1.971H127.8a.986.986,0,1,1,0,1.971Zm0-3.942h-4.062a.986.986,0,1,1,0-1.971H127.8a.986.986,0,1,1,0,1.971Zm0-3.942h-4.062a.986.986,0,1,1,0-1.971H127.8a.986.986,0,1,1,0,1.971Z" transform="translate(-113.583 -99.083)" fill="#5eb858" />
    </svg>
    <svg id="order-cancel" width="100%" height="100%" x="13" y="13">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
            <circle id="Ellipse_4" data-name="Ellipse 4" cx="12" cy="12" r="12" fill="#ff5246" />
            <path id="Path_4151" data-name="Path 4151" d="M39.16,31.847a1.2,1.2,0,0,1-1.692,0L34,28.379l-3.468,3.468a1.2,1.2,0,1,1-1.692-1.692l3.468-3.467L28.84,23.219a1.2,1.2,0,0,1,1.692-1.692L34,25l3.468-3.469a1.2,1.2,0,0,1,1.692,1.692l-3.468,3.469,3.468,3.468A1.216,1.216,0,0,1,39.16,31.847Z" transform="translate(-22 -14.688)" fill="#fff" />
        </svg>
    </svg>
    <svg id="order-return" width="100%" height="100%" x="13" y="13">
        <path id="Path_4149" data-name="Path 4149" d="M18.656,14.548l4.6-4.729a1.412,1.412,0,0,0-.791-.869,1.369,1.369,0,0,0-1.516.31l-6.14,6.311a1.921,1.921,0,0,0,0,2.666l6.14,6.311a1.369,1.369,0,0,0,1.516.311,1.418,1.418,0,0,0,.791-.868l-4.6-4.73A3.4,3.4,0,0,1,18.656,14.548Z" transform="translate(-14.273 -8.842)" fill="#ffa939" />
        <path id="Path_4150" data-name="Path 4150" d="M42.067,21.436c-.717-3.131-2.965-7.492-9.714-8.414v-2.76a1.423,1.423,0,0,0-.861-1.314,1.366,1.366,0,0,0-1.516.31l-6.14,6.312a1.921,1.921,0,0,0,0,2.666l6.14,6.31a1.371,1.371,0,0,0,.986.419,1.351,1.351,0,0,0,.53-.108,1.423,1.423,0,0,0,.861-1.314V20.874c2.309,0,5.633.313,8,1.82a1.123,1.123,0,0,0,1.271-.042A1.178,1.178,0,0,0,42.067,21.436Z" transform="translate(-18.447 -8.841)" fill="#ffa939" />
    </svg>
    <svg id="credit-card" width="100%" height="100%">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24">
            <path d="M23.6 10H.4c-.2 0-.4.5-.4.7v7.7c0 .7.6 1.6 1.3 1.6h21.4c.7 0 1.3-.9 1.3-1.6v-7.7c0-.2-.2-.7-.4-.7zM20 16.6c0 .2-.2.4-.4.4h-4.1c-.2 0-.4-.2-.4-.4v-2.1c0-.2.2-.4.4-.4h4.1c.2 0 .4.2.4.4v2.1zM22.7 4H1.3C.6 4 0 4.9 0 5.6v1.7c0 .2.2.7.4.7h23.1c.3 0 .5-.5.5-.7V5.6c0-.7-.6-1.6-1.3-1.6z"></path>
        </svg>
    </svg>
    <svg id="right-arrow" width="100%" height="100%">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
            <path d="M21.205,5.007c-0.429-0.444-1.143-0.444-1.587,0c-0.429,0.429-0.429,1.143,0,1.571l8.047,8.047H1.111  C0.492,14.626,0,15.118,0,15.737c0,0.619,0.492,1.127,1.111,1.127h26.554l-8.047,8.032c-0.429,0.444-0.429,1.159,0,1.587  c0.444,0.444,1.159,0.444,1.587,0l9.952-9.952c0.444-0.429,0.444-1.143,0-1.571L21.205,5.007z" fill="#0088ff" />
        </svg>
    </svg>
    <svg id="scan-serial" width="100%" height="100%">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="15px" height="17px" viewBox="0 0 15 17" enable-background="new 0 0 15 17" xml:space="preserve">
            <g>
                <g>
                    <polygon fill="#212b35" points="5,1.5 2,1.5 0,1.5 0,3.5 0,6.5 2,6.5 2,3.5 5,3.5         " />
                    <polygon fill="#212b35" points="9.999,1.5 13,1.5 15,1.5 15,3.5 15,6.5 13,6.5 13,3.5 9.999,3.5       " />
                </g>
                <g>
                    <polygon fill="#212b35" points="5,15.5 2,15.5 0,15.5 0,13.5 0,10.5 2,10.5 2,13.5 5,13.5         " />
                    <polygon fill="#212b35" points="9.999,15.5 13,15.5 15,15.5 15,13.5 15,10.5 13,10.5 13,13.5 9.999,13.5       " />
                </g>
                <path fill="#212b35" d="M3,4.5v8h9v-8H3z M5,11.5H4v-6h1V11.5z M7,10.5H6v-5h1V10.5z M9,10.5H8v-5h1V10.5z M11,11.5h-1v-6h1V11.5z" />
            </g>
        </svg>
    </svg>
    <svg id="scan-scale" width="100%" height="100%">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             width="15px" height="17px" viewBox="0 0 15 17" enable-background="new 0 0 15 17" xml:space="preserve">
            <path fill="#212b35" d="M10,8V5.094C13.052,3.922,15,1,15,1H0c1.744,2.204,3.429,3.458,5,4.077V8H2l-2,9h15l-2-9H10z M5,15H4v-5h1
    V15z M7,14H6v-4h1V14z M7,5.549c0.342,0.027,0.674,0.023,1-0.001V8H7V5.549z M9,14H8v-4h1V14z M11,15h-1v-5h1V15z" />
        </svg>
    </svg>
    <svg id="scan-normal" width="100%" height="100%">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             width="15px" height="17px" viewBox="0 0 15 17" enable-background="new 0 0 15 17" xml:space="preserve">
            <g>
                <g>
                    <rect x="1.998" fill="#212b35" width="2" height="5" />
                    <rect x="4.999" fill="#212b35" width="2" height="4" />
                    <rect x="7.999" fill="#212b35" width="2.001" height="5" />
                    <rect x="11.002" fill="#212b35" width="2" height="4" />
                </g>
            <path fill="#212b35" d="M12.132,6H2.868C2.388,6,2,6.321,2,6.718v0.547C1.997,7.9,2.431,8.48,3.119,8.763l0.913,0.377
        c0.886,0.359,1.444,1.106,1.441,1.926v2.429c-0.002,0.894,0.414,1.754,1.158,2.401v0.862c0,0.134,0.129,0.24,0.29,0.24h1.157
        c0.161,0,0.289-0.106,0.289-0.239v-0.863c0.744-0.646,1.16-1.508,1.158-2.4v-2.43c-0.004-0.815,0.556-1.563,1.438-1.926
        l0.914-0.376C12.568,8.48,13.004,7.9,13,7.265V6.718C13,6.321,12.611,6,12.132,6z M11.5,8h-8C3.224,8,3,7.776,3,7.5S3.224,7,3.5,7
        h8C11.775,7,12,7.224,12,7.5S11.775,8,11.5,8z" />
            </g>
    </svg>
</div>

<style type="text/css" media="screen">
    .count {
        margin-right: 15px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .count._1{
        background-color: #efeef8;
    }
    .count._2{
        background-color: #e7f5e6;
    }
    .count._3{
        background-color: #fff2e1;
    }
    .count._4{
        background-color: #ffe5e3;
    }
    .wrap_bg_block_333_content{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .wrap_bg_block_333_content .content{
        width: calc(100% - 65px);
    }
    .wrap_bg_block_333_content .content h2{
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 3px;
    }
</style>