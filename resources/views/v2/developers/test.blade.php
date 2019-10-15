@extends('templates.main')

@section('head-scripts')
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
@endsection

@section('footer-scripts')
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/vue-resource.js') }}"></script>
    <script src="{{ url('js/vue-slider-component.js') }}"></script>
    <script src="{{ url('js/residentials/pagination.js') }}"></script>
    <script src="{{ url('js/validateInput.js') }}"></script>
    <script src="{{ url('js/showSaleText.js') }}"></script>
    <script src="{{ url('js/mobileAndTabletCheck.js') }}"></script>
    <script src="{{ url('js/residentials/jquery.mask.min.js') }}"></script>
    <script src="{{ url('js/addInputMask.js') }}"></script>
    <script>
        var price_range = [{{$apartmentRanges['minPrice']}}, {{$apartmentRanges['maxPrice']}}];
        var area_range = [{{$apartmentRanges['minArea']}}, {{$apartmentRanges['maxArea']}}];
    </script>
    <script>
        new Vue({
            el: '#residentials',
            data: {
                area_range: area_range,
                price_range: price_range,
                rooms: [],
                selectedPriceRange: [],
                selectedAreaRange: [],
                residentials: [],
                loading: false,
                totalApartments: 0,
                selectedLayoutIndex: -1,
                selectedLayout: [],
                requestSend: false,
                map: {
                    'show': false,
                    'geo_coords': [54.98, 82.89],
                    'container': ''
                },
                payments: {
                    'show': false,
                    'residential_index': 0,
                    'residential': {}
                },
                showLayoutsBtn: {
                    'text': {
                        'false': 'Показать квартиры',
                        'true': 'Скрыть квартиры'
                    },
                    'class': {
                        'false': '',
                        'true': 'property-developer-rc-right-button-hide'
                    }
                },
                isMobile: false,
                ga_popup_open_label: ga_popup_open_label
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.$refs.slider.refresh();
                });
            },
            updated: function () {
                if ($('.popup-apartment-phone .callibri_brn').length) {
                    document.querySelector('.popup-apartment-phone .callibri_brn').innerHTML = document.querySelector('.callibri_brn').innerHTML;
                }
            },
            computed: {
                allRoomCheckbox: function () {
                    return this.rooms.length === 0 ? 'checked' : null
                }
            },
            methods: {
                fetchResidentials: function () {
                    var url = this.$route;
                    var options = {
                        params: {
                            rooms: this.rooms,
                            area_range: this.area_range,
                            price_range: this.price_range
                        }
                    };
                    this.loading = true;
                    this.residentials = [];
                    this.$http
                        .get(url, options)
                        .then(function (response) {
                            this.residentials = response.data;
                            this.totalApartments = parseInt(response.headers.get('x-total-apartments'));
                            this.loading = false;
                        }, console.log)
                        .catch(function () {
                            setTimeout(this.fetchResidentials, 900);
                        });
                },
                checkAllRooms: function () {
                    if (!this.allRoomCheckbox) {
                        this.rooms = [];
                        //this.fetchLayouts(1);
                        return;
                    }
                    this.rooms = [];
                },
                closePopup: function () {
                    this.selectedLayoutIndex = -1;
                },
                selectLayout: function (layout, index) {
                    this.selectedLayout = layout;
                    this.selectedLayoutIndex = index;
                    ga('send', 'event', 'popup', 'open', this.ga_popup_open_label);
                    ga('send', 'event', 'popup', 'open', 'all-popup');
                },
                storeRequest: function (city) {
                    if ($('#client-phone').val() !== '') {
                        var url = window.location.protocol + '//' + window.location.hostname + '/' + city + '/requests';
                        var options = {
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            },
                            params: {
                                layout_id: this.selectedLayout.id,
                                client_phone: $('#client-phone').val(),
                                type: 1,
                                _token: window.Laravel.csrfToken
                            }
                        };
                        this.$http
                            .post(url, options['params'], options['headers'])
                            .then(function (response) {
                                if (response.data) {
                                    this.requestSend = true;
                                    setTimeout(this.toggleRequestSend, 10000);
                                } else {
                                    this.requestSend = false;
                                }
                            }, console.log)
                            .catch(function (error) {
                                console.log(error);
                                setTimeout(this.storeRequest(city), 1000);
                            });
                        ga('send', 'event', 'popup', 'price-info', this.ga_popup_open_label);
                        ga('send', 'event', 'popup', 'price-info', 'all-popup');
                        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('know_cost');
                    }
                },
                storePaymentsRequest: function (city) {
                    if ($('#client-phone').val() !== '') {
                        var url = window.location.protocol + '//' + window.location.hostname + '/' + city + '/requests';
                        var options = {
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            },
                            params: {
                                residential_complex_id: this.residentials[this.payments.residential_index].id,
                                client_phone: $('#client-phone').val(),
                                type: 4,
                                _token: window.Laravel.csrfToken
                            }
                        };
                        this.$http
                            .post(url, options['params'], options['headers'])
                            .then(function (response) {
                                if (response.data) {
                                    this.requestSend = true;
                                    setTimeout(this.toggleRequestSend, 10000);
                                } else {
                                    this.requestSend = false;
                                }
                            }, console.log)
                            .catch(function (error) {
                                console.log(error);
                                setTimeout(this.storeRequest, 1000);
                            });
                        ga('send', 'event', 'popup', 'payments-info', 'payments-request');
                        ga('send', 'event', 'popup', 'price-info', 'all-popup');
                    }
                },
                toggleRequestSend: function () {
                    this.requestSend = !this.requestSend;
                },
                showLayouts: function (residentialId) {
                    this.residentials.forEach(function (residential, index) {
                        if (residential.id !== residentialId) {
                            residential.showLayouts = false;
                        } else {
                            residential.showLayouts = !residential.showLayouts;
                        }
                    });
                },
                showMap: function (geo_coords) {
                    this.map.show = true;
                    //if (this.map.container == '') {
                    this.map.geo_coords = geo_coords;
                    function initMap() {
                        map = DG.map('map', {
                            'center': geo_coords,
                            'zoom': 16
                        });
                        DG.marker(geo_coords).addTo(map);
                    }

                    DG.then(setTimeout(initMap, 700));
                    //}
                },
                resetFilters: function () {
                    this.rooms = [];
                    this.area_range = area_range;
                    this.price_range = price_range;
                },
                showPayments: function (residentialIndex) {
                    this.payments.residential_index = residentialIndex;
                    this.payments.residential = this.residentials[this.payments.residential_index];
                    this.payments.show = true;
                    ga('send', 'event', 'popup', 'open', 'payment-methods');
                    ga('send', 'event', 'popup', 'open', 'all-popup');
                }
            },
            components: {
                'vueSlider': window['vue-slider-component']
            },
            created: function () {
                setTimeout(this.fetchResidentials, 700);
                this.isMobile = mobileAndTabletCheck();
            }
        });
    </script>
