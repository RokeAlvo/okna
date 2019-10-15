{{-- MOBILE --}} {{--
<div class="gradient-black-menu">
    <div class="m-all-menu-wrapper">
        <div class="m-all-menu">

            <input class="nav_check" type="checkbox" id="showmenu">
            <label class="nav_showmenu label-menu-m" for="showmenu">
                    <div class="burger-line-m first-m"></div>
                    <div class="burger-line-m second-m"></div>
                    <div class="burger-line-m third-m"></div>
                    <div class="burger-line-m fourth-m"></div>
                </label>
            <ul class="menu">
                <li><a class="menu_item" href="{{ route('developers.index') }}">Застройщики</a></li>
                <li><a class="menu_item" href="{{ route('residentials.spa') }}">Новостройки</a></li>
                <li><a class="menu_item" href="{{ route('ipoteka.spa') }}">Ипотека</a></li>
                <li><a class="menu_item none-border" href="{{ route('requests.contacts') }}">Контакты</a></li>
                <div class="menu-text-logo none-border-all"><a href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup class="logo-io">. io</sup></a></div>
                <input class="menu_check" type="checkbox" id="menu2">
                </li>
            </ul>
        </div>
        <div class="contact-phone-wrapper">
            <div class="phone-icon">
                <img src="/img/phone-icon.png">
            </div>
            <div class="wrapper-phone-top-menu">
                <div class="phone-text d-none d-md-block">телефон отдела продаж:</div>
                <div class="phone-text d-block d-md-none">Отдел продаж:</div>
                <div class="phone-number">{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</div>
            </div>
        </div>

        <script>
            $('.menu .menu_item').click(function () {
            $('input.nav_check').prop("checked", false);
        });
        </script>
    </div>
</div> --}} {{--
<div class="gradient-black-menu">
    <div class="m-all-menu-wrapper">
        <div class="m-all-menu">

            <input class="nav_check" type="checkbox" id="showmenu">
            <label class="nav_showmenu label-menu-m" for="showmenu">
                    <div class="burger-line-m first-m"></div>
                    <div class="burger-line-m second-m"></div>
                    <div class="burger-line-m third-m"></div>
                    <div class="burger-line-m fourth-m"></div>
                </label>
            <ul class="menu">
                <li><a class="menu_item" href="{{ route('developers.index') }}">Застройщики</a></li>
                <li><a class="menu_item" href="{{ route('residentials.spa') }}">Новостройки</a></li>
                <li><a class="menu_item" href="{{ route('ipoteka.spa') }}">Ипотека</a></li>
                <li><a class="menu_item none-border" href="{{ route('requests.contacts') }}">Контакты</a></li>
                <div class="menu-text-logo none-border-all"><a href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup class="logo-io">. io</sup></a></div>
                <input class="menu_check" type="checkbox" id="menu2">
                </li>
            </ul>
        </div>
        <div class="contact-phone-wrapper">
            <div class="phone-icon">
                <img src="/img/phone-icon.png">
            </div>
            <div class="phone-top-menu-mob">
                {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
            </div>
        </div>

        <script>
            $('.menu .menu_item').click(function () {
            $('input.nav_check').prop("checked", false);
        });
        </script>
    </div>
</div> --}} {{--
<div class="gradient-black-menu bag-mob-menu">

    <div class="burger-wrapper-mob">
        <input class="input-burger-menu" type="checkbox" id="showmenuall">
        <label class="label-burger-menu" for="showmenuall">
                <div class="burger-menu-line first-line"></div>
                <div class="burger-menu-line second-line"></div>
                <div class="burger-menu-line third-line"></div>
                <div class="burger-menu-line fourth-line"></div>
            </label>
        <ul class="menu-all">
            <li><a class="menu_item" href="{{ route('developers.index') }}">Застройщики</a></li>
            <li><a class="menu_item" href="{{ route('residentials.spa') }}">Новостройки</a></li>
            <li><a class="menu_item" href="{{ route('ipoteka.spa') }}">Ипотека</a></li>
            <li><a class="menu_item none-border" href="{{ route('requests.contacts') }}">Контакты</a></li>
            </li>
        </ul>
    </div>

    <div class="logo-mob-wrapper">
        <a class="text-logo-menu-mob" href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup class="logo-menu-io-mob">. io</sup></a>
    </div>

    <div class="phone-top-menu-mob">
        {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
    </div>

</div> --}}


<script>
    $(".contact-phone-wrapper").click(function () {
    @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
    setTimeout(function () {
        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('click-on-phone');
    }, 10000);
    @endif
});

</script>

{{-- PC --}}
<div class="gradient-black-menu bag-white">
    <div class="container menu-wrapper">
        <div class="menu-list-wrapper">
            <a class="logo-menu-img" href="{{ url(getUrlPathFirstPart() . '/') }}"><img src="/img/logo-menu.svg"></a>
            <a class="menu-list-item" href="{{ url(getUrlPathFirstPart() . '/') }}"><img src="/img/home-black.svg"></a>
            <a class="menu-list-item" href="{{ route('developers.index') }}">Застройщики</a>
            <a class="menu-list-item" href="{{ route('residentials.spa') }}">Новостройки</a>
            <a class="menu-list-item" href="{{ route('ipoteka.spa') }}">Ипотека</a>
            <a class="menu-list-item" href="{{ route('requests.contacts') }}">Контакты</a>
        </div>

        <div class="menu-phone-wrapper">
            <div class="phone-top-menu">
                <img src="/img/phone-white.svg">{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
            </div>
        </div>
    </div>
</div>



<div class="gradient-black-menu bag-mob-menu">

    <div class="burger-wrapper-mob">
        <input class="input-burger-menu" type="checkbox" id="showmenuall">
        <label class="label-burger-menu" for="showmenuall" onclick="$('.menu-all').slideToggle(200)">
                <div class="burger-menu-line first-line"></div>
                <div class="burger-menu-line second-line"></div>
                <div class="burger-menu-line third-line"></div>
                <div class="burger-menu-line fourth-line"></div>
            </label>
        <ul class="menu-all">
            <li><a class="menu_item" href="{{ route('developers.index') }}">Застройщики</a></li>
            <li><a class="menu_item" href="{{ route('residentials.spa') }}">Новостройки</a></li>
            <li><a class="menu_item" href="{{ route('ipoteka.spa') }}">Ипотека</a></li>
            <li><a class="menu_item none-border" href="{{ route('requests.contacts') }}">Контакты</a></li>
            </li>
        </ul>
    </div>
    <div class="left-position-menu">
        <div class="logo-mob-wrapper">
            <a class="logo-menu-img" href="{{ url(getUrlPathFirstPart() . '/') }}"><img src="/img/logo-menu.svg"></a>
        </div>


        <div class="phone-top-menu">
            {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
        </div>
    </div>
</div>