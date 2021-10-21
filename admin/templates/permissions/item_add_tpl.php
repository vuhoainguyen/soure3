<?php 
    $csetting = $setting['posts'][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=permissions&act=man">Danh mục <?=$csetting['name']?></a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
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
    <form action="index.html?com=permissions&act=save<?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-action" id="form-action"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
        <div class="row ngonngu-sticky">
            <div class="col-lg-12">
                <div class="card mb-4 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-right mb-0">
                                    <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></button>
                                    <a role="button" href="index.html?com=permissions&act=man" class="btn btn-fill btn-danger">Thoát</a>
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
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="font-weight-600">Tên quyền</label>
                                        <input type="text" class="form-control" value="<?=$item['name']?>" data-validation="required" data-validation-error-msg="Tiêu đề không được để trống" id="name" name="data[name]" placeholder="Tiêu đề">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="font-weight-600">Màu phân biệt</label>
                                        <input type="color" class="form-control" value="<?=$item['colors_name']?>" id="colors_name" name="data[colors_name]" placeholder="Màu phân biệt">
                                    </div>
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
                                <h6 class="fs-17 font-weight-600 mb-0">Danh sách quyền</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php 
                            if($_GET['act']=='edit'){
                                $role_list = json_decode($item['role_list'],true);
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php for($i=0;$i<count($permission_attr);$i++){ ?>
                                <div class="form-group mb-3 row align-items-center">
                                    <label class="col-md-3 mb-0 font-weight-600"><?=$permission_attr[$i]['name']?>: </label>
                                    <div class="col-md-9">
                                        <div style="width: 100%; display: flex; justify-content: flex-start; flex-wrap: wrap;">
                                            <?php foreach ($permission_attr[$i]['act'] as $k => $v) { $vx = $permission_attr[$i]['com'].'|'.$permission_attr[$i]['type'].'|'.$k;?>
                                            <div class="form-group mb-0 skin-square ml-3">
                                                <div class="i-check">
                                                    <input tabindex="5" <?=(empty($role_list)) ? '':(in_array($vx,$role_list)) ? 'checked':''?> type="checkbox" value="<?=$vx?>" name="role[]" id="<?=$permission_attr[$i]['com'].$i.$k.$type?>">
                                                    <label for="<?=$permission_attr[$i]['com'].$i.$k.$type?>"><?=$v?></label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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
                        <a role="button" href="index.html?com=permissions&act=man" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>