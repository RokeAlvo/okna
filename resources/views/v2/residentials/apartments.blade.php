<section id="apartments" data-ga-popup-open-label="{{ $gaLabel }}" data-ga-popup-goal-label="{{ $gaGoalLabel }}" data-ga-popup-goal-phone-label="{{ $gaGoalPhoneLabel }}">
    <div class="container" id="layouts-vue">
        <h2 class="title-about-description pad-left-right marg-bottom0">Квартиры@if($residential->has_full_decoration) <br class="d-block d-sm-none">с ремонтом@endif</h2>

        {{--APARTMENTS-MOBILE--}}
        <div class="d-block d-md-none marg-bottom">
            {{-- with carousel --}} {{--@foreach($residential->main_ranges as $range) @php $oneRoomLayouts = $residential->layouts->where('rooms',
            $range->rooms); 
@endphp @if($layoutCount = $oneRoomLayouts->count())
            <div class="m-wrapper-numbers">
                <div class="m-rooms-number">{{ $range->getRoomLabel('full') }}</div>
                @if($allFlatsButton == 'show')
                <div class="m-all-rooms-number" @click="fetchOneRoomLayouts({{$range->rooms}})">Посмотреть все</div>
                @endif
            </div>

            <div class="carousel-wrapper">
                <div class="owl-carousel owl-theme">
                    @foreach ($oneRoomLayouts as $key => $layout)
                    <div class="rooms-plan-box item" @click="selectLayout({{ $layout }}, {{ $key }})">
                        <div class="rooms-wrapper">
                            <div class="rooms-plan-img">
                                @if($layoutSize == 'small')
                                <img src="{{$layout->thumbnail}}" style="max-height: 150px"> @else
                                <img src="{{$layout->thumbnail}}"> @endif
                            </div>
                            <div class="rooms-area-box">
                                <div class="col-md-6 col-xs-6 col-lg-6 rooms-number">{{$layout->room_label}}</div>
                                <div class="col-md-6 col-xs-6 col-lg-6 rooms-area"> {{$layout->area}} м<sup>2</sup></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div> --}} {{-- end with carousel --}}
            <div class="gradient-filter-number">
                <div class="wrapper-filter-numbers">
                    <input type="checkbox" class="choose-input" id="choose-rooms">
                    <label for="choose-rooms" class="choose-label" @click="$('.all-number-button-wrapper').slideToggle(200)">
                    <div class="choose-number-rooms">
                        <div id="block-choose" class="number-rooms-m">
                            <span class="choose-pre-text" v-if="roomLabels.length">Выбрано:&nbsp;</span>
                            @{{ roomLabels.length ? roomLabels.join(', ') : 'Выберите кол-во комнат'}}
                        </div>
                        <div class="options-img-wrapper">{{-- <img src="/img/options-green.svg"> --}}</div>
                    </div>
                </label>
                    <div class="all-number-button-wrapper">

                        <div class="all-number-button-m">


                            <input class="rooms_decoration_checkbox-m d-none" :class="{ 'checked-filter-m': !rooms.length }" id="all-rooms-mobile" type="checkbox"
                                :checked="allRoomCheckbox">
                            <label for="all-rooms-mobile" @click="checkAllRooms" class="rooms-decoration-box-m d-md-none" {{-- :class="{'rooms_decoration_checkbox-m': allRoomCheckbox}"
                                --}}>
                                <div class="number-of-rooms-decoration-m">Все</div>
                            </label> @foreach (ROOMS['main'] as $key => $label) @if(isset($residential->main_ranges[$key]))
                            <input class="d-none rooms_decoration_checkbox-m" id="rooms-m-{{$key}}" type="checkbox" v-model="rooms" value="{{$key}}"
                                @change="fetchLayouts(1)">
                            <label for="rooms-m-{{$key}}" id="rooms-m-{{$key}}-label" class="rooms-decoration-box-m">
                                        <div class="number-of-rooms-decoration-m">{{$label}}</div>
                                    </label> @endif @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{--
            <div class="fetching" v-if="fetching">
                <div class="sk-fading-circle" style="height: @{{ layoutsHeight }}">
                    <div class="sk-circle1 sk-circle"></div>
                    <div class="sk-circle2 sk-circle"></div>
                    <div class="sk-circle3 sk-circle"></div>
                    <div class="sk-circle4 sk-circle"></div>
                    <div class="sk-circle5 sk-circle"></div>
                    <div class="sk-circle6 sk-circle"></div>
                    <div class="sk-circle7 sk-circle"></div>
                    <div class="sk-circle8 sk-circle"></div>
                    <div class="sk-circle9 sk-circle"></div>
                    <div class="sk-circle10 sk-circle"></div>
                    <div class="sk-circle11 sk-circle"></div>
                    <div class="sk-circle12 sk-circle"></div>
                </div>
            </div> --}} @if($mobileApartmentsView == 'one-black')
            <div class="aparments-wrapper-m" id="search-new-layout-flats">
                <div class="fetching fetching-mob" v-if="fetching">
                    <div class="sk-fading-circle" style="height: @{{ layoutsHeight }}">
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                </div>
                <div class="rooms-wrapper-m" v-for="(layout, index) in layouts" @click="selectLayout(layout, index)">
                    <div class="rooms-plan-img-m">
                        <img :src="layout.thumbnail">
                    </div>
                    <div class="rooms-info-box-m">
                        <div class="rooms-number-area-wrapper">
                            <div class="rooms-number-area-m">
                                <div class="number-title">Комнаты</div>
                                <div class="info-data">@{{layout.room_label}}</div>
                            </div>
                            <div class="rooms-number-area-m">
                                <div class="number-title">Площадь</div>
                                <div class="info-data">@{{layout.area}} м<sup>2</sup></div>
                            </div>
                        </div>
                        <div class="popup-more">Подробнее</div>
                    </div>
                </div>
            </div>
            @else {{-- apartments version2 --}}
            <div class="rooms-plan-box-wrapper-m2" id="search-new-layout-flats">
                <div class="fetching fetching-mob" v-if="fetching">
                    <div class="sk-fading-circle" style="height: @{{ layoutsHeight }}">
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                </div>

                <div class="rooms-plan-box-m2" v-for="(layout, index) in layouts" @click="selectLayout(layout, index)" v-cloak>
                    <div class="rooms-plan-img-m2">
                        <img :src="layout.thumbnail">
                    </div>
                    <div class="rooms-area-box-m2">
                        <div class="rooms-number-m2">@{{layout.room_label}}</div>
                        <div class="rooms-area-m2"> @{{layout.area}} м<sup>2</sup></div>
                    </div>
                </div>

            </div>
            <div v-if="!fetching">
    @include('v2.residentials.discount')</div>
            {{-- apartments version2 end --}} @endif


        </div>

        {{--APARTMENTS-PC--}}
        <div class="d-none d-md-block">
            <div class="number-of-rooms-decoration-box">
                <input name="rooms" class="rooms_decoration_checkbox d-none" :class="{ 'checked-filter': !rooms.length }" id="all-rooms"
                    type="checkbox" :checked="allRoomCheckbox">
                <label for="all-rooms" @click="checkAllRooms" class="rooms-decoration-box d-none d-md-block">
                    <div class="number-of-rooms-decoration">Все</div>
                    <div class="data-of-rooms-decoration">
                        <div><span class="pretext">от </span>{{ number_format($residential->main_ranges->min('price_min'), 0, ',', ' ') }} р.</div>
                        <div><span class="pretext">до </span>{{$residential->main_ranges->max('area_min') }} м<sup>2</sup></div>
                    </div>
                </label> @foreach (ROOMS['main'] as $key => $label) @if(isset($residential->main_ranges[$key]))
                <input name="rooms" class="d-none rooms_decoration_checkbox" id="rooms-{{$key}}" type="checkbox" v-model="rooms" value="{{$key}}"
                    @change="fetchLayouts(1)">
                <label for="rooms-{{$key}}" id="rooms-{{$key}}-label" class="rooms-decoration-box">
                            <div class="number-of-rooms-decoration">{{$label}}</div>
                            <div class="data-of-rooms-decoration">
                                <div><span class="pretext">от </span>{{ number_format($residential->main_ranges[$key]->price_min, 0, ',', ' ') }} р.</div>
                                <div><span class="pretext">до </span>{{ $residential->main_ranges[$key]->area_max }} м<sup>2</sup></div>
                            </div>
                        </label> @else
                <div class="rooms-decoration-box rooms-decoration-box-locked d-none d-sm-block">
                    <div class="number-of-rooms-decoration">{{$label}}</div>
                    <div class="data-of-rooms-decoration">
                        <div class="pretext">узнавайте в отделе продаж</div>
                    </div>
                </div>
                @endif @endforeach
                <div class="rooms-decoration-box rooms-decoration-box-locked d-none d-sm-block">
                    <div class="number-of-rooms-decoration">4-ком.+</div>
                    <div class="data-of-rooms-decoration">
                        <div class="pretext">узнавайте в отделе продаж</div>
                    </div>
                </div>
            </div>

            <div v-if="fetching">
                <div class="sk-fading-circle" style="height: @{{ layoutsHeight }}">
                    <div class="sk-circle1 sk-circle"></div>
                    <div class="sk-circle2 sk-circle"></div>
                    <div class="sk-circle3 sk-circle"></div>
                    <div class="sk-circle4 sk-circle"></div>
                    <div class="sk-circle5 sk-circle"></div>
                    <div class="sk-circle6 sk-circle"></div>
                    <div class="sk-circle7 sk-circle"></div>
                    <div class="sk-circle8 sk-circle"></div>
                    <div class="sk-circle9 sk-circle"></div>
                    <div class="sk-circle10 sk-circle"></div>
                    <div class="sk-circle11 sk-circle"></div>
                    <div class="sk-circle12 sk-circle"></div>
                </div>
            </div>
            <div v-else id="search-new-layout-flats">
                <div class="all-rooms-plan-box row">
    @include('v2.residentials.discount')
    @include('v2.layouts.card', ['layoutsData' => 'layouts'])

                </div>

            </div>
        </div>

        {{--
        <div class="all-rooms-plan-box">
            <div class="rooms-plan-box">
                <div class="rooms-plan-img"><img src="/img/1k.png"></div>
                <div class="rooms-area-box">
                    <div class="rooms-number">1-ком.</div>
                    <div class="rooms-area">37 м<sup>2</sup></div>
                </div>
            </div>
        </div> --}} {{--
    @include('v2.layouts.popup-all-apartments') --}}
    @include('v2.layouts.'.$popupType)
    @include('v2.layouts.popup-all-apartments')

    </div>
</section>
<script>
    @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
    setTimeout(function () {
        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('{{$mobileApartmentsViewGoal}}');
    }, 10000);
    @endif

</script>

{{--
<script>
    $(window).scroll(function() {
    if ($(this).scrollTop() > 2385) {
       $('.all-number-button-m').css({
            'display': 'none'
        });
    }
   
});

</script> --}} {{--
<script>
    var mywindow = $(window);
var mypos = mywindow.scrollTop();
var up = false;
var newscroll;
mywindow.scroll(function () {
    newscroll = mywindow.scrollTop();
    if (newscroll > mypos && !up) {
        $('.all-number-button-m').stop().slideToggle();
        up = !up;
        console.log(up);
    } else if(newscroll < mypos && up) {
        $('.all-number-button-m').stop().slideToggle();
        up = !up;
    }
    mypos = newscroll;
});

</script> --}}