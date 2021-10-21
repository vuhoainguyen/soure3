<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=product_properties&act=man<?=$url_type?>">Danh sách</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Danh sách thuộc tính</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?=$func->messagePage($_GET['message'])?>
    <form action="index.html?com=product_properties&act=save<?=$url_type?><?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-action" id="form-action"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
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
                                    <a role="button" href="index.html?com=product_properties&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                                    <a role="button" href="index.html?com=products&act=man&type=<?=$csetting['type-key']?>" class="btn btn-fill btn-success">Về sản phẩm</a>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                    <div class="form-group lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                        <label class="font-weight-600">Tiêu đề [<?=$v?>]</label>
                                        <input type="text" class="form-control" value="<?=$item['name_'.$k]?>" data-validation="required" data-validation-error-msg="Tiêu đề không được để trống" id="name_<?=$k?>" name="data[name_<?=$k?>]" placeholder="Tiêu đề">
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if($csetting['color']==true){ ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Màu</label>
                                    <input type="color" class="form-control" value="<?=$item['colors']?>" id="colors" name="data[colors]" placeholder="Mã màu">
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($csetting['price']==true){ ?>
                            <div class="col-md-4 pl-md-1 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Giá bán</label>
                                    <input type="text" class="form-control money-form" value="<?=$item['price']?>" id="price" name="data[price]" placeholder="Giá bán sản phẩm">
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($csetting['qty']==true){ ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Số lượng</label>
                                    <input type="text" class="form-control" value="<?=$item['qty']?>" id="qty" name="data[qty]" placeholder="Số lượng sản phẩm">
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($csetting['photo']==true) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Ảnh đại diện</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if($_GET['act']=='edit' && $item['photo']!=''){ ?>
                        <div class="row hinhanh">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="delete-img">
                                        <img src="<?=$path.$item['photo']?>" width="250">
                                        <span class="deleteImg" data-table="<?=$_GET['com']?>" data-path="<?=$path?>" data-id="<?=$item['id']?>"><i class="typcn typcn-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="text-danger">Width: <?=$csetting['thumb-w']?>px - Height: <?=$csetting['thumb-w']?>px</p>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="file" name="photo" id="photo" class="custom-input-file"/>
                                    <label for="photo">
                                        <i class="typcn typcn-upload"></i>
                                        <span><?=($item['photo']!='') ? $path.$item['photo']:'Choose a file…'?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($csetting['multi-img']==true){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Ảnh thêm</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="text-danger">Width: <?=$csetting['thumb-wm']?>px - Height: <?=$csetting['thumb-wm']?>px</p>
                                </div>
                                <div class="form-group">
                                    <input type="file" id="files" name="files[]" value="" placeholder="">
                                </div>
                            </div>
                        </div>
                        <?php if($_GET['act']=='edit'){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="fileuploader-items">
                                        <ul class="fileuploader-items-list">
                                            <?php for($i=0;$i<count($items_photo);$i++){ ?>
                                            <li class="fileuploader-item file-has-popup file-type-image file-ext-jpg imgMulti">
                                                <div class="columns">
                                                    <div class="column-thumbnail">
                                                        <div class="fileuploader-item-image">
                                                            <img src="<?=$path.$items_photo[$i]['photo']?>" width="36" height="36">
                                                        </div>
                                                    </div>
                                                    <div class="column-title" style="line-height: 36px;">
                                                        <div title="<?=$path.$items_photo[$i]['photo']?>"><?=$path.$items_photo[$i]['photo']?></div>
                                                    </div>
                                                    <div class="column-actions">
                                                        <a class="fileuploader-action fileuploader-action-remove deleteImgMulti" data-table="product_photo_properties" data-path="<?=$path?>" data-id="<?=$items_photo[$i]['id']?>" title="Xóa"><i></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></button>
                        <a role="button" href="index.html?com=product_properties&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>