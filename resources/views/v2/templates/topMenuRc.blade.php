@php $reallySlowpoke = $residential->developer->slowpoke && in_array($residential->id, [179,190]) && getUrlPathFirstPart()
=== 'novosibirsk'; // Расцветай, ебонтяй! 
@endphp {{-- MOBILE --}}
@php 
$absoluteSlowpoke = in_array($residential->id, [156]) && getUrlPathFirstPart() === 'novosibirsk'; // праймхаус еее бой
@endphp
<div class="m-all-menu-wrapper d-block d-lg-block d-xl-none">

    <div class="m-all-menu">

        <input class="nav_check" type="checkbox" id="showmenu">
        <label class="nav_showmenu label-menu-m" for="showmenu">
            <div class="burger-line-m first-m"></div>
            <div class="burger-line-m second-m"></div>
            <div class="burger-line-m third-m"></div>
            <div class="burger-line-m fourth-m"></div>
        </label>
        <ul class="menu">
            <li class="bag-gray"><a class="menu_item text-grey" href="#">Навигация по новостройке</a></li>
            <li><a class="menu_item" href="#about-rc" onclick="goToElement('#about-rc')">О новостройке</a></li>
            <li><a class="menu_item" href="#apartments" onclick="goToElement('#apartments')">Квартиры</a></li>
            <li><a class="menu_item" href="#gallery" onclick="goToElement('#gallery')">Фото@if(!empty($residential) && $residential->video) и видео@endif</a></li>
            <li><a class="menu_item" href="#map-rc-new" onclick="goToElement('#map-rc-new')">Месторасположение</a></li>
            <li class="more-down-item">
                <input class="menu_check" type="checkbox" id="menu2">

                <label class="menu_showsub button-more-menu" for="menu2">
                    <div class="menu_showsub_more"><b>Еще ...</b></div>
                    <div class="menu_showsub_header">Навигация по сайту</div>
                </label>
                <ul class="menu_submenu">
                    <li><a class="menu_item" href="{{ route('developers.index') }}">Застройщики</a></li>
                    <li><a class="menu_item" href="{{ route('residentials.spa') }}">Новостройки{{-- на карте--}}</a></li>
                    <li><a class="menu_item" href="{{ route('requests.mortgage') }}">Ипотека</a></li>
                    <li><a class="menu_item none-border" href="{{ route('requests.contacts') }}">Контакты</a></li>
                    <div class="menu-text-logo none-border-all"><a href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup class="logo-io">. io</sup></a></div>
                    {{--
                    <li><a class="menu-down" href="#">Поиск квартир</a></li>--}}
                </ul>

            </li>
        </ul>
    </div>
    <div class="contact-phone-wrapper">
        @if ($isActiveDiscount)
        <div class="btn--discount discount__button--head" onclick="showDiscount()">
            <div>Акция</div>
        </div>
        @endif
        <div class="phone-icon">
            <img src="/img/phone-icon.png">
        </div>
        <div class="wrapper-phone-top-menu">
            @if($absoluteSlowpoke)
            <div class="phone-text d-block">Официальный партнёр застройщика:</div>
            @elseif (!$residential->developer->slowpoke)
            <div class="phone-text d-none d-md-block">телефон отдела продаж:</div>
            <div class="phone-text d-block d-md-none">Отдел продаж:</div>
            @elseif($reallySlowpoke)
            <div class="phone-text d-block">Официальный партнёр:</div>
            @endif
            <div class="phone-number">{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</div>
        </div>
    </div>

    <script>
        $('.menu .menu_item').click(function () {
            $('input.nav_check').prop("checked", false);
        });
    </script>
</div>

<script>
    $(".menu_showsub").click(function () {
        $(this).find('.menu_showsub_more').toggle(200);
        $(this).find('.menu_showsub_header').toggle(200);
        $(this).toggleClass('bag-gray');
    });

    $(".contact-phone-wrapper").click(function () {
        @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
        setTimeout(function () {
            yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('click-on-phone');
        }, 10000);
        @endif
    });

</script>

{{-- PC --}}
<div class="menu-all-box d-none d-xl-block">
    <div class="menu-color-left"></div>
    <div class="container box-flex-wrapper">
        <div class="menu-wrapper">
            <div class="menu-box">
                <input type="checkbox" id="check-menu">
                <label class="label-menu" for="check-menu"></label>
                <div class="burger-line first"></div>
                <div class="burger-line second"></div>
                <div class="burger-line third"></div>
                <div class="burger-line fourth"></div>

                <div class="main-menu">
                    @if (!$residential->developer->slowpoke)
                    <div class="menu-text-logo"><a href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup class="logo-io">. io</sup></a></div> @endif
                    <div class="menu-string">
                        <a class="menu-down" href="{{ route('developers.index') }}">Застройщики</a>
                        <a class="menu-down" href="{{ route('residentials.spa') }}">Новостройки{{-- на карте--}}</a>
                        <a class="menu-down" href="{{ route('requests.mortgage') }}">Ипотека</a> {{-- <a class="menu-down"
                            href="#">Поиск квартир</a>--}}
                        <a class="menu-down" href="{{ route('requests.contacts') }}">Контакты</a>

                    </div>
                </div>
            </div>
            <div class="d-none d-md-block">
                <div class="list-up">
                    @if ($residential->developer->slowpoke)
                    <div class="menu-text-logo menu-text-logo-for-dev"><a href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup class="logo-io">. io</sup></a></div> @endif
                    <a class="menu-up" href="#about-rc">О новостройке</a>
                    <a class="menu-up" href="#apartments">Квартиры</a>
                    <a class="menu-up" href="#gallery">Фото@if(!empty($residential) && $residential->video) и видео @endif</a>

                    <a class="menu-up" href="#map-rc-new">{{ $residential->developer->slowpoke ? 'Карта' : 'Месторасположение' }}</a>                    @if ($isActiveDiscount)

                    <div class="btn--discount discount__button--head" onclick="showDiscount()">
                        <div>Акция</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="contact-phone-wrapper">
            <div class="phone-icon">
                <img src="/img/phone-icon.png">
            </div>
            <div class="wrapper-phone-top-menu">
                @if($absoluteSlowpoke)
                <div class="phone-text d-block">Официальный партнёр застройщика:</div>
                @elseif (!$residential->developer->slowpoke)
                <div class="phone-text d-none d-md-block">телефон отдела продаж:</div>
                <div class="phone-text d-block d-md-none">Отдел продаж:</div>
                @elseif($reallySlowpoke)
                <div class="phone-text d-block">Официальный партнёр:</div>
                @endif
                <div class="phone-number">{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</div>
            </div>
        </div>
    </div>

    <div class="menu-color-right"></div>

</div>