<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Account</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Thông tin tài khoản</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?php if(count($result)){ ?>
    <div class="row">
         <div class="col-lg-12">
            <div class="alert alert-<?=($result['status']==200) ? 'success':'danger'?> alert-dismissible fade show" role="alert">
                <strong><?=($result['status']==200) ? 'Success!':'Fails!'?></strong> <?=$result['message']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </div>
    <?php } ?>
    <form action="index.html?com=users&act=profile" method="post" name="update-profile" id="update-profile" autocomplete="off"  enctype="multipart/form-data" accept-charset="utf-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin cá nhân</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Username</label>
                                    <input type="text" class="form-control" value="<?=$item['username']?>" readonly name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Email address</label>
                                    <input type="email" class="form-control" value="<?=$item['email']?>" name="data[email]" placeholder="mike@email.com">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">First Name</label>
                                    <input type="text" class="form-control" value="<?=$item['first_name']?>" name="data[first_name]" placeholder="Company">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group ">
                                    <label class="font-weight-600">Last Name</label>
                                    <input type="text" class="form-control" value="<?=$item['last_name']?>" name="data[last_name]" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Address</label>
                                    <input type="text" class="form-control" value="<?=$item['address']?>" name="data[address]" placeholder="Home Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="edit-profile" value="1">
                        <button type="submit" class="btn btn-fill btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="index.html?com=users&act=profile" method="post" name="update-password" id="update-password" autocomplete="off"  enctype="multipart/form-data" accept-charset="utf-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thay đổi mật khẩu</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 pr-md-1">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Mật khẩu cũ</label>
                                    <input type="password" data-validation="required" data-validation-error-msg="Mật khẩu cũ không được để trống" class="form-control" autocomplete="new-password" name="password-old">
                                </div>
                            </div>
                            <div class="col-md-4 pr-md-1">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Mật khẩu mới</label>
                                    <input type="password" data-validation="required" data-validation-error-msg="Mật khẩu mới không được để trống" class="form-control" autocomplete="new-password" name="data[password]">
                                </div>
                            </div>
                            <div class="col-md-4 pr-md-1">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Xác nhận mật khẩu</label>
                                    <input type="password" data-validation="required" data-validation-error-msg="Mật khẩu xác nhận không được để trống" class="form-control" autocomplete="new-password" name="password-confirm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="edit-password" value="1">
                        <button type="submit" class="btn btn-fill btn-primary">Thay đổi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>