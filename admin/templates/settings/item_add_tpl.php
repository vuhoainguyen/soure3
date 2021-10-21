<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item active">Cấu hình</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Thông tin cấu hình</h1>
                <small>Hệ thống quản trị nội dung website</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)--> 
<div class="body-content">
    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
        <?=$func->messageSeoPage($item['title_'.$k],$item['description_'.$k],$k)?>
    <?php } ?> 
    <?=$func->messagePage($_GET['message'])?>
    <form action="index.html?com=settings&act=save" method="post" name="update-settings" id="update-settings" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
		<?php if (count($config['website']['lang'])>1){ ?>
        <div class="row ngonngu-sticky">
            <div class="col-lg-12">
                <div class="card mb-4 ">
                    <div class="card-body">
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
        <?php } ?>

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
                            <div class="col-md-4 ">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Công ty [<?=$v?>]</label>
                                    <input type="text" class="form-control" value="<?=$item['company_'.$k]?>" name="data[company_<?=$k?>]" placeholder="Công ty">
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Address [<?=$v?>]</label>
                                    <input type="text" class="form-control" value="<?=$item['address_'.$k]?>" name="data[address_<?=$k?>]" placeholder="Địa chỉ">
                                </div>
                                <?php } ?>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Mã số thuế</label>
                                    <input type="text" class="form-control" value="<?=$item['tax_code']?>" name="data[tax_code]" placeholder="Mã số thuế">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Email</label>
                                    <input type="text" class="form-control" value="<?=$item['email']?>" name="data[email]" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Điện thoại</label>
                                    <input type="text" class="form-control" value="<?=$item['phone']?>" name="data[phone]" placeholder="Điện thoại">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Hotline</label>
                                    <input type="text" class="form-control" value="<?=$item['hotline']?>" name="data[hotline]" placeholder="Hotline">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Website</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="website-link"><?=$http?></span>
                                        </div>
                                         <input type="text" class="form-control" value="<?=$item['website']?>" name="data[website]" aria-describedby="website-link" placeholder="Website">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group mb-0 lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Slogan chào mừng [<?=$v?>]</label>
                                    <input type="text" class="form-control" value="<?=$item['slogan_'.$k]?>" name="data[slogan_<?=$k?>]" placeholder="Content bottom chính">
                                </div>
                                <?php } ?>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Thời gian làm việc</label>
                                    <input type="text" class="form-control" value="<?=$item['time_work']?>" name="data[time_work]" placeholder="Thời gian làm việc">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

                       

                        
        <?php if($config['bill-print']==true){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin trên hóa đơn giá trị gia tăng</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="text-danger">Width: 200px - Height: 150px</p>
                                </div>
                                <div class="form-group">
                                    <input type="file" name="favicon" id="favicon" class="custom-input-file"/>
                                    <label for="favicon">
                                        <i class="typcn typcn-upload"></i>
                                        <span><?=($item['favicon']!='') ? $path.$item['favicon']:'Choose a file…'?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <img src="<?=_upload_photo.$item['favicon']?>" width="50">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Ngân hàng</label>
                                    <input type="text" class="form-control" value="<?=$item['blank']?>" name="data[blank]" placeholder="Thông tin ngân hàng trên hóa đơn giá trị gia tăng">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Mẫu số</label>
                                    <input type="text" class="form-control" value="<?=$item['denominator']?>" name="data[denominator]" placeholder="Mẫu hóa đơn số">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Ký hiệu</label>
                                    <input type="text" class="form-control" value="<?=$item['symbol']?>" name="data[symbol]" placeholder="Ký hiệu hóa đơn">
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
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin bản đồ</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Tọa độ</label>
                                    <input type="text" class="form-control" value="<?=$item['map_marker']?>" name="data[map_marker]" placeholder="10.822252, 106.631395">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link bản đồ</label>
                                    <input type="text" class="form-control" value="<?=$item['map_link']?>" name="data[map_link]" placeholder="https://www.google.com/maps/dir/......">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group mb-0">
                                    <label class="font-weight-600">Nhúng bản đồ</label>
                                    <textarea rows="4" cols="80" class="form-control" name="data[map_frame]"  placeholder="<iframe src='https://www.google.com/maps/embed....'></iframe>"><?=$item['map_frame']?></textarea>
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
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin phân trang</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 pr-md-1">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Số item trang chủ</label>
                                    <input type="text" class="form-control" value="<?=$item['page_index']?>" name="data[page_index]" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Số item trang sản phẩm</label>
                                    <input type="text" class="form-control" value="<?=$item['page_product']?>" name="data[page_product]" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Số item trang bài viết</label>
                                    <input type="text" class="form-control" value="<?=$item['page_acticles']?>" name="data[page_acticles]" placeholder="0">
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
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin chèn code</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label class="font-weight-600">Chèn code header</label>
                                    <textarea rows="10" cols="80" class="form-control" name="data[html_head]"><?=$item['html_head']?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group mb-0">
                                    <label class="font-weight-600">Chèn code footer</label>
                                    <textarea rows="10" cols="80" class="form-control" name="data[html_body]"><?=$item['html_body']?></textarea>
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
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin Seo</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <label class="font-weight-600">Title [<?=$v?>]</label>
                                    <input type="text" class="form-control" value="<?=$item['title_'.$k]?>" onkeyup="changeSeo('title_<?=$k?>','title_seo_<?=$k?>','name_<?=$k?>'),countChar('title_<?=$k?>')" id="title_<?=$k?>" data-min="10" data-max="70" name="data[title_<?=$k?>]" placeholder="Tiêu đề">
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
                                    <textarea rows="4" cols="80" class="form-control" onkeyup="changeSeo('description_<?=$k?>','description_seo_<?=$k?>','null'),countChar('description_<?=$k?>')" name="data[description_<?=$k?>]" id="description_<?=$k?>" data-min="160" data-max="300" placeholder="Nhập Description SEO"><?=$item['description_'.$k]?></textarea>
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
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Hiển thị trên google search</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="form-group mb-0 lang_hidden lang_<?=$k?> <?= ($k == 'vi') ? 'active': '' ?>">
                                    <p class="url_seo"><?=$config_base?><span id="url_seo_<?=$k?>"></span></p>
                                    <h3 class="title_seo" id="title_seo_<?=$k?>"><?=($item['title_'.$k]!='') ? $item['title_'.$k]:'[SEO Onpage] là gì? Hướng dẫn tối ưu SEO Onpage ...'?></h3>
                                    <p class="description_seo" id="description_seo_<?=$k?>"><?=($item['description_'.$k]!='') ? $item['description_'.$k]:'Hướng dẫn SEO onpage căn bản tối ưu để trang web chuẩn SEO lên top Google nhanh và bền vững, kỹ thuật tối ưu SEO onpage đơn giản'?></p>
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
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Thông tin social</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link fanpage</label>
                                    <input type="text" class="form-control" value="<?=$item['fanpage']?>" name="data[fanpage]" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Mã ứng dụng facebook [appId]</label>
                                    <input type="text" class="form-control" value="<?=$item['facebook_id']?>" name="data[facebook_id]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Số zalo</label>
                                    <input type="text" class="form-control" value="<?=$item['zalo']?>" name="data[zalo]" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Mã ứng dụng zalo [oaid]</label>
                                    <input type="text" class="form-control" value="<?=$item['zalo_id']?>" name="data[zalo_id]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link pinterest</label>
                                    <input type="text" class="form-control" value="<?=$item['pinterest']?>" name="data[pinterest]" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link linkedin</label>
                                    <input type="text" class="form-control" value="<?=$item['linkedin']?>" name="data[linkedin]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link instagram</label>
                                    <input type="text" class="form-control" value="<?=$item['instagram']?>" name="data[instagram]" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link youtube</label>
                                    <input type="text" class="form-control" value="<?=$item['youtube']?>" name="data[youtube]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group m-0">
                                    <label class="font-weight-600">Link twitter</label>
                                    <input type="text" class="form-control" value="<?=$item['twitter']?>" name="data[twitter]" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Link messenger</label>
                                    <input type="text" class="form-control" value="<?=$item['messenger']?>" name="data[messenger]" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="edit-setting" value="1">
                        <button type="submit" class="btn btn-fill btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>