<?php 
    $contacts_lists = $d->rawQuery("SELECT * from #_contacts where type=? and view=? order by id desc",array("contact",0));
    $orders_lists = $d->rawQuery("SELECT * from #_orders where view=0 order by id desc");
?>
<nav class="navbar-custom-menu navbar navbar-expand-lg m-0 <?=($_GET['com']=='orders' && $_GET['act']=='add') ? 'active':''?>">
    <div class="sidebar-toggle-icon <?=($_GET['com']=='orders' && $_GET['act']=='add') ? 'open':''?>" id="sidebarCollapse">
        sidebar toggle<span></span>
    </div><!--/.sidebar toggle icon-->
    <div class="d-flex flex-grow-1">
        <ul class="navbar-nav flex-row align-items-center ml-auto">
            
            <li class="nav-item">
                <a class="nav-link" href="../" target="_blank">
                    <i class="typcn typcn-arrow-back"></i>
                </a>
            </li><!--/.dropdown-->
            <li class="nav-item">
                <a class="nav-link" href="index.html?com=settings&act=update">
                    <i class="typcn typcn-cog-outline"></i>
                </a>
            </li>
            <?php if($config['cart']['check']==true){ ?>
            <li class="nav-item dropdown cart">
                <a class="nav-link dropdown-toggle <?php if(count($orders_lists)>0){ ?>badge-dot<?php } ?>" href="#" data-toggle="dropdown">
                    <i class="typcn typcn-shopping-cart"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <h6 class="cart-title">Đơn hàng</h6>
                    <p class="cart-text">Bạn có <?=count($orders_lists)?> đơn hàng mới đặt</p>
                    <div class="cart-list">
                        <?php if(count($orders_lists)>0){ foreach ($orders_lists as $k => $v) { ?>
                        <div class="media new">
                            <div class="media-body" onclick="window.location.href='index.html?com=orders&act=man&type=don-hang#order-<?=$v['code']?>'">
                                <h6>Đơn hàng <strong><?=$v['code']?></strong> vừa đặt</h6>
                                <span><?=$v['createdAt']?></span>
                            </div>
                        </div><!--/.media -->
                        <?php } } ?>
                    </div><!--/.cart -->
                    <div class="dropdown-footer"><a href="#">Xem tất cả đơn hàng</a></div>
                </div><!--/.dropdown-menu -->
            </li><!--/.dropdown-->
            <?php } ?>
            <li class="nav-item dropdown notification">
                <a class="nav-link dropdown-toggle <?php if(count($contacts_lists)>0){ ?>badge-dot<?php } ?>" href="#" data-toggle="dropdown">
                    <i class="typcn typcn-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <h6 class="notification-title">Thông tin liên hệ</h6>
                    <p class="notification-text">Bạn có <?=count($contacts_lists)?> liên hệ chưa đọc</p>
                    <div class="notification-list">
                        <?php if(count($contacts_lists)>0){ foreach ($contacts_lists as $k => $v) { ?>
                        <div class="media new">
                            <div class="media-body" onclick="window.location.href='index.html?com=contacts&act=edit&type=contact&id=<?=$v['id']?>'">
                                <h6><?=$v['subject']?></h6>
                                <span><?=$v['createdAt']?></span>
                            </div>
                        </div><!--/.media -->
                        <?php } } ?>
                    </div><!--/.notification -->
                    <div class="dropdown-footer"><a href="index.html?com=contacts&act=man&type=contact">Xem tất cả liên hệ</a></div>
                </div><!--/.dropdown-menu -->
            </li><!--/.dropdown-->
            <li class="nav-item dropdown user-menu">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                    <i class="typcn typcn-user-add-outline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" >
                    <div class="dropdown-header d-sm-none">
                        <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <a href="index.html?com=users&act=profile" class="dropdown-item"><i class="typcn typcn-edit"></i> Thông tin tài khoản</a>
                    <?php if($config['other']['permission']==true){ ?>
                    <a href="index.html?com=users&act=man" class="dropdown-item"><i class="typcn typcn-user-outline"></i> Danh sách tài khoản</a>
                    <?php } ?>
                    <a href="index.html?com=settings&act=update" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Cấu hình website</a>
                    <a href="index.html?com=users&act=logout" class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign Out</a>
                </div><!--/.dropdown-menu -->
            </li>

        </ul><!--/.navbar nav-->
        <div class="nav-clock">
            <div class="time">
                <span class="time-hours"></span>
                <span class="time-min"></span>
                <span class="time-sec"></span>
            </div>
        </div><!-- nav-clock -->
    </div>
</nav><!--/.navbar-->