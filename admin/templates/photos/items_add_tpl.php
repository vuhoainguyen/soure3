<?php 
    $csetting = $setting['photos'][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=photos&act=update<?=$url_type?>">Cập nhật <?=$csetting['name']?></a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Cập nhật <?=$csetting['name']?></h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?=$func->messagePage($_GET['message'])?>
    <form action="index.html?com=photos&act=update<?=$url_type?>" method="post" name="form-action" id="form-action"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
        <?php if (count($config['website']['lang'])>1){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav-ngonngu">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                    <li class="mr-3">
                                        <a href="<?=$k?>" class="<?= ($k == 'vi') ? 'active': '' ?> tipS">
                                            <img src="assets/dist/img/<?=$k?>.svg"> <?=$v?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
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
                        <?php if($_GET['act']=='update' && $item['photo']!=''){ ?>
                        <div class="row hinhanh">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="delete-img">
                                        <img src="<?=$path.$item['photo']?>" width="<?=$setting[$_GET['com']][$_GET['type']]['thumb-w']?>" style="max-width: 100%;">
                                        <span class="deleteImg" data-table="<?=$_GET['com']?>" data-path="<?=$path?>" data-id="<?=$item['id']?>"><i class="typcn typcn-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="text-danger">Width: <?=$setting[$_GET['com']][$_GET['type']]['thumb-w']?>px - Height: <?=$setting[$_GET['com']][$_GET['type']]['thumb-h']?>px</p>
                                </div>
                                <div class="form-group">
                                    <input type="file" name="photo" id="photo" class="custom-input-file"/>
                                    <label for="photo">
                                        <i class="typcn typcn-upload"></i>
                                        <span><?=($item['photo']!='') ? $path.$item['photo']:'Choose a file…'?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
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
                        <?php if($csetting['link']==true){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Link</label>
                                    <input type="text" class="form-control" value="<?=$item['link']?>" id="link" name="data[link]" placeholder="Chèn link website">
                                </div>
                            </div>
                       </div>
                        <?php } ?>
                       <div class="row">
                            <div class="col-md-12">
                                <div class="form-group skin-square">
                                    <div class="i-check">
                                        <input tabindex="5" type="checkbox" value="hienthi" <?=($item['status']=='hienthi') ? 'checked':''?> name="data[status]" id="status">
                                        <label for="status">Hiển thị</label>
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
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='update') ? 'Cập nhật':'Thêm mới'?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>