@endsection

@section('title', 'Все о наиболее популярных застройщиках города ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][1])

@section('content')
    <div class="container">
        <h1>{{ $developer->name }}</h1>
        <div class="developer-detail-box">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="property-developer-detail">
                        <div class="property-developer-detail-logo-wrapper">
                            <div class="property-developer-detail-logo">
                                <img src="{{ $developer->logo }}" alt="{{ $developer->name }}">
                            </div>
                        </div>
                        {{ $developer->text }}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="property-developer-number">
                        @php($developerResidentialCount = $developer->residentials->count())
                        <div class="property-developer-number-value">
                            {{ $developerResidentialCount }}
                        </div>
                        <div class="property-developer-number-description">
                            {!! number($developerResidentialCount, ['жилой</br>комплекс', 'жилых</br>комплекса', 'жилых</br>комплексов']) !!}
                        </div>
                        <div class="property-developer-number-notation">
                            в продаже
                        </div>
                        <img class="property-developer-number-image" src="/img/developer/icon-residential.png">
                        </img>
                    </div>
                    <div class="property-developer-number">
                        @php($developerResidentialHouseCount = $developer->residentials->sum(function ($residential) {return count($residential->houses);}) )
                        <div class="property-developer-number-value">
                            {{ $developerResidentialHouseCount }}
                        </div>
                        <div class="property-developer-number-description">
                            {!! number($developerResidentialHouseCount, ['дом</br>(секция)', 'дома</br>(секции)', 'домов</br>и секций']) !!}
                        </div>
                        <div class="property-developer-number-notation">
                            в продаже
                        </div>
                        <img class="property-developer-number-image" src="/img/developer/icon-house.png">
                        </img>
                    </div>
                    <div class="property-developer-number">
                        <div class="property-developer-number-value" style="font-size: 45px; display: block">
                            {{ $developer->apartments_count }}
                        </div>
                        <div class="property-developer-number-description">
                            {!! number($developer->apartments_count, ['квартира', 'квартиры', 'квартир']) !!}
                        </div>
                        <div class="property-developer-number-notation">
                            в продаже
                        </div>
                        <img class="property-developer-number-image" src="/img/developer/icon-door.png">
                        </img>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="residentials" data-ga-popup-open-label="{{ $gaLabel }}">
        <div class="container">
            <h2>Квартиры от застройщика «{{ $developer->name }}»</h2>
            {{--FILTERS--}}

            <div class="property-developer-search">
                <div class="row">
                    <div class="col-md-8 col-lg-9">
                        <div class="property-developer-search-filters">
                            <div class="property-developer-search-filters-rooms">
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="all-rooms" :checked="allRoomCheckbox" @click="checkAllRooms" @change="fetchResidentials">
                                        <label for="all-rooms">Все</label>
                                    </div>
                                </div>
                                @foreach($roomRanges as $range)
                                    <div class="property-developer-search-filters-rooms-item-wrapper">
                                        <div class="property-developer-search-filters-rooms-item">
                                            <input type="checkbox" id="room-{{ $range->rooms }}" name="rooms[]" value="{{$range->rooms}}"
                                                   v-model="rooms" @change="fetchResidentials">
                                            <label for="room-{{ $range->rooms }}">{{ $range->room_label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="property-developer-search-filters-sliders">
                                <div class="col-md-6">
                                    <div @click="fetchResidentials">
                                        <vue-slider
                                                ref="slider"
                                                v-model="area_range"
                                                min="{{ $apartmentRanges['minArea'] }}"
                                                max="{{ $apartmentRanges['maxArea'] }}"
                                                interval="1"
                                                height="10"
                                                @drag-end="fetchResidentials"
                                        >
                                            <template slot="tooltip" scope="tooltip">
                                                <div class="slider-tooltip">
                                                    @{{ tooltip.value }} м<sup>2</sup>
                                                </div>
                                            </template>
                                        </vue-slider>
                                    </div>
                                    <div class="property-developer-search-filters-sliders-legend">
                                        <div class="property-developer-search-filters-sliders-legend-left">{{ $apartmentRanges['minArea'] }} м<sup>2</sup></div>
                                        <div class="property-developer-search-filters-sliders-legend-center">площадь</div>
                                        <div class="property-developer-search-filters-sliders-legend-right">{{ $apartmentRanges['maxArea'] }} м<sup>2</sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div @click="fetchResidentials">
                                        <vue-slider
                                                ref="slider"
                                                v-model="price_range"
                                                min="{{ $apartmentRanges['minPrice'] }}"
                                                max="{{ $apartmentRanges['maxPrice'] }}"
                                                interval="10000"
                                                height="10"
                                                @drag-end="fetchResidentials"
                                        >
                                            <template slot="tooltip" scope="tooltip">
                                                <div class="slider-tooltip">
                                                    @{{ tooltip.value }} р.
                                                </div>
                                            </template>
                                        </vue-slider>
                                    </div>
                                    <div class="property-developer-search-filters-sliders-legend">
                                        <div class="property-developer-search-filters-sliders-legend-left">{{ $apartmentRanges['minPrice'] }} р.</div>
                                        <div class="property-developer-search-filters-sliders-legend-center">цена</div>
                                        <div class="property-developer-search-filters-sliders-legend-right">{{ $apartmentRanges['maxPrice'] }} р.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="property-developer-search-result">
                            <div class="property-developer-search-result-head">
                                результаты поиска
                            </div>
                            <div class="property-developer-search-result-value">
                                <span class="property-developer-search-result-value-number">
                                    @{{ totalApartments }}
                                </span>
                                <span class="property-developer-search-result-value-description">
                                    подходящих</br>квартир
                                </span>
                            </div>
                            <div class="property-developer-search-result-button">
                                <div class="property-developer-search-result-button-left">
                                    <button @click="resetFilters(); fetchResidentials()">Сбросить фильтры</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{--RESIDENTIALS--}}

            {{--@foreach($developer->residentials as $residential)--}}
            <div v-for="(residential, index) in residentials" class="property-developer-rc" v-if="residential.apartments.length">
                <div class="property-developer-rc-block">
                    <div class="row">
                        <div class="col-md-8 col-lg-9">
                            <div class="property-developer-rc-left" style="background-image: url(@{{ residential.main_image }})">
                                <div class="property-developer-rc-left-content">
                                    <div class="property-developer-rc-title">
                                        <h3>@{{ residential.title }}</h3>
                                        <div class="property-developer-rc-info">
                                            <div class="property-developer-rc-info-item">
                                                <img src="/img/developer/icon-map.png">
                                                <div class="property-developer-rc-info-item-text">
                                                    <div class="property-developer-rc-info-item-title">
                                                        Район
                                                    </div>
                                                    <div class="property-developer-rc-info-item-description">
                                                        @{{ residential.district.name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property-developer-rc-info-item">
                                                <img src="/img/developer/icon-calendar.png">
                                                <div class="property-developer-rc-info-item-text">
                                                    <div class="property-developer-rc-info-item-title">
                                                        Срок сдачи от
                                                    </div>
                                                    <div class="property-developer-rc-info-item-description">
                                                        @{{ residential.completion_date }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="property-developer-rc-actions">
                                        <a @click="showPayments(index)">Способы оплаты</a>
                                        <a @click="showMap([residential.latitude, residential.longitude])">Посмотреть на карте</a>
                                        <a :href="residential.routeShow" target="_blank">Подробнее о ЖК</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="property-developer-rc-right">
                                <div class="property-developer-rc-apartments-amount-value">
                                    <div class="property-developer-rc-apartments-amount">
                                        @{{ residential.apartments.length }}
                                    </div>
                                    <div class="property-developer-rc-apartments-description">
                                        вариантов</br>квартир
                                    </div>
                                </div>
                                <table>
                                    <thead>
                                    <tr>
                                        <td>Комнаты</td>
                                        <td>Цена от</td>
                                        <td>Кол-во</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="range in residential.mergedRanges">
                                        <td>@{{ range.room_label }}</td>
                                        <td>@{{ range.price_min }}</td>
                                        <td>@{{ range.apartments_count }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="property-developer-rc-right-button-wrapper">
                                    <div
                                            class="property-developer-rc-right-button"
                                            :class="showLayoutsBtn.class[residential.showLayouts]"
                                            @click="showLayouts(residential.id)"
                                    ><span>@{{ showLayoutsBtn.text[residential.showLayouts] }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="property-developer-rc-apartments" v-if="residential.showLayouts">
                    <div id="search-new-layout-flats" class="list-view">
                        <div class="row">
                            @include('layouts.card', ['layoutsData' => 'residential.layouts'])
                        </div>
                        <div class="property-developer-rc-hide">
                            <div class="property-developer-rc-hide-wrapper" @click="showLayouts(residential.id)"><span>Скрыть квартиры</span></div>
                        </div>
                    </div>
                </div>
            </div>
            {{--@endforeach--}}
        </div>
        @include('layouts.'.$popupType)
        @include('developers.popup-map')
        @include('developers.popup-payments')
    </section>
@endsection