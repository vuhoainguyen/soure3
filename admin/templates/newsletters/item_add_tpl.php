<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=newsletters&act=man<?=$url_type?>">Account</a></li>
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
    <form action="index.html?com=newsletters&act=save<?=$url_type?><?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-profile" id="form-profile"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
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
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Email address</label>
                                    <input type="email" class="form-control" data-validation="email" data-validation-error-msg="Email không hợp lệ" value="<?=$item['email']?>" name="data[email]" placeholder="mike@email.com">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Phone</label>
                                    <input type="text" class="form-control" value="<?=$item['phone']?>" data-validation="required number" data-validation-error-msg="Điện thoại không được để trống" name="data[phone]"  data-validation-error-msg-number="Điện thoại phải là số" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Nội dung</label>
                                    <textarea class="form-control" rows="10" name="data[content]"><?=$item['content']?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Fullname</label>
                                    <input type="text" class="form-control" value="<?=$item['fullname']?>" name="data[fullname]" placeholder="Full Name">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Address</label>
                                    <input type="text" class="form-control" value="<?=$item['address']?>" name="data[address]" placeholder="Home Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></button>
                        <a role="button" href="index.html?com=newsletters&act=man<?=$url_type?>" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>