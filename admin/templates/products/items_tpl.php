<?php 
    $csetting = $setting[$_GET['com']][$_GET['type']];
?>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.html?com=products&act=man<?=$url_type?>">Danh sách</a></li>
            <li class="breadcrumb-item active"><?=$csetting['name']?></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Danh mục <?=$csetting['name']?></h1>
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
                            <a class="btn btn-danger w-100p ml-1 deleteChoose" href="index.html?com=products&act=delete<?=$url_type?>" role="button">Xóa chọn</a>
                            <a class="btn btn-success w-100p ml-1" href="index.html?com=products&act=add<?=$url_type?>" role="button">Thêm mới</a>
                            <?php if($config['other']['quick-add-products']==true){ ?>
                            <div class="btn-group ml-1">
                                <button type="button" class="btn btn-primary w-100p dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Thao tác
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="md-trigger dropdown-item" href="#" data-modal="modal-6">Import <?=$csetting['name']?></a>
                                    <a class="md-export dropdown-item" href="index.html?com=products&act=export<?=$url_type?>">Export <?=$csetting['name']?></a>
                                    <a class="md-trigger dropdown-item" href="#" data-modal="modal-7">Upload hình <?=$csetting['name']?></a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                    <form action="index.html" method="get" name="form-product" id="form-product" accept-charset="utf-8">
                        <input type="hidden" name="com" value="products">
                        <input type="hidden" name="act" value="man">
                        <input type="hidden" name="type" value="<?=$_GET['type']?>">
                        <?php if($csetting['dropdown']==true) { ?>
                        <div class="row">
                            <?php if($csetting['list']==true) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Danh mục cấp 1</label>
                                    <select class="form-control basic-single" name="id_list" id="id_list" onChange="window.location.href='index.html?com=<?=$_GET['com']?>&act=man&type=<?=$_GET['type']?>&id_list='+this.value">
                                        <option value="0">Chọn danh mục cấp 1</option>
                                        <?php for($i=0;$i<count($items_list);$i++){ ?>
                                        <option value="<?=$items_list[$i]['id']?>" <?=($_GET['id_list']==$items_list[$i]['id']) ? 'selected':''?>><?=$items_list[$i]['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($csetting['cat']==true) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Danh mục cấp 2</label>
                                    <select class="form-control basic-single" name="id_cat" id="id_cat" onChange="window.location.href='index.html?com=<?=$_GET['com']?>&act=man&type=<?=$_GET['type']?>&id_list=<?=$_GET['id_list']?>&id_cat='+this.value">
                                        <option value="0">Chọn danh mục cấp 2</option>
                                        <?php for($i=0;$i<count($items_cat);$i++){ ?>
                                        <option value="<?=$items_cat[$i]['id']?>" <?=($_GET['id_cat']==$items_cat[$i]['id']) ? 'selected':''?>><?=$items_cat[$i]['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($csetting['item']==true) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Danh mục cấp 3</label>
                                    <select class="form-control basic-single" name="id_item" id="id_item" onChange="window.location.href='index.html?com=<?=$_GET['com']?>&act=man&type=<?=$_GET['type']?>&id_list=<?=$_GET['id_list']?>&id_cat=<?=$_GET['id_cat']?>&id_item='+this.value">
                                        <option value="0">Chọn danh mục cấp 3</option>
                                        <?php for($i=0;$i<count($items_item);$i++){ ?>
                                        <option value="<?=$items_item[$i]['id']?>" <?=($_GET['id_item']==$items_item[$i]['id']) ? 'selected':''?>><?=$items_item[$i]['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($csetting['sub']==true) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Danh mục cấp 4</label>
                                    <select class="form-control basic-single" name="id_sub" id="id_sub" onChange="window.location.href='index.html?com=<?=$_GET['com']?>&act=man&type=<?=$_GET['type']?>&id_list=<?=$_GET['id_list']?>&id_cat=<?=$_GET['id_cat']?>&id_item=<?=$_GET['id_item']?>&id_sub='+this.value">
                                        <option value="0">Chọn danh mục cấp 4</option>
                                        <?php for($i=0;$i<count($items_sub);$i++){ ?>
                                        <option value="<?=$items_sub[$i]['id']?>" <?=($_GET['id_item']==$items_sub[$i]['id']) ? 'selected':''?>><?=$items_sub[$i]['name_vi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="font-weight-600">Từ khóa</label>
                                    <input class="form-control" type="text" name="keyword" value="<?=(isset($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']):''?>" placeholder="Nhập từ khóa...." data-toggle="tooltip" data-placement="top" title="Nhập mã sản phẩm, tên sản phẩm" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="font-weight-600">-------</label>
                                    <button type="submit" class="btn btn-fill btn-primary w-100">Thống kê / tìm kiếm</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    
                    <div class="table-responsive">
                        <table class="table <?php if($config['paging-table']==true){ ?>v table-borderless no-styling basic<?php }else{ ?>display table-striped table-hover table-border<?php } ?>">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <div class="check-table<?=($config['paging-table']==true) ? '':' auto'?>" >
                                            <input id="checkAll" type="checkbox" class="checkboxAll">
                                            <label for="checkAll" class="pl-0"></label>
                                        </div>
                                    </th>
                                    <th width="70">#</th>
                                    <?php if($csetting['photo']==true) { ?><th width="70">Hình</th><?php } ?>
                                    <th style="max-width: 200px;">Tiêu đề</th>
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
                                        <input type="text" class="form-control form-control-sm text-center update-numb" data-id="<?=$v['id']?>" data-table="<?=$_GET['com']?>" value="<?=$v['numb']?>" style="width: 50px;">
                                    </td>
                                    <?php if($csetting['photo']==true) { ?><td><img src="<?=$path.$v['thumb']?>" width="50" onerror="this.src='assets/dist/img/icon-no-image.svg';"></td><?php } ?>
                                    <td style="max-width: 300px;">
                                        <p class="name-px">
                                            <?=$v['name_vi']?> 
                                        </p>
                                        <p class="post-px">
                                            <a  data-toggle="tooltip" data-placement="top" title="Xem chi tiết trình bày" href="<?=$config_base.$v['alias_vi']?>" target="_blank">View</a>
                                             | <a  data-toggle="tooltip" data-placement="top" title="Sửa sản phẩm" href="index.html?com=products&act=edit<?=$url_type?>&id=<?=$v['id']?>">Edit</a> | 
                                            <a data-toggle="tooltip" data-placement="top" title="Nhân bản sản phẩm" href="index.html?com=products&act=copy<?=$url_type?>&id_product=<?=$v['id']?>" target="_blank">Copy</a>
                                            <?php if($csetting['color']){ ?> | 
                                            <a href="index.html?com=product_properties&act=man&id_product=<?=$v['id']?>&type=color" data-toggle="tooltip" data-placement="top" title="Thuộc tính màu">Add color</a><?php } ?>
                                            <?php if($csetting['size']){ ?> | 
                                            <a href="index.html?com=product_properties&act=man&id_product=<?=$v['id']?>&type=size" data-toggle="tooltip" data-placement="top" title="Thuộc tính size">Add size</a><?php } ?>

                                        </p>
                                    </td>
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
                                        <?php if($csetting['article']){ ?>
                                        <a href="index.html?com=product_posts&act=man<?=$url_type?>&id_product=<?=$v['id']?>" class="btn btn-primary-soft btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="Thêm bài viết"><i class="typcn typcn-book"></i></a>
                                         <?php } ?>
                                        <a href="index.html?com=products&act=edit<?=$url_type?>&id=<?=$v['id']?>" class="btn btn-success-soft btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="Sửa sản phẩm"><i class="typcn typcn-eye-outline"></i></a>
                                        <a href="index.html?com=products&act=delete<?=$url_type?>&id=<?=$v['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" class="btn btn-danger-soft btn-sm" data-toggle="tooltip" data-placement="top" title="Xóa sản phẩm"><i class="typcn typcn-trash"></i></a>
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
<?php if($config['other']['quick-add-products']==true){ ?>
<div class="md-modal md-effect-7" id="modal-6">
    <div class="md-content">
        <h4 class="font-weight-600 mb-0">Import </h4>
        <div class="n-modal-body">
            <form action="index.html?com=products&act=import" method="post" enctype="multipart/form-data"  id="import_file" name="import_file" accept-charset="utf-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Vui lòng <a href="ajax/download_file.php?file=<?=base64_encode('../assets/excel/file-import-product-samples.xlsx')?>" title="">download file</a> này để thực hiện bước này</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" name="photo" id="photo" class="custom-input-file"/>
                            <label for="photo">
                                <i class="typcn typcn-upload"></i>
                                <span>Choose a file…</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="type" value="<?=$_GET['type']?>">
                    <button type="submit" class="btn btn-success w-100p">Cập nhật</button>
                    <button type="button" class="btn btn-danger w-100p ml-2 md-close">Thoát</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="md-modal md-effect-7" id="modal-7">
    <div class="md-content">
        <h4 class="font-weight-600 mb-0">Upload hình ảnh </h4>
        <div class="n-modal-body">
            <form action="index.html?com=products&act=extract_zip<?=$url_type?>" method="post" enctype="multipart/form-data" id="zip_file" name="zip_file" accept-charset="utf-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Vui lòng chọn file <a href="" title="">.zip</a> để thực hiện bước này. Lưu ý tên của file và đuôi file hình phải trùng khớp với dữ liệu đã nhập trong file excel.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" name="file_zip" id="file_zip" class="custom-input-file"/>
                            <label for="file_zip">
                                <i class="typcn typcn-upload"></i>
                                <span>Choose a file…</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="type" value="<?=$_GET['type']?>">
                    <button type="submit" class="btn btn-success w-100p">Giải nén</button>
                    <button type="button" class="btn btn-danger w-100p ml-2 md-close">Thoát</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="md-overlay"></div>
<?php } ?>