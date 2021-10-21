  <?php 
    if(isset($_SESSION[$login_name]) || $_SESSION[$login_name]==true){
        $id_user = (int)$_SESSION['login']['id'];
        $timenow = time();
        //Thoát tất cả khi đổi user, mật khẩu hoặc quá thời gian 1 tiếng không hoạt động
        $sql="select username,password,lastlogin,user_token from #_users WHERE id ='$id_user'";
        $row = $d->rawQueryOne($sql);
        $cookiehash = md5(sha1($row['password'].$row['username']));
        if($_SESSION['login_session']!=''){
            if( $_SESSION['login_session']!=$cookiehash || ($timenow - $row['lastlogin'])>3600 ) {
                // unset($_SESSION['login_session']);
                // unset($_SESSION['login_token']);
                session_destroy();  
                $func->redirect("index.html?com=users&act=login");
            }
            if($_SESSION['login_token']!==$row['user_token']){
                $notice_admin = 'Có người đang đăng nhập tài khoản của bạn!';
            }else{
                $notice_admin ='';
            }
            $token = md5(time());
            $_SESSION['login_token'] = $token;
            //Cập nhật lại thời gian hoạt động và token
            $sql = "update #_users set lastlogin = '$timenow', user_token = '$token' where id='$id_user'";
            $d->rawQuery($sql);
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="<?=$config_base?>admin/assets/dist/img/logo_BMWEB.png" type="image/x-icon" />
        <meta name="description" content="BMWEB FRAMEWORK">
        <meta name="author" content="Bdtask">
        <title>Bmweb Deshboard</title>
        <meta name="keywords" id="secret-keyword" content="<?=base64_encode($setting['secret'])?>" />
        <!-- App favicon -->
        <!--Global Styles(used by all pages)-->
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/typicons/src/typicons.min.css" rel="stylesheet">
        <link href="assets/plugins/confirm/jquery-confirm.min.css" rel="stylesheet">
        <link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet">
        <link href="assets/plugins/themify-icons/themify-icons.min.css" rel="stylesheet">
        <link href="assets/plugins/glyphicons/glyphicons.css" rel="stylesheet">
        <link href="assets/dist/css/font-fileuploader.css" rel="stylesheet">
        <link href="assets/dist/css/jquery.fileuploader.min.css" rel="stylesheet">
        <link href="assets/dist/css/jquery.fileuploader-theme-dragdrop.css" rel="stylesheet">
        <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="assets/plugins/icheck/skins/all.css" rel="stylesheet">
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="assets/plugins/summernote/summernote.css" rel="stylesheet">
        <link href="assets/plugins/summernote/summernote-bs4.css" rel="stylesheet">
        <link href="assets/plugins/modals/component.css" rel="stylesheet">
        <link href="assets/plugins/jquery.sumoselect/sumoselect.min.css" rel="stylesheet">
        <!--Start Your Custom Style Now-->
        <link href="assets/dist/css/style.css?v=<?=$config['version']?>" rel="stylesheet">
        <link href="assets/dist/css/style_themes.css?v=<?=$config['version']?>" rel="stylesheet">
    </head>
    <?php $themes_page = array('theme-green','theme-green-dark','theme-violet','theme-orange','theme-blue','theme-red','theme-blue-dark'); ?>
    <body class="theme-<?=$setting_themes['theme_admin']?>">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        
        <!-- #END# Page Loader -->
        <?php if(isset($_SESSION[$login_name]) && $_SESSION[$login_name]==true){ ?>
        <div class="wrapper">
            <!-- Sidebar  -->
            <?php require_once _layouts."sidebar.php"; ?>
            <!-- Page Content  -->
            <div class="content-wrapper">
                <div class="main-content">
                    <?php require_once _layouts."header.php"; ?>
                    <?php require_once _templates.$templates."_tpl.php"; ?>
                    <!--/.body content-->
                </div><!--/.main content-->
                <footer class="footer-content">
                    <div class="footer-text d-flex align-items-center justify-content-between">
                        <div class="copy">© 2019 Dashboard Bmweb Template</div>
                        <div class="credit">Designed by: <a href="//bmweb.vn" target="_blank">Bmweb co.ltd</a></div>
                    </div>
                </footer><!--/.footer content-->
                <div class="overlay"></div>
            </div><!--/.wrapper-->
        </div>

        

        <!--Global script(used by all pages)-->
        <script src="assets/plugins/jQuery/jquery-3.4.1.min.js"></script>
        <script src="assets/dist/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/metisMenu/metisMenu.min.js"></script>
        <script src="assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <!-- Third Party Scripts(used by this page)-->
        <script src="assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="assets/plugins/validator/jquery.form-validator.min.js"></script>
        <script src="assets/plugins/confirm/jquery-confirm.min.js"></script>
        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="assets/dist/js/speakingurl.min.js"></script>
        <script src="assets/plugins/ckeditor/ckeditor.js?v=<?=$config['version']?>"></script>
        <script src="assets/dist/js/jquery.price_format.js"></script>
        <!-- Third Party Scripts(used by this page)-->
        <script src="assets/plugins/summernote/summernote.min.js"></script>
        <script src="assets/plugins/summernote/summernote-bs4.min.js"></script>

        <script src="assets/plugins/modals/classie.js"></script>
        <script src="assets/plugins/modals/modalEffects.js"></script>
        
        <!--Page Active Scripts(used by this page)-->
        <script src="assets/dist/js/pages/dashboard.js"></script>
        <script src="assets/dist/js/pages/forms-basic.active.js"></script>
        <!--Page Scripts(used by all page)-->
        <script src="assets/dist/js/jquery.fileuploader.min.js"></script>
        <script src="assets/dist/js/sidebar.js"></script>
        <script src="assets/plugins/select2/dist/js/select2.min.js"></script>
        <script src="assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js"></script>
        <script src="assets/plugins/icheck/icheck.min.js"></script>
        <script src="assets/dist/js/pages/demo.select2.js"></script>
        <script src="assets/dist/js/pages/demo.jquery.sumoselect.js"></script>
        <div class="fixed-themes">
            <span class="click-cog">
                <i class="typcn typcn-cog"></i>
            </span>
            <ul class="color-themes-page">
                <li data-color="005c97" class="gradient-1"><span></span></li>
                <li data-color="fe8c00" class="gradient-2"><span></span></li>
                <li data-color="f953c6" class="gradient-3"><span></span></li>
                <li data-color="00b09b" class="gradient-4"><span></span></li>
                <li data-color="37a000" class="default"><span></span></li>
                <li data-color="128341" class="green"><span></span></li>
                <li data-color="4F0791" class="violet"><span></span></li>
                <li data-color="fd7d0c" class="orange"><span></span></li>
                <li data-color="05498D" class="blue"><span></span></li>
                <li data-color="015775" class="blue-dark"><span></span></li>
                <li data-color="4c8c03" class="green-dark"><span></span></li>
                <li data-color="dc3545" class="red"><span></span></li>
                
            </ul>
        </div>
        <script type="text/javascript">
            var _templates = '<?=$templates?>';
            var _com = "<?=$_GET['com']?>";
            var class_ = 'theme-default';
            var color_ = '37a000';
            var chart_order;
            var apexMixedChart;
            $(document).ready(function() {
                if(_templates=='index' || _com=='statitics'){
                    if(_com!='statitics'){
                        var options = {
                            colors: ['#37a000'],
                            chart: {
                                id: 'apexMixedChart',
                                height: 345,
                                type: 'line',
                                dropShadow: {
                                    enabled: true,
                                    color: '#000',
                                    top: 18,
                                    left: 7,
                                    blur: 10,
                                    opacity: 0.2
                                }
                            },
                            series: [{
                                    name: 'Thống kê truy cập tháng <?=$month?>',
                                    type: 'line',
                                    data: [<?php for($i = 0; $i < count($gth); $i++):?><?=$gth[$i]?><?php if($i<count($gth)-1){ ?>,<?php } ?><?php endfor; ?>]
                                }],
                            stroke: {
                              curve: 'smooth'
                            },
                            grid: {
                              borderColor: '#e7e7e7',
                              row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                              },
                            },
                            markers: {
                              size: 1
                            },
                            dataLabels: {
                              enabled: false
                            },
                            labels: [<?php for($i = 1; $i <= $daysInMonth; $i++):?>'D<?=$i?>'<?php if($i<$daysInMonth){ ?>,<?php } ?><?php endfor; ?>],
                            legend: {
                              position: 'top',
                              horizontalAlign: 'right',
                              floating: true,
                              offsetY: -25,
                              offsetX: -5
                            }
                        }
                        apexMixedChart = new ApexCharts( document.querySelector("#apexMixedChart"), options );
                        apexMixedChart.render();
                        color_ = localStorage.getItem('c');
                        if(null === color_){
                            apexMixedChart.updateOptions({
                                colors: ['#37a000']
                            });
                        }else{
                            apexMixedChart.updateOptions({
                                colors: ['#'+color_]
                            });
                        }
                        
                    }
                    var options_order = {
                        colors: ['#37a000'],
                        series: [{
                        data: [<?php for($i = 0; $i < count($items_product); $i++){ ?><?=$items_product[$i]['total']?><?php if($i<count($items_product)-1){ ?>,<?php } ?><?php } ?>]
                        }],
                        chart: {
                            id: 'chart_order',
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: [<?php for($i = 0; $i < count($items_product); $i++){ ?>"<?=$items_product[$i]['name']?>"<?php if($i<count($items_product)-1){ ?>,<?php } ?><?php } ?>],
                        },
                        tooltip: {
                          y: {
                            formatter: function (val) {
                              return 'Số lượng: '+val;
                            }
                          }
                        }
                    };
                    chart_order = new ApexCharts(document.querySelector("#chart_order"), options_order);
                    chart_order.render();
                    
                    if($("#chart_order").length > 0){
                        color_ = localStorage.getItem('c');
                        if(null === color_){
                            chart_order.updateOptions({
                                colors: ['#37a000']
                            });
                        }else{
                            chart_order.updateOptions({
                                colors: ['#'+color_]
                            });
                        }
                    }
                    


                    var options1 = {
                          series: [{
                          name: 'Doanh thu',
                          data: [<?php for($i = 0; $i < count($doanhthu); $i++):?><?=$doanhthu[$i]?><?php if($i<count($doanhthu)-1){ ?>,<?php } ?><?php endfor; ?>]
                        }],
                          chart: {
                            id: 'chart_revenue',
                          height: 350,
                          type: 'line',
                          dropShadow: {
                                enabled: true,
                                color: '#000',
                                top: 18,
                                left: 7,
                                blur: 10,
                                opacity: 0.2
                            }
                        },
                        stroke: {
                          width: 5,
                          curve: 'smooth'
                        },
                        xaxis: {
                          categories: [<?php for($i = 1; $i <= $daysInMonth; $i++):?>'D<?=$i?>'<?php if($i<$daysInMonth){ ?>,<?php } ?><?php endfor; ?>],
                        },
                        fill: {
                          type: 'gradient',
                          gradient: {
                            shade: 'dark',
                            gradientToColors: [ '#FDD835'],
                            shadeIntensity: 1,
                            type: 'horizontal',
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100, 100, 100]
                          },
                        },
                        markers: {
                          size: 4,
                          colors: ["#FFA41B"],
                          strokeColors: "#fff",
                          strokeWidth: 2,
                          hover: {
                            size: 7,
                          }
                        },
                        yaxis: {
                          min: 0,
                          show: false
                        },
                        tooltip: {
                          y: {
                            formatter: function (val) {
                              return parseFloat(val, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString() + 'đ';
                            }
                          }
                        }
                    };
                    chart_revenue = new ApexCharts(document.querySelector("#chart_revenue"), options1);
                    chart_revenue.render();

                    
                }
            }); 
        </script>
        <script src="assets/dist/js/custom.js?v=<?=$config['version']?>"></script>
        <?php }else{ ?>
        
        <?php require_once _templates.$templates."_tpl.php"; ?>
        
        <script src="assets/plugins/jQuery/jquery-3.4.1.min.js"></script>
        <script src="assets/dist/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/metisMenu/metisMenu.min.js"></script>
        <script src="assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="assets/plugins/validator/jquery.form-validator.min.js"></script>
        <!-- Third Party Scripts(used by this page)-->
        <script src="assets/dist/js/sidebar.js"></script>
        <script src="assets/dist/js/toast.js"></script>
        <script src="assets/dist/js/custom.js"></script>
        <?php } ?>
        <script src="assets/dist/js/toast.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/dist/css/toast.css">
        <?php if($notice_admin!='' && ($source=='index' || $act=='login')) { ?>
        <script type="text/javascript">
            window.load(function() {
                $.toast({
                    heading: '[2006] Thông báo tồn tại tài khoản đăng nhập',
                    text: '<?=$notice_admin?>',
                    position: 'top-right',
                    stack: false,
                    icon: 'error'
                });
            });
        </script>
        <?php } ?>
    </body>
</html>