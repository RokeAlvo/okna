<!DOCTYPE html>
<html lang="ru">
<head>
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

    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>

    @if(app('env') === 'production')
        @include('templates.analytics')
    @endif

    @yield('head-scripts')

</head>
<body>

<div class="stick-phone">
    <i class="fa fa-phone stick-phone-button" aria-hidden="true"></i>
    <div class="stick-phone-value">
        <p>Отдел продаж:</p>{{ SITE_CONTACTS['phone'] }}
    </div>
</div>
@if(url()->current() == route('site.index'))
    <div class="main-bg">
        @include('templates.topMenu')
        <div class="container main-block-content-middle">
            <div class="top-text-wrapper">
                <h1>Проверенные новостройки Новосибирска</h1>
                <p>Найди свою идеальную квартиру</p>

                <div class="top-search">
                    <div class="decor">
                        <a class="btn btn-lg btn-round btn-yellow btn-custom-lg btn-shadow" href="{{ route('residentials.index') }}">Найти прямо
                            сейчас</a>
                    </div>
                </div>
                <div class="scroll floating"></div>
            </div>
        </div>
    </div>
@elseif(str_contains(url()->current(), url('residential-complex/')))

@else
    <div class="top-page-block">
        <div class="page-bg">
            @include('templates.topMenu')
        </div>
    </div>
@endif

    <div class="content">
        @include('templates.messages')
        @yield('content')
    </div>

<div id="global-modal" class="modal fade in" tabindex="-1" role="dialog">
    <div class="global-modal-content"></div>
</div>

@include('templates.footer')

<script>
    var mql = window.matchMedia('only screen and (min-width: 991px)'),
        handleMQL = function (mql) {
            if (mql.matches) {
                $('.panel-collapse').addClass("in").removeAttr('style');
                $('.label-collapse').removeClass("collapsed");
            } else {
                $('.panel-collapse').removeClass("in").removeAttr('style');
                $('.label-collapse').addClass("collapsed");
            }
        };
    mql.addListener(handleMQL);
    handleMQL(mql);
</script>

<script type="text/javascript">
    $(".stick-phone-button").click(function () {
        $(".stick-phone-value").toggleClass("stick-phone-active");
    });
</script>

@yield('footer-scripts')
</body>
</html>