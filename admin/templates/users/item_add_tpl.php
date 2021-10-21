<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active"><a href="index.html?com=users&act=man">Account</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Thành viên quản trị</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?=$func->messagePage($_GET['message'])?>
    <form action="index.html?com=users&act=save<?=($_GET['id']) ? '&id='.$_GET['id']:''?>" method="post" name="form-profile" id="form-profile"  enctype="multipart/form-data" autocomplete="off" accept-charset="utf-8">
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
                                    <input type="text" class="form-control" value="<?=$item['username']?>" data-validation="required" data-validation-error-msg="Username không được để trống" name="data[username]" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Mật khẩu mới</label>
                                    <input type="password" <?=($_GET['act']=='add') ? ' data-validation="required" data-validation-error-msg="Mật khẩu không được để trống"':''?> class="form-control" value="" autocomplete="new-password" name="data[password]">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">First Name</label>
                                    <input type="text" class="form-control" value="<?=$item['first_name']?>" name="data[first_name]" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Last Name</label>
                                    <input type="text" class="form-control" value="<?=$item['last_name']?>" name="data[last_name]" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Phone</label>
                                    <input type="text" class="form-control" value="<?=$item['phone']?>" data-validation="required" data-validation-error-msg="Điện thoại không được để trống" name="data[phone]" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Email address</label>
                                    <input type="email" class="form-control" data-validation="required" data-validation-error-msg="Email không được để trống" value="<?=$item['email']?>" name="data[email]" placeholder="mike@email.com">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Address</label>
                                    <input type="text" class="form-control" value="<?=$item['address']?>" name="data[address]" placeholder="Home Address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-0 row align-items-center">
                                    <label class="col-md-2 mb-0 font-weight-600">Chọn quyền: </label>
                                    <div class="col-md-10">
                                        <div style="width: 100%; display: flex; justify-content: flex-start; flex-wrap: wrap;">
                                            <?php foreach ($permissions as $k => $v) { ?>
                                            <div class="form-group mb-0 skin-square ml-3">
                                                <div class="i-check">
                                                    <input tabindex="5" <?=($item['id_permission']==$v['id']) ? 'checked':''?> type="radio" value="<?=$v['id']?>" name="data[id_permission]" id="permission<?=$v['id']?>">
                                                    <label for="permission<?=$v['id']?>" style="color: <?=$v['colors_name']?>"><?=$v['name']?></label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary"><?=($_GET['act']=='edit') ? 'Cập nhật':'Thêm mới'?></button>
                        <a role="button" href="index.html?com=users&act=man" class="btn btn-fill btn-danger">Thoát</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>