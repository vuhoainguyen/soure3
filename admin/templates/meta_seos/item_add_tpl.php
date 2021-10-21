<?php 
    $csetting = $setting[$_GET['com']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=meta_seos&act=man">Danh sách meta seo</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Danh sách meta seo</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?php if($_GET['act']=='edit'){ ?>
    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
        <?=$func->messageSeoPage($item['title_'.$k],$item['description_'.$k],$k)?>
    <?php } ?> 
    <?php } ?>
    <?=$func->messagePage($_GET['message'])?>
    <form action="index.html?com=meta_seos&act=save<?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-action" id="form-action"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
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
                                    <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Lưu mới'?></button>
                                    <a role="button" href="index.html?com=meta_seos&act=man" class="btn btn-fill btn-danger">Thoát</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php if($csetting['img']==true){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Ảnh đại diện danh mục</h6>
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
                                    <p class="text-danger">Width: <?=$csetting['thumb-w']?>px - Height: <?=$csetting['thumb-h']?>px</p>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin Seo</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if($config['meta-seo-debug']==true){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Type</label>
                                    <input type="text" class="form-control" value="<?=$item['type']?>" id="type" data-min="10" data-max="70" name="data[type]" placeholder="Nhập type">
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Title [<?=$v?>]</label>
                                    <input type="text" class="form-control" value="<?=$item['title_'.$k]?>" onkeyup="countChar('title_<?=$k?>')" id="title_<?=$k?>" data-min="10" data-max="70" name="data[title_<?=$k?>]" placeholder="Tiêu đề">
                                    <p class="mt-2">Số ký tự [10-70]: 
                                        <span class="text-danger" id="count_title_<?=$k?>"><?=mb_strlen($item['title_'.$k])?></span>
                                        <span class="<?=(mb_strlen($item['title_'.$k])<10 || mb_strlen($item['title_'.$k])>70) ? 'text-danger':'text-success'?>" id="status_title_<?=$k?>"><?=(mb_strlen($item['title_'.$k])<10 || mb_strlen($item['title_'.$k])>70) ? 'Không tốt':'Khá tốt'?></span>
                                    </p>
                                    
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Keywords [<?=$v?>]</label>
                                    <textarea rows="4" cols="80" class="form-control" name="data[keywords_<?=$k?>]" id="keywords_<?=$k?>"  placeholder="Nhập Keywords SEO"><?=$item['keywords_'.$k]?></textarea>
                                    <p class="mt-2 text-danger">
                                        Meta keywords là những từ hoặc cụm từ liên quan đến nội dung trang web của bạn. Trước đây, mọi người đã cố gắng tận dụng thẻ này để bây giờ nó không ảnh hưởng đến thứ hạng tìm kiếm của bạn như trước đây.
                                    </p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group mb-0 lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Description [<?=$v?>]</label>
                                    <textarea rows="4" cols="80" class="form-control" onkeyup="countChar('description_<?=$k?>')" name="data[description_<?=$k?>]" id="description_<?=$k?>" data-min="160" data-max="300" placeholder="Nhập Description SEO"><?=$item['description_'.$k]?></textarea>
                                    <p class="mt-2">Số ký tự [160-300]:
                                        <span class="text-danger" id="count_description_<?=$k?>"><?=mb_strlen($item['description_'.$k])?></span>
                                        <span class="<?=(mb_strlen($item['description_'.$k])<160 || mb_strlen($item['description_'.$k])>300) ? 'text-danger':'text-success'?>" id="status_description_<?=$k?>"><?=(mb_strlen($item['description_'.$k])<160 || mb_strlen($item['description_'.$k])>300) ? 'Không tốt':'Khá tốt'?></span>
                                    </p>
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
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Lưu mới'?></button>
                        <a role="button" href="index.html?com=meta_seos&act=man" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>