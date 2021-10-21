<?php 
    $csetting = $setting['branchs'][$_GET['type']];
?>
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.html?com=branchs&act=man<?=$url_type?>">Danh sách</a></li>
            <li class="breadcrumb-item active"><?=$csetting['name']?></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Danh mục <?=$csetting['name']?> cấp 1</h1>
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
                            <a class="btn btn-danger w-100p ml-1 deleteChoose" href="index.html?com=branchs&act=delete<?=$url_type?>" role="button">Xóa chọn</a>
                            <a class="btn btn-success w-100p ml-1" href="index.html?com=branchs&act=add<?=$url_type?>" role="button">Thêm mới</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table <?php if($config['paging-table']==true){ ?>v table-borderless no-styling basic<?php }else{ ?>display table-striped table-hover table-border<?php } ?>">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <div class="check-table<?=($config['paging-table']==true) ? '':' auto'?>">
                                            <input id="checkAll" type="checkbox" class="checkboxAll">
                                            <label for="checkAll" class="pl-0"></label>
                                        </div>
                                    </th>
                                    <th width="70">#</th>
                                    <?php if($csetting['img']==true){ ?>
                                    <th width="70">Hình</th>
                                    <?php } ?>
                                    <th>Tiêu đề</th>
                                    <?php if(!empty($csetting['status'])){ ?>
                                    <?php foreach($csetting['status'] as $k=>$v){ ?>
                                    <th width="70"><?=$v?></th>
                                    <?php } ?>
                                    <?php } ?>
                                    <th width="73">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($items)) { foreach ($items as $k => $v) { ?>
                                <tr>
                                    <td>
                                        <div class="check-table<?=($config['paging-table']==true) ? '':' auto'?>">
                                            <input id="checkbox<?=$v['id']?>" name="chon" class="checker" type="checkbox" value="<?=$v['id']?>">
                                            <label for="checkbox<?=$v['id']?>" class="pl-0"></label>
                                        </div>
                                    </td>
                                    <td width="70">
                                        <input type="text" class="form-control form-control-sm text-center update-numb" data-id="<?=$v['id']?>" data-table="<?=$_GET['com']?>" value="<?=$v['numb']?>">
                                    </td>
                                    <?php if($csetting['img']==true){ ?>
                                    <td><img src="<?=$path.$v['photo']?>" width="30" onerror="this.src='assets/dist/img/icon-no-image.svg';"></td>
                                    <?php } ?>
                                    <td><?=$v['name_vi']?></td>
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
                                        <a href="index.html?com=branchs&act=edit<?=$url_type?>&id=<?=$v['id']?>" class="btn btn-success-soft btn-sm mr-1"><i class="typcn typcn-eye-outline"></i></a>
                                        <a href="index.html?com=branchs&act=delete<?=$url_type?>&id=<?=$v['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" class="btn btn-danger-soft btn-sm"><i class="typcn typcn-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($config['paging-table']==false){ ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <nav aria-label="Page navigation example">
                                <?=$paging?>
                            </nav>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div><!--/.body content-->