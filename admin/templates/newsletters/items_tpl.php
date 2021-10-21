<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.html?com=newsletters&act=man<?=$url_type?>">Danh sách</a></li>
            <li class="breadcrumb-item active">Thành viên</li>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Danh sách</h6>
                        </div>
                        <div>
                            <a class="btn btn-danger w-100p ml-1 deleteChoose" href="index.html?com=newsletters&act=delete<?=$url_type?>" role="button">Xóa chọn</a>
                            <a class="btn btn-success w-100p ml-1" href="index.html?com=newsletters&act=add<?=$url_type?>" role="button">Thêm mới</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                                    <th>#</th>
                                    <th>Email</th>
                                    <!-- <th>Họ tên</th> -->
                                    <th>Điện thoại</th>
                                    <?php if(!empty($csetting['status'])){ ?>
                                    <?php foreach($csetting['status'] as $k=>$v){ ?>
                                    <th width="70"><?=$v?></th>
                                    <?php } ?>
                                    <?php } ?>
                                    <th width="73">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $k => $v) { ?>
                                <tr>
                                    <td>
                                        <div class="check-table">
                                            <input id="checkbox<?=$v['id']?>" name="chon" class="checker" type="checkbox" value="<?=$v['id']?>">
                                            <label for="checkbox<?=$v['id']?>" class="pl-0"></label>
                                        </div>
                                    </td>
                                    <td width="70">
                                        <input type="text" class="form-control form-control-sm text-center update-numb" data-id="<?=$v['id']?>" data-table="<?=$_GET['com']?>" value="<?=$v['numb']?>">
                                    </td>
                                    <td><?=$v['email']?></td>
                                    <!-- <td><?=$v['fullname']?></td> -->
                                    <td><?=$v['phone']?></td>
                                    <?php if(!empty($csetting['status'])){ $arr_status = explode(',',$v['status']);?>
                                    <?php foreach($csetting['status'] as $k1=>$v1){ ?>
                                    <td>
                                        <div class="check-table<?=($config['paging-table']==true) ? '':' auto'?>">
                                            <input id="checkbox-status-<?=$k1?><?=$v['id']?>" class="checker-status" type="checkbox" data-table="<?=$_GET['com']?>" data-field="status" name="status<?=$v['id']?>[]" data-id="<?=$v['id']?>" value="<?=$k1?>" <?=(in_array($k1,$arr_status)) ? 'checked':''?> data-com="<?=$_GET['com']?>" data-types="<?=$_GET['type']?>" data-act="status">
                                            <label for="checkbox-status-<?=$k1?><?=$v['id']?>" class="pl-0"></label>
                                        </div>
                                    </td>
                                    <?php } ?>
                                    <?php } ?>
                                    <td>
                                        <a href="index.html?com=newsletters&act=edit<?=$url_type?>&id=<?=$v['id']?>" class="btn btn-success-soft btn-sm mr-1"><i class="typcn typcn-eye-outline"></i></a>
                                        <a href="index.html?com=newsletters&act=delete<?=$url_type?>&id=<?=$v['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" class="btn btn-danger-soft btn-sm"><i class="typcn typcn-trash"></i></a>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Soạn thư</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="index.html?com=newsletters&act=send<?=$url_type?>" method="post" name="form-newsletter" id="form-newsletter"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
                        <input type="hidden" name="type" value="<?=$_GET['type']?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label text-right">Subject :</label>
                                <div class="col-sm-9 col-md-10">
                                    <input class="form-control" type="text" name="subject" id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label text-right">File đính kèm :</label>
                                <div class="col-sm-9 col-md-10">
                                    <input class="form-control" name="file[]" type="file" id="file" multiple>
                                </div>
                            </div>
                            <!-- summernote -->
                            <textarea id="summernote" name="summernote"></textarea>
                            <div class="mt-3">
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-success btn-send">SEND</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div><!--/.body content-->