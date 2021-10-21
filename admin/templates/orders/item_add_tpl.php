<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="index.html?com=orders&act=man<?=$url_type?>"><?=$csetting['name']?></a></li>
            <li class="breadcrumb-item active"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
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
    <form action="index.html?com=orders&act=save<?=$url_type?><?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-profile" id="form-profile"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin mua hàng</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Khách hàng</label>
                                    <select name="data[id_customer]" id="load_user" class="form-control select-customer">
                                        <option value="0">Khách lẻ</option>
                                        <?php foreach ($items_members as $k => $v) { ?>
                                        <option value="<?=$v['id']?>"><?=$v['fullname']?> - <?=$v['email']?> - <?=$v['phone']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Email address</label>
                                    <input type="email" id="email" class="form-control" data-validation="email" data-validation-error-msg="Email không hợp lệ" value="<?=$item['email']?>" name="data[email]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Họ và tên</label>
                                    <input type="text" id="fullname" class="form-control" data-validation="required" data-validation-error-msg="Họ và tên không được để trống" value="<?=$item['fullname']?>" name="data[fullname]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Điện thoại</label>
                                    <input type="text" id="phone" data-validation="required" data-validation-error-msg="Điện thoại không được để trống" class="form-control" value="<?=$item['phone']?>" name="data[phone]">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Địa chỉ</label>
                                    <input type="text" id="address" class="form-control" value="<?=$item['address']?>" data-validation="required" data-validation-error-msg="Địa chỉ không được để trống" name="data[address]">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Tỉnh / thành</label>
                                        <select class="form-control" name="data[id_city]" onchange="onChangePage(this.value,'place_dists','null','id_dist','id_city')" id="id_city">
                                        <option value="Chọn tỉnh thành">Chọn tỉnh / thành</option>
                                        <?php foreach ($item_citys as $k => $v){ ?>
                                        <option value="<?=$v['id']?>" <?=($item['id_city']==$v['id'] || $_GET['id_city']==$v['id']) ? 'selected':''?>><?=$v['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Quận huyện</label>
                                        <select class="form-control" name="data[id_dist]" id="id_dist">
                                        <option value="Chọn tỉnh thành">Chọn quận / huyện</option>
                                        <?php foreach ($item_dists as $k => $v){ ?>
                                        <option value="<?=$v['id']?>" <?=($item['id_dist']==$v['id'] || $_GET['id_dist']==$v['id']) ? 'selected':''?>><?=$v['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Tạo đơn hàng'?></button>
                        <a role="button" href="index.html?com=orders&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-body" id="loadAddCart">
                                <?=$cart->viewCart()?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fs-17 font-weight-600 mb-0">Thông tin sản phẩm</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table v table-borderless no-styling basic">
                                        <thead>
                                            <tr>
                                                <th>Hình</th>
                                                <th>Tên</th>
                                                <?php if($config['cart']['advance']==true){ ?>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <?php } ?>
                                                <th>Giá bán</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items_products as $k => $v) {
                                                $product_color = $d->rawQuery("SELECT id,name_vi as name, price, qty, photo, thumb from #_product_properties where type=? and id_product=? and find_in_set ('hienthi',status) order by numb asc",array('color',$v['id']));
                                                $product_size = $d->rawQuery("SELECT id,name_vi as name, price, qty, photo, thumb from #_product_properties where type=? and id_product=? and find_in_set ('hienthi',status) order by numb asc",array('size',$v['id']));
                                            ?>
                                            <tr >
                                                <td>
                                                    <img src="<?=$path_product.$v['photo']?>" width="30">
                                                </td>
                                                <td><?=$v['name_vi']?></td>
                                                <?php if($config['cart']['advance']==true){ ?>
                                                <td>
                                                    <select name="color<?=$v['id']?>" id="color<?=$v['id']?>">
                                                        <option value="0">Chọn màu</option>
                                                        <?php if(count($product_color)>0){ ?>
                                                        <?php foreach ($product_color as $k1 => $v1){ ?>
                                                        <option value="<?=$v1['id']?>"><?=$v1['name']?></option>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="size<?=$v['id']?>" id="size<?=$v['id']?>">
                                                        <option value="0">Chọn size</option>
                                                        <?php if(count($product_size)>0){ ?>
                                                        <?php foreach ($product_size as $k1 => $v1){ ?>
                                                        <option value="<?=$v1['id']?>"><?=$v1['name']?></option>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <?php } ?>
                                                <td><?=$func->moneyFormat($v['price'])?></td>
                                                <td>
                                                    <a class="btn btn-success-soft btn-sm add-click" data-id="<?=$v['id']?>" data-qty="1"><i class="typcn typcn-plus-outline"></i></a>
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
            </div>
        </div>
    </form>
</div>