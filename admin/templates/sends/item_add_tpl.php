<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=sends&act=man<?=$url_type?>">Thông tin</a></li>
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
    <form action="index.html?com=sends&act=save<?=$url_type?><?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-profile" id="form-profile"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin email</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-2 col-form-label text-right">Subject :</label>
                                    <div class="col-sm-9 col-md-10">
                                        <input class="form-control" type="text" value="<?=$item['subject']?>" name="subject" id="subject">
                                    </div>
                                </div>
                                <?php 
                                    if($item['lists_mail']){
                                        $js_mail = json_decode($item['lists_mail'],true);
                                    }
                                ?>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-2 col-form-label text-right">Email đã gửi :</label>
                                    <div class="col-sm-9 col-md-10">
                                        <select name="lists_mail" class="form-control basic-multiple" multiple="multiple">
                                            <?php for($i=0;$i<count($js_mail);$i++){ ?>
                                            <option value="<?=$js_mail[$i]?>" selected><?=$js_mail[$i]?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php 

                                    if($item['files_attach']){
                                        $js_attach = json_decode($item['files_attach'],true);
                                    }

                                ?>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-md-2 col-form-label text-right">File hiện tại :</label>
                                    <div class="col-sm-9 col-md-10">
                                        <div class="row">
                                            <?php for($i=0;$i<count($js_attach);$i++){ ?>
                                            <div class="col-sm-3 col-md-1">
                                                <a href="<?=$js_attach[$i]?>"  data-toggle="tooltip" data-placement="bottom" title="<?=$js_attach[$i]?>" target="_blank">
                                                    <div class="files">
                                                        <i class="typcn typcn-news"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- summernote -->
                                <textarea id="summernote" name="summernote"><?=$item['contents']?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a role="button" href="index.html?com=sends&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>