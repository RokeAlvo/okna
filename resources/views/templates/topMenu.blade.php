<div class="container">
    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle navbar-toggle-collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-brand">
            <a href="{{ url(getUrlPathFirstPart() . '/') }}"><img src="{{ url('/img/top-logo.png') }}" alt="{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }}"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
            <div class="top-menu-contacts-info">
                <div class="top-menu-working-hours">
                    <i class="fa fa-clock-o"></i> ПН - ПТ с 9:00 до 18:00
                </div>
                <div class="top-menu-phone header-main-phone">
                    <i class="fa fa-mobile"></i>
                    {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{ route('developers.index') }}">Застройщики</a></li>
                <li><a href="{{ route('residentials.spa') }}">Новостройки</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('ipoteka.spa') }}">Ипотека</a></li>
                <li><a href="{{ route('requests.contacts') }}">Контакты</a></li>
            </ul>
        </div>
    </nav>
</div>