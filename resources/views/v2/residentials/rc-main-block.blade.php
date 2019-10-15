<section id="main-block">
    <div class="real-estate-complex-bg" style="background-image: linear-gradient(10deg, rgba(31,29,57,0.7) 25%, rgba(31,29,57,0) 60%), url({{ $residential->bg_image_original }})">
        <div class="rc-main-block-position">

            <div class="container">
                {{-- v2.discount --}} 
                @if ($isActiveDiscount)
                <div class="btn--discount discount__button" onclick="showDiscount()">
                    <div>Акция</div>
                </div>
                @endif
                <div class="row d-none d-md-block">
                    <div class="col-lg-12">
                        <div class="rc-main-block">
                            <div class="rc-main-block-title">
                                <h1>
                                    <div class="type-residential-complex">{{-- !empty(BUILDING_TYPES[$residential->building_type]) ? BUILDING_TYPES[$residential->building_type]
                                        : '' --}}</div>
                                    <div class="name-residential-complex">ЖК {{ $residential->title }}</div>
                                </h1>
                            </div>

                            <div class="rc-main-info">
                                @if($residential->address)
                                <a href="#map">
                                    <div class="rc-main-info-item">
                                        <div class="img-rc-wrapper pad-lef"><img class="d-none d-md-block" src="/img/map.png" alt="маркер">
                                            <img class="d-block d-md-none" src="/img/m-flags.png" alt="маркер">
                                        </div>
                                        <div class="rc-info-box">
                                            <div class="rc-info-text">Месторасположение:</div>
                                            <div class="rc-info-database">{{ !empty($residential->district) ? $residential->district->name.' район,' :
                                                ''}} {{ $residential->address }}</div>
                                        </div>
                                    </div>
                                </a>
                                @endif @if($residential->metro_station_id)
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

                            <div class="number-of-rooms-box">
                                @foreach (ROOMS['main'] as $key => $label) @if(isset($residential->main_ranges[$key]))
                                <div class="rooms-box" onclick="goToRoom({{$key}})">
                                    <div class="number-of-rooms">{{ $label }}</div>
                                    <div class="data-of-rooms">
                                        <div>от <span>{{ number_format($residential->main_ranges[$key]->price_min, 0, ',', ' ') }} р.<span class="sing-multiply d-block d-sm-none">&#183;</span></span>
                                        </div>
                                        <div>до <span>{{ $residential->main_ranges[$key]->area_max }} м<sup>2</sup> </span></div>
                                    </div>
                                </div>
                                @else
                                <div class="rooms-box locked-rooms-box">
                                    <div class="number-of-rooms">{{ $label }}</div>
                                    <div class="data-of-rooms">
                                        <div>уточняйте в отделе продаж</div>
                                    </div>
                                </div>
                                @endif @endforeach
                                <div class="rooms-box locked-rooms-box">
                                    <div class="number-of-rooms locked-rooms locked-number-rooms">4-ком.+</div>
                                    <div class="data-of-rooms locked-rooms">
                                        <div>уточняйте в отделе продаж</div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        function goToRoom(key) {
            $('#rooms-' + key + '-label').click();
            $("html,body").animate({scrollTop: $('#apartments').offset().top - 100}, 500);

            @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                setTimeout(function () {
                    yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('click-on-rooms-in-header');
                }, 10000);
            @endif
        }
    </script>
</section>