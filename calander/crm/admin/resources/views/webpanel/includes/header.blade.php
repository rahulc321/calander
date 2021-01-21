<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <meta name="google-site-verification" content="e2fKaPoAB5VNvJpGM3nzlX7K1rCtAK42PnzLYMxt57s" />
    <title>@yield('title')</title>

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext"
          rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/londinium-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @yield('styles')

    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/autosize.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/inputlimit.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/listbox.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/multiselect.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/tags.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/switch.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/wysihtml5/wysihtml5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/forms/wysihtml5/toolbar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/interface/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/interface/fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/interface/moment.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/interface/jgrowl.min.js') }}"></script>
    <script src="{{ asset('assets/js/filestyle/bootstrap-filestyle.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/application.js') }}"></script>

    <?php
    if (isset($jsData) && !empty($jsData)) {
        event('js.transform', array($jsData));
    }
    ?>
</head>
<body>

<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="{{ asset('assets/images/innerlogo.png') }}" alt="Moretti CRM"></a>
        <a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
            <span class="sr-only">Toggle navbar</span>
            <i class="icon-grid3"></i>
        </button>
        <button type="button" class="navbar-toggle offcanvas">
            <span class="sr-only">Toggle navigation</span>
            <i class="icon-paragraph-justify2"></i>
        </button>
    </div>

    <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
        <li class="dropdown">

            @if(session(\App\Modules\Orders\Order::SESSION_KEY))
                <a class="dropdown-toggle cart-btn-header" href="{{ sysUrl('orders/cart/xl') }}">
                    <i class="icon-cart-checkout"></i>
                    @if(\App\Modules\Orders\Order::Current())
                        <span class="label label-default">({{ \App\Modules\Orders\Order::Current()->items()->count('id') }})</span>
                    @endif
                </a>
            @endif
        </li>

        <li class="user dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('assets/images/profile.png') }}">
                <span> {{ Auth::user()->full_name }}</span>
                <i class="caret"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right icons-right">
                <li><a href="{{ url('webpanel/my/profile') }}"><i class="icon-user"></i> Profile</a></li>
                <li><a href="{{ url('webpanel/my/password') }}"><i class="icon-cog"></i> Change Password</a></li>
                <li><a href="<?php echo URL::to('auth/logout'); ?>"><i class="icon-exit"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</div>

