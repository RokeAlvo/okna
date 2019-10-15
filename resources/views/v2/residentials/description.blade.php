<section id="rc-main-description">
    <div class="container mb60">

        <div class="row d-block d-md-none">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="rc-main-block">
                    <div class="rc-block-up-m">
                        <div>
                            <h1>
                                <div class="type-residential-complex">
                                    {{-- !empty(BUILDING_TYPES[$residential->building_type]) ? BUILDING_TYPES[$residential->building_type] : '' --}}</div>
                                <div class="name-residential-complex">ЖК {{ $residential->title }}</div>
                            </h1>
                        </div>

                        <div class="rc-main-info">
                            @if($residential->address)
                                <a href="#mobmap">
                                    <div class="rc-main-info-item">
                                        <div class="img-rc-wrapper pad-lef">
                                            <img class="d-block d-md-none" src="/img/m-flags.png" alt="маркер">
                                        </div>
                                        <div class="rc-info-box">
                                            <div class="rc-info-text">Месторасположение:</div>
                                            <div class="rc-info-database">{{ !empty($residential->district) ? $residential->district->name.' район,' : ''}} {{ $residential->address }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            @if($residential->metro_station_id)
                                <div class="rc-main-info-item">
                                    <div class="img-rc-wrapper"><img class="d-none d-md-block" src="/img/metro.png" alt="метро">
                                        <img class="d-block d-md-none" src="/img/m-metro-logo.png" alt="маркер">
                                    </div>
                                    <div class="rc-info-box">
                                        <div class="rc-info-text">Метро:</div>
                                        <div class="rc-info-database">{{ $residential->getMetro() }}</div>
                                    </div>
                                </div>
                            @endif

                            <div class="rc-main-info-item">
                                <div class="img-rc-wrapper"><img class="d-none d-md-block" src="/img/deadline.png" alt="срок cдачи">
                                    <img class="d-block d-md-none" src="/img/m-key.png" alt="срок здачи">
                                </div>
                                <div class="rc-info-box">
                                    <div class="rc-info-text">Срок сдачи от:</div>
                                    <div class="rc-info-database">{{ $residential->getCompletionDate('full') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-of-rooms-box">
                        @foreach (ROOMS['main'] as $key => $label)
                            @if(isset($residential->main_ranges[$key]) && $key != 31)
                                <div class="rooms-box" onclick="goToRoom({{$key}})">
                                    <div class="data-rooms-wrapper-m">
                                        <div class="number-of-rooms">{{ $label }}</div>
                                        <div class="flex-info">от {{ number_format($residential->main_ranges[$key]->price_min, 0, ',', ' ') }} руб. <span
                                                    class="d-block d-md-none sing-multiply">&#183;</span>
                                            до {{ $residential->main_ranges[$key]->area_max }} м<sup>2</sup></div>
                                    </div>
                                    <div class="wrapper-right-img"><img src="/img/right.png"></div>
                                </div>
                            @elseif($key != 31)
                                <div class="rooms-box">
                                    <a href="#" class="main-phone" onclick="yaMetrics">
                                        <div class="data-rooms-wrapper-m">
                                            <div class="number-of-rooms locked-text-number-m">{{ $label }}</div>

                                            <div class="locked-text-number-m">Узнавайте в отделе продаж</div>
                                        </div>
                                        <div class="wrapper-right-img"><img src="/img/phone-gray.png"></div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        <div class="rooms-box">
                            <a href="#" class="main-phone" onclick="yaMetrics">
                                <div class="data-rooms-wrapper-m">
                                    <div class="number-of-rooms locked-text-number-m">3-ком.</div>

                                    <div class="locked-text-number-m">Узнавайте в отделе продаж</div>
                                </div>
                                <div class="wrapper-right-img"><img src="/img/phone-gray.png"></div>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="rc-main-description">
                    <h2 class="title-about-description" id="about-rc">О новостройке</h2>
                    <div class="about-description-text">
                        <p> {{ $residential->description }} </p>
                        {!! $residential->text !!}
                    </div>
                </div>
            </div>
            @if($residential->features->count())
                <div class="col-lg 6 col-md-12 col-sm-12 col-xs-12 advantages-box">
                    <div class="row">
                        <div class="col-lg-2 col-md-12 col-xs-12">
                            <div class="advantages-wrapper">
                                <div class="advantages">Ключевые преимущества</div>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-12 col-xs-12">
                            @foreach ($residential->features as $key => $feature)
                                <div class="advantages-info-wrapper">
                                    <div class="advantages-info-short-wrapper accordion">
                                        <div class="advantages-static">
                                            <div class="advantages-number">{{ $key + 1 }}</div>
                                            <div class="advantages-name">{{ $feature->title }} {{ $feature->subtitle }}</div>
                                        </div>
                                    </div>
                                    <div class="advantages-more-text-wrapper panel">
                                        <div class="advantages-more-text">{{ $feature->text }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</section>
<script>
    //$(window).resize(function () {
    if ($(window).width() < 600) {
        $('.about-description-text').first().addClass('text-more-down');
    }
    ;
    //});
</script>
<script>
    $(document).ready(function () {
        $('.text-more-down').collapser({
            mode: 'lines',
            truncate: 12,
            showText: '<div class="serff" style="padding-top: 10px; color:#00BC00;font-family: MontserratBold">Подробнее..</div>',
            hideText: '<div class="serff" style="padding-top: 10px; color:#7C858B;font-family: MontserratBold">Скрыть..</div>',
        });

    });
</script>
<script>
    function yaMetrics() {
        $(".contact-phone-wrapper").click(function () {
            @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
            setTimeout(function () {
                yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('click-phone-no-rooms');
            }, 10000);
            @endif
        });
    }
</script>

{{-- <div class="col-md-6">
                    <div class="rc-main-description-text">
                        {!! $residential->text !!}
                    </div> --}}