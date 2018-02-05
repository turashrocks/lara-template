<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7"><![endif]-->
<!--[if IE 8]><html class="ie ie8"><![endif]-->
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <!-- Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pattaya|Roboto:400,500,700|Noto+Sans:400,700&amp;subset=vietnamese">
        <!-- CSS Library-->

        {!! Theme::header() !!}

        <!--HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
        <!--WARNING: Respond.js doesn't work if you view the page via file://-->
        <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <!--[if IE 7]><body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->
    <!--[if IE 8]><body class="ie8 lt-ie9 lt-ie10"><![endif]-->
    <!--[if IE 9]><body class="ie9 lt-ie10"><![endif]-->
    <body>
    <header data-sticky="false" data-sticky-checkpoint="200" data-responsive="991" class="page-header page-header--light">
        <div class="container">
            <!-- LOGO-->
            <div class="page-header__left"><a href="{{ url('/') }}" class="page-logo">
                    @if (!theme_option('logo'))
                        <span>Jinan</span>Rides
                    @else
                        <img src="{{ url(theme_option('logo')) }}" alt="{{ setting('site_title') }}" height="50">
                    @endif
                </a></div>
            <div class="page-header__left">
                <!-- MOBILE MENU-->
                <div class="navigation-toggle navigation-toggle--dark"><span></span></div>
                <div class="pull-left">
                    <!-- SEARCH-->
                    <!-- NAVIGATION-->
                    <nav class="navigation navigation--light navigation--fade navigation--fadeLeft">
                        {!!
                            Menu::generateMenu([
                                'slug' => 'main-menu',
                                'options' => ['class' => 'menu sub-menu--slideLeft'],
                                'view' => 'main-menu'
                            ])
                        !!}
                    </nav>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="page-header__right">
                <div class="pull-left">
                    <div class="pull-right">
                        <div class="language-wrapper">
                            {!! apply_filters('language_switcher') !!}
                        </div>
                    </div>
                </div>
                <ul class="pull-left">
                    @if (Auth::guard('member')->check())
                        <li><a href="{{ route('public.member.overview') }}"><i class="fa fa-user"></i> <span>{{ Auth::guard('member')->user()->name }}</span></a></li>
                        <li><a href="{{ route('public.member.logout') }}"><i class="fa fa-sign-out"></i> {{ __('Logout') }}</a></li>
                    @else
                        <li><a href="{{ route('public.member.login') }}"><i class="fa fa-sign-in"></i> {{ __('Login') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="super-search hide">
            <form class="quick-search" action="{{ route('public.search') }}">
                <input type="text" name="q" placeholder="{{ __('Type to search...') }}" class="form-control search-input" autocomplete="off">
                <span class="close-search">&times;</span>
            </form>
            <div class="search-result"></div>
        </div>
    </header>
    <div id="page-wrap">

