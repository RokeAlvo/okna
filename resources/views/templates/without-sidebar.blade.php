<!DOCTYPE html>
<html lang="ru">
<head>
    @include('templates.google-tag-manager-head')
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta http-equiv="Cache-Control" content="no-cache">
    <link rel="apple-touch-icon" sizes="57x57" href="{{url('/img/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{url('/img/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('/img/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/img/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url('/img/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('/img/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('/img/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/img/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/img/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{url('/img/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('/img/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/img/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{url('/img/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <link href="{{ url('/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ url('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/fonts.css') }}" rel="stylesheet">
    {{--<link href="{{ url('/css/non-responsive.css') }}" rel="stylesheet">--}}
    <link href="{{ url('/css/template.css') }}" rel="stylesheet">
    <link href="{{ url('/css/style.css') }}" rel="stylesheet">

    @yield('styles')

    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>

    @if(app('env') === 'production')
    @include('templates.analytics')
    @endif

    @yield('head-scripts')

</head>
<body>
@include('templates.google-tag-manager-body')
<div class="content">
    @yield('content')
</div>
@yield('footer-scripts')
</body>
</html>