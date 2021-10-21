<?php 
    error_reporting(0);
?>
<html>
<head>
    <title>Thông báo chuyển trang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="REFRESH" content="3; url=<?=$page_transfer?>">
    <script src="../js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script>WebFontConfig = { google: { families: ['Open Sans:400,500,600,700,800,900'] },timeout: 300 }; (function(d) { var wf = d.createElement('script'), s = d.scripts[0]; wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'; wf.async = true; s.parentNode.insertBefore(wf, s); })(document); </script>
    <style type="text/css" media="screen">
    body {
        font-family: 'Open Sans', 'Arial', cursive;
        font-weight: 400;
        overflow-x: hidden;
        font-size: 14px;
        background: #F6F5F5;
        font-size: 15px;
    }
    .text-center{
        text-align: center;
    }
    .redirect-link {
        max-width: 650px;
        margin: 30px auto;
        background: #FFF;
        box-shadow: 0px 0px 10px #e5e5e5;
        padding: 30px;
    }

    .redirect-link .logo {
        width: 100%;
    }

    .redirect-link .logo img {
        max-height: 150px;
    }

    .redirect-link .header {
        padding: 10px 0px;
    }
    .redirect-link .header h3 {
        font-size: 18px;
        font-weight: 700;
        line-height: 24px;
        text-transform: uppercase;
    }
    .redirect-link .header h5 {
        font-size: 15px;
        font-weight: 700;
        line-height: 24px;
    }

    .redirect-link .header h5 span {
        color: var(--color-key)
    }

    .redirect-link .header p {
        margin-top: 10px;
    }

    .redirect-link .header p a {
        display: inline-block;
        padding: 8px 20px;
        background: #212121;
        color: #FFF;
        font-size: 15px;
        text-decoration: none;
    }

    .spinner {
        width: 100%;
        margin: 30px 0px;
        text-align: center;
    }

    .mul15 {
        height: 14px;
        width: 144px;
        margin: 0 auto;
    }

    .m15c {
        height: 14px;
        width: 14px;
        margin: 0 2px;
        border-radius: 50%;
        float: left;
        background-color: #F4D03F;
    }

    .m15c1,
    .m15c2,
    .m15c3,
    .m15c4,
    .m15c5,
    .m15c6,
    .m15c7,
    .m15c8 {
        -webkit-animation: m15anim 2s infinite ease-in-out;
        animation: m15anim 2s infinite ease-in-out;
    }

    .m15c2 {
        -webkit-animation-delay: .25s;
        animation-delay: .25s
    }

    .m15c3 {
        -webkit-animation-delay: .5s;
        animation-delay: .5s
    }

    .m15c4 {
        -webkit-animation-delay: .75s;
        animation-delay: .75s
    }

    .m15c5 {
        -webkit-animation-delay: 1s;
        animation-delay: 1s
    }

    .m15c6 {
        -webkit-animation-delay: 1.25s;
        animation-delay: 1.25s
    }

    .m15c7 {
        -webkit-animation-delay: 1.5s;
        animation-delay: 1.5s
    }

    .m15c8 {
        -webkit-animation-delay: 1.75s;
        animation-delay: 1.75s
    }

    @-webkit-keyframes m15anim {
        0%,
        40%,
        100% {
            background-color: #F4D03F;
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }

        20% {
            background-color: #C0392B;
            -webkit-transform: translateY(-12px);
            transform: translateY(-12px);
        }

    }

    @keyframes m15anim {
        0%,
        40%,
        100% {
            background-color: #F4D03F;
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }

        20% {
            background-color: #C0392B;
            -webkit-transform: translateY(-12px);
            transform: translateY(-12px);
        }

    }

    </style>
</head>

<body>
    <div class="redirect-link">
        <div class="header text-center">
            <h3>Chuyển hướng trang</h3>
            <h5><?=$showtext?></h5>
            <p>Bạn đang được chuyển tới trang đích trong vòng <span class="time-redirect">3</span> giây nữa</p>
            <div class="spinner">
                <div class="mul15">
                    <div class="m15c m15c1"></div>
                    <div class="m15c m15c2"></div>
                    <div class="m15c m15c3"></div>
                    <div class="m15c m15c4"></div>
                    <div class="m15c m15c5"></div>
                    <div class="m15c m15c6"></div>
                    <div class="m15c m15c7"></div>
                    <div class="m15c m15c8"></div>
                </div>
            </div>
            <p><a href="<?=$page_transfer?>" title="Chuyển hướng nhanh tới trang đích">Chuyển hướng nhanh tới trang đích <i class="fa fa-angle-right"></i></a></p>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var _od = 3;
            setInterval(function(){
                $('.time-redirect').html(_od);
                _od--;
            },1000);
        });
    </script>
</body>
</html>