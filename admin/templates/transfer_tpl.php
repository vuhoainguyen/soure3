<html>
<head>
    <title>Thông báo chuyển trang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="REFRESH" content="3; url=<?=$page_transfer?>">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <style type="text/css" media="screen">
    body {
        background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);
    }

    .page-center {
        max-width: 600px;
        background: rgba(0, 0, 0, 0.1);
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 30px;
        font-family: 'Arial';
        margin: 100px auto;
    }

    div.noidung {
        width: 100%;
        text-align: center;
    }

    .noidung p.noidung {
        color: #FFF;
        font-size: 15px;
    }

    .noidung p.click_here a {
        color: #FF0;
        font-size: 15px;
    }

    .load-pre {
        position: relative;
        height: 70px;
    }

    .loader {
        margin: 0 auto;
        width: 60px;
        height: 50px;
        text-align: center;
        font-size: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translateY(-50%) translateX(-50%);
    }

    .loader>div {
        height: 100%;
        width: 8px;
        display: inline-block;
        float: left;
        margin-left: 2px;
        -webkit-animation: delay 0.8s infinite ease-in-out;
        animation: delay 0.8s infinite ease-in-out;
    }

    .loader .bar1 {
        background-color: #754fa0;
    }

    .loader .bar2 {
        background-color: #09b7bf;
        -webkit-animation-delay: -0.7s;
        animation-delay: -0.7s;
    }

    .loader .bar3 {
        background-color: #90d36b;
        -webkit-animation-delay: -0.6s;
        animation-delay: -0.6s;
    }

    .loader .bar4 {
        background-color: #f2d40d;
        -webkit-animation-delay: -0.5s;
        animation-delay: -0.5s;
    }

    .loader .bar5 {
        background-color: #fcb12b;
        -webkit-animation-delay: -0.4s;
        animation-delay: -0.4s;
    }

    .loader .bar6 {
        background-color: #ed1b72;
        -webkit-animation-delay: -0.3s;
        animation-delay: -0.3s;
    }

    @-webkit-keyframes delay {

        0%,
        40%,
        100% {
            -webkit-transform: scaleY(0.05);
        }

        20% {
            -webkit-transform: scaleY(1);
        }

    }

    @keyframes delay {

        0%,
        40%,
        100% {
            transform: scaleY(0.05);
            -webkit-transform: scaleY(0.05);
        }

        20% {
            transform: scaleY(1);
            -webkit-transform: scaleY(1);
        }

    }
    </style>
</head>

<body>
    <div class="page-center">
        <div class="load-pre">
            <div class="loader">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                <div class="bar4"></div>
                <div class="bar5"></div>
                <div class="bar6"></div>
            </div>
        </div>

        <div class="noidung">
            <p class="noidung">
                <?=$showtext?>
            </p>
            <p>-----------------------------------------</p>
            <p class="click_here">
                <a href="<?=$page_transfer?>">(Click vào đây nếu bạn không muốn đợi lâu)</a>
            </p>
        </div>
    </div>
</body>

</html>