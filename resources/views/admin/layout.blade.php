<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Админпанель</title>
    <link href="/css/front.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <![endif]-->

    <style>
        html, body{
            height: 100%;
        }
    </style>

    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>

<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <h5>
                            <a href="#"><i class="fa fa-edit"></i> Админпанель</a>
                        </h5>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="/"><i class="fa fa-sign-out"></i>На сайт</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->
</header>


<section class="main">
    @yield('content')
</section>

<footer id="footer" class="page-footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2015</p>
                <p class="pull-right">Курс PHP Start</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->



<script src="/js/front.js"></script>

</body>
</html>