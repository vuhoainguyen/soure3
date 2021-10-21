<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=coupons&act=man<?=$url_type?>">Danh sách</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Danh sách mã giảm giá</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?=$func->messagePage($_GET['message'])?>
    <form action="index.html?com=coupons&act=save<?=$url_type?><?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-action" id="form-action"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
        <div class="row ngonngu-sticky">
            <div class="col-lg-12">
                <div class="card mb-4 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <?php if (count($config['website']['lang'])>1){ ?>
                                <ul class="nav-ngonngu">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                    <li class="mr-3">
                                        <a href="<?=$k?>" class="<?= ($k == 'vi') ? 'active': '' ?> tipS">
                                            <img src="assets/dist/img/<?=$k?>.svg"> <?=$v?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-right mb-0">
                                    <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></button>
                                    <a role="button" href="index.html?com=coupons&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                                </div>
                            </div>
                        </div>
                        
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
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin chung</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Mã giảm giá</label>
                                    <input type="text" class="form-control" value="<?=($_GET['act']=='add') ? $func->randCoupon(6):$item['code']?>" id="code" name="data[code]" placeholder="Mã giảm giá">
                                </div>
                            </div>
                            <div class="col-md-4 pl-md-1 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Giá từ [ <span style="color: #ff0000">>=</span> giá trị ]</label>
                                    <input type="text" class="form-control money-form" value="<?=$item['price_start']?>" id="price_start" name="data[price_start]" placeholder="Giá từ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Giá đến [ <span style="color: #ff0000"><</span> giá trị ] </label>
                                    <input type="text" class="form-control money-form" value="<?=$item['price_end']?>" id="price_end" name="data[price_end]" placeholder="Giá đến">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Phần trăm giảm</label>
                                    <input type="text" class="form-control" value="<?=$item['percents']?>" id="percents" name="data[percents]" placeholder="Phần trăm giảm giá">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Số lượng</label>
                                    <input type="text" class="form-control" value="<?=$item['qty']?>" id="qty" name="data[qty]" placeholder="Số lượng mã">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Ngày bắt đầu</label>
                                    <input type="text" class="form-control single-date start-date" value="<?=($_GET['act']=='add') ? date('d/m/Y',time()):date('d/m/Y',$item['start_date'])?>" id="start_date" name="data[start_date]" placeholder="Ngày bắt đầu">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Ngày kết thúc</label>
                                    <input type="text" class="form-control single-date end-date" data-time="<?=($_GET['act']=='add') ? date('d/m/Y',time()+86400*30):date('d/m/Y',$item['end_date'])?>" value="<?=date('d/m/Y',$item['end_date'])?>" id="end_date" name="data[end_date]" placeholder="Ngày kết thúc">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></button>
                        <a role="button" href="index.html?com=coupons&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>