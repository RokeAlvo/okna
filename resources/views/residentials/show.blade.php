@extends('templates.main')

@section('head-scripts')
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
@endsection

@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script>
    <script src="{{ url('js/residentials/pagination.js') }}"></script>
    <script src="{{ url('js/residentials/show.js') }}"></script>
    <script src="{{ url('js/popup.js') }}"></script>
@endsection

@section('title', 'Все о наиболее популярных новостройках города Новосибирска')

@section('content')
    <h1 data-residential-url="{{ route('residentials.show', [$residential->alias]) }}">{{ $residential->title }}</h1>
    <div class="real-estate-complex-bg" style="background-image: url({{ $residential->bg_image_original }});">
        <div class="rc-main-block-position">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-9">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="rc-main-block">
                                    <h1>{{ !empty(BUILDING_TYPES[$residential->building_type]) ? BUILDING_TYPES[$residential->building_type] : '' }}
                                        <span>&laquo;{{ $residential->title }}&raquo;</span></h1>

                                    <p>{{ $residential->description }}</p>

                                    <ul class="list-unstyled list-params mb10">
                                        <li>Застройщик:<span>{{ $residential->developer->name }}</span></li>
                                        <li>Район:
                                            <span>{{ ($residential->district) ? $residential->district->name : "Не указано" }}</span>
                                        </li>
                                        <li>Срок сдачи
                                            от:<span>{{ $residential->getHousesCompletionDatesRange() }}</span>
                                        </li>
                                        <li>Класс
                                            жилья:<span>{{ COMFORT_CLASSES[$residential->comfort_class] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                @if (!empty($residential->price_meter_from))
                                    <div class="rc-feature">
                                        <img src="{{ url('/img/price-icon.png') }}">
                                        <p>Цена от</p>
                                        <p class="rc-feature-big-number"><?= number_format($residential->price_meter_from, 0, ',', ' ') ?></p>
                                        <p>руб/м<sup>2</sup></p>
                                    </div>
                                @endif

                                @if (!empty($residential->minutes_to_metro))
                                    <div class="rc-feature">
                                        <img src="{{ url('/img/metro-icon.png') }}">
                                        <p class="rc-feature-big-number">{{ $residential->minutes_to_metro }} мин</p>
                                        <p>до станции</p>
                                        <p>метро</p>
                                    </div>
                                @endif

                                @if (!empty($residential->kilometers_to_center))
                                    <div class="rc-feature">
                                        <img src="{{ url('/img/road-with-broken-line.png') }}">
                                        <p class="rc-feature-big-number">{{ $residential->kilometers_to_center }} км</p>
                                        <p>до</p>
                                        <p>центра</p>
                                    </div>
                                @endif

                                @if (empty($residential->price_meter_from) || empty($residential->minutes_to_metro) || empty($residential->kilometers_to_center))
                                    <div class="rc-feature">
                                        <img src="/img/bus-station.png">
                                        <p class="rc-feature-big-number">{{$residential->minutes_to_bus}} мин</p>
                                        <p>до</p>
                                        <p>остановки</p>
                                    </div>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container complex-info">
        <div class="row">
            <div class="col-xs-12">
                <section id="rc-main-description">
                    <h2>Подробно о жилом комплексе</h2>
                    <div class="rc-main-description">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="rc-main-description-wrapper-img">
                                    <img src="{{ $residential->main_image }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="rc-main-description-text">
                                    {!! $residential->text !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <template id="pagination-template">
                    <ul class="pagination">
                        {{--<li class="first"><span v-if="hasFirst()" @click="changePage(1)">В начало</span></li>--}}

                        <li class="prev"><span @click="changePage(prevPage)">«</span></li>

                        <li v-for="page in pages" :class="{ active: current == page }"><span @click="changePage(page)"
                            >@{{ page }}</span></li>

                        <li class="next"><span @click="changePage(nextPage)">»</span></li>

                        {{--<li class="last"><span v-if="hasLast()" @click="changePage(totalPage)">В конец</span></li>--}}
                    </ul>
                </template>

                <section id="layouts">

                    <h2>Квартиры от застройщика</h2>

                    <div class="panel-group visible-sm visible-xs" id="accordion" role="tablist"
                         aria-multiselectable="true">
                        @foreach($residential->ranges as $range)
                            <div class="panel">
                                <div class="panel-heading" role="tab" id="headingroom-3">
                                    <div class="panel-heading-button collapsed" role="button" data-toggle="collapse"
                                         data-parent="#accordion"
                                         href="#collapseroom-3" aria-expanded="true" aria-controls="collapseroom-3">
                                        <div class="apartment-acc-info">
                                            <div class="apartment-acc-info-room">
                                                {{ $range->getRoomLabel() }}
                                            </div>
                                            <div class="apartment-acc-info-price">
                                                {{ $range->getPriceRange() }} руб.
                                            </div>
                                        </div>
                                        <div class="apartment-acc-amount">
                                            @php($layoutCount = $residential->layouts->where('rooms', $range->rooms)->count())
                                            {{ $layoutCount }} {{ number($layoutCount, ['вариант', 'варианта', 'вариантов']) }}

                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div id="collapseroom-3" class="panel-collapse collapse in" role="tabpanel"
                                     aria-labelledby="headingroom-3">
                                    <div class="visible-xs visible-sm">
                                        <div class="row">
                                            <div class="col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="30803">
                                                <div class="preview-apartment-element block-shadow">
                                                    <div class="quick-view" data-apartment-id="30803"
                                                         data-floors-list="3-12,14-16"
                                                         data-url="/apartment/quick-view?id=30803&amp;floors=3-12%2C14-16&amp;pricemin=4409160&amp;pricemax=8402645">
                                                        <div class="preview-apartment-thumbimage"><img
                                                                    class="img-responsive"
                                                                    src="/uploads/layouts/1640/nsqmcZgGi3vVaSfQ.jpg"
                                                                    alt=""></div>
                                                        <div class="preview-apartment-typearea">3-ком.|
                                                            <strong>109.2м<sup>2</sup></strong></div>
                                                        <div class="preview-apartment-floor-list">3-12,14-16 этажи</div>
                                                        <div class="preview-apartment-moreinfo">Подробнее</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form class="visible-md visible-lg">
                        <div class="apartment_filter">
                            <div class="apartment_filter_number_rooms2">
                                <div class="row">
                                    <div class="col-xs-five">
                                        <div class="apartment_filter_number_rooms_group">
                                            <input type="checkbox" name="rooms" id="all-rooms"
                                                   v-model="allRoomCheckbox" @change="checkAllRooms">
                                            <label for="all-rooms">
                                                <div class="type-rooms-vlaue">
                                                    Все
                                                </div>
                                                <div class="cost-distance">
                                                    {{ number_format($residential->ranges->min('price_min'), 0, ',', ' ') }}
                                                    - {{ number_format($residential->ranges->max('price_max'), 0, ',', ' ') }}
                                                    руб.
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @foreach($residential->ranges as $range)
                                        <div class="col-xs-five">
                                            <div class="apartment_filter_number_rooms_group">
                                                <input type="checkbox" name="rooms" id="room-{{$range->id}}"
                                                       value="{{$range->rooms}}" v-model="rooms" @change="
                                                fetchLayouts(1)">
                                                <label for="room-{{$range->id}}">
                                                    <div class="type-rooms-vlaue">
                                                        {{ !empty(ROOMS['short'][$range->rooms]) ? ROOMS['short'][$range->rooms] : '' }}
                                                    </div>
                                                    <div class="cost-distance">
                                                        {{ $range->getPriceRange() }} руб.
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="apartment-filter-cost-area-floor">
                                <div class="row">
                                    <div class="col-xs-five">
                                        <div class="apartment-filter-area">
                                            <p>Площадь, м<sup>2</sup>:</p>
                                            <input name="area_range[min]" placeholder="30"
                                                   v-model="areaRange[0]" @change="fetchLayouts(1)">
                                            <span class="h-sep"></span>
                                            <input name="area_range[max]" placeholder="145"
                                                   v-model="areaRange[1]" @change="fetchLayouts(1)">
                                        </div>
                                    </div>
                                    <div class="col-xs-five">
                                        <div class="apartment-filter-floor">
                                            <p>Этаж:</p>
                                            <input name="floor_range[min]" placeholder="1"
                                                   v-model="floorRange[0]" @change="fetchLayouts(1)">
                                            <span class="h-sep"></span>
                                            <input name="floor_range[max]" placeholder="24"
                                                   v-model="floorRange[1]" @change="fetchLayouts(1)">
                                        </div>
                                    </div>
                                    {{--<div class="col-xs-7">
                                        <div class="apartment_filter_buttons">
                                            <div class="apartment-filter-buttons-container">
                                                <button class="apartment_filter_buttons_apply" type="button">Показать
                                                    результаты
                                                </button>
                                                <button class="apartment_filter_buttons_reset" type="reset">Сбросить
                                                    фильтры
                                                </button>
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>
                        </div>

                        <div class="preview-apartment">
                            <div class="tab-content">
                                <div class="tab-pane active" id="allroom">
                                    <div class="row">
                                        <div id="p0">
                                            <div id="search-new-layout-flats" class="list-view">
                                                <div v-for="layout in layouts"
                                                     class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item">
                                                    <div class="preview-apartment-element block-shadow" @click="
                                                    showPopup('apartment')">
                                                    <div class="quick-view">
                                                        <div class="preview-apartment-thumbimage">
                                                            <div class="preview-apartment-thumbimage-wrapper">
                                                                <img class="img-responsive" :src="layout.thumbnail">
                                                            </div>
                                                        </div>
                                                        <div class="preview-apartment-typearea">@{{layout.room_label}} |
                                                            <strong>@{{layout.area}} м<sup>2</sup></strong>
                                                        </div>
                                                        <div class="preview-apartment-floor-list">
                                                            @{{layout.floor_range}}
                                                        </div>
                                                        <div class="preview-apartment-moreinfo">
                                                            Подробнее
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <pagination
                                                        :current="currentPage"
                                                        :perPage="perPage"
                                                        :total="totalLayouts"
                                                @page-changed="fetchLayouts"
                                                v-if="totalLayouts > perPage"
                                                ></pagination>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            </form>
            </section>


            @if (!empty($residential->features))
                <section id="features">
                    <h2>Особенности жилого комплекса</h2>
                    <div class="row">
                        @foreach ($residential->features as $features)
                            <div class="col-md-3 col-sm-6">
                                <div class="feature-item block-shadow">
                                    <h3>{{ $features->title }}
                                        <span>{{ ($features->subtitle) ? $features->subtitle : "&nbsp;" }}</span>
                                    </h3>
                                    <p>{{ $features->text }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
    </div>
    <div class="popup-wrapper" data-popup-window="apartment">
        <div class="popup">
            <div class="container">
                <div class="popup-block" data-popup-block="true">
                    <div class="popup-apartment ">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="popup-apartment-left">
                                    <div class="popup-apartment-info">
                                        <div class="popup-apartment-type">
                                            <span>Студия</span><span>26 м<sup>2</sup></span>
                                        </div>
                                        <div class="popup-apartment-floor">
                                            <b>1, 2, 3, 6-9</b> этаж
                                        </div>
                                    </div>
                                    <div class="popup-apartment-layout">
                                        <div class="popup-apartment-wrapper">
                                            <img src="http://smartcrm.pro/img/selection/stub-layout.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="popup-apartment-right">
                                        <ul class="popup-apartment-payment">
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/mortgage.png') }})"></i><span>Ипотека от 8% годовых</span>
                                            </li>
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/installment.png') }})"></i><span>Рассрочка 0% годовых</span>
                                            </li>
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/trade-in.png') }})"></i><span>TRADE-in без переплат</span>
                                            </li>
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/down-payment.png') }})"></i><span>Ипотека без первоначального взноса</span>
                                            </li>
                                        </ul>
                                        <div class="popup-apartment-cta-form">
                                            <div class="popup-apartment-price">
                                                <div class="popup-apartment-price-cta">
                                                    <span>Актуальную цену</br>узнавайте в отделе продаж</span>
                                                    <button>i</button>
                                                </div>
                                                <div class="popup-apartment-price-value">
                                                    <div class="popup-apartment-price-from">от <b>2 170 000</b>
                                                        <sup>руб.</sup>
                                                    </div>
                                                    <div class="popup-apartment-price-to">до <b>2 170 000</b>
                                                        <sup>руб.</sup>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="popup-apartment-form">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <input type="text" placeholder="+7 (___) ___-__-__">
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button>Узнать цену</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="popup-apartment-phone">Телефон отдела продаж: <b>+7 (383) 248 34
                                                    10</b>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img class="close-popup" data-popup-action="close" src="/img/icon-close-popup.png">
        </div>
    </div>
    </div>

    <section id="gallery">
        <div class="container"><h2>Фото объекта</h2>
            <div class="row">
                <div class="col-md-8">
                    <div class="slider-main">
                        <div id="gallery-main-wrapper">
                            <img id="gallery-main" src="">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="slider-nav row">
                    </div>
                </div>
            </div>
        </div>
        <script>
            var first = true;
            {!! 'var images = '.json_encode($residential->getGallery()).';' !!}
            $.each(images, function (main, thumb) {
                if (first) {
                    $('#gallery-main').attr('src', main);
                    first = false;
                }
                $('#gallery .slider-nav').append('<div class="col-md-6 col-sm-3 col-xs-4 p10"><div class="slider-nav-item" data-main-path="' + main + '"><img src="' + thumb + '"></div></div>');
            });
            $('#gallery .slider-nav-item').on('click', showBigGalleryImage);

            function showBigGalleryImage() {
                $('#gallery-main').attr('src', $(this).data('main-path'));
            }
        </script>
    </section>

    @if(\Illuminate\Support\Facades\App::environment() == 'production')
        @if (!empty($residential->latitude) && !empty($residential->longitude))
            <section id="map-rc-new">
                <div class="container">
                    <h2>Месторасположение на карте</h2>
                    <div class="new-map block-shadow">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="map" style="height:530px;"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="new-map-info">
                                    <div class="new-map-info-block">
                                        <div class="new-map-info-element">
                                            <img src="/img/map-developer.png">
                                            <div class="new-map-info-element-value">
                                                <div class="new-map-info-element-value-title">
                                                    Застройщик:
                                                </div>
                                                <div class="new-map-info-element-value-description">
                                                    {{ $residential->developer->name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="new-map-info-element">
                                            <img src="/img/map-residentail-complex.png">
                                            <div class="new-map-info-element-value">
                                                <div class="new-map-info-element-value-title">
                                                    Жилой комплекс:
                                                </div>
                                                <div class="new-map-info-element-value-description">
                                                    "{{ $residential->title }}"
                                                </div>
                                            </div>
                                        </div>
                                        <div class="new-map-info-element">
                                            <img src="/img/map-placeholder.png">
                                            <div class="new-map-info-element-value">
                                                <div class="new-map-info-element-value-title">
                                                    Адрес:
                                                </div>
                                                <div class="new-map-info-element-value-description">
                                                    {{ $residential->address }}
                                                </div>
                                            </div>
                                        </div>

                                        @if (!$residential->isSpecific())
                                            <div class="new-map-info-element">
                                                <img src="/img/map-clock.png">
                                                <div class="new-map-info-element-value">
                                                    <div class="new-map-info-element-value-title">
                                                        Часы работы:
                                                    </div>
                                                    <div class="new-map-info-element-value-description">
                                                        Пн-Пт, 09:00 - 18:00
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="new-map-info-element">
                                                <img src="/img/map-telephone.png">
                                                <div class="new-map-info-element-value">
                                                    <div class="new-map-info-element-value-title">
                                                        Отдел продаж:
                                                    </div>
                                                    <div class="new-map-info-element-value-description">
                                                        {{ SITE_CONTACTS['phone'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script type="text/javascript">
                var map;
                DG.then(function () {
                    map = DG.map('map', {
                        center: [{{$residential->latitude}}, {{$residential->longitude}}],
                        boxZoom: false,
                        closePopupOnClick: false,
                        doubleClickZoom: false,
                        fullscreenControl: false,
                        scrollWheelZoom: false,
                        zoom: 14,
                        zoomControl: false
                    });

                    DG.marker([{{$residential->latitude}}, {{$residential->longitude}}]).addTo(map);
                    DG.control.zoom({position: 'topright'}).addTo(map);
                });
            </script>
        @endif
    @endif

    @foreach($residential->developer->residentials as $residential)
        @include('residentials.card')
    @endforeach

@endsection