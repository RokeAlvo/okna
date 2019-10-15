@extends('v2.templates.main') 
@section('head-scripts')
<script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
@endsection
 
@section('footer-scripts')
<script src="{{ url('js/vue.js') }}"></script>
<script src="{{ url('js/vue-resource.js') }}"></script>
<script src="{{ url('js/vue-slider-component.js') }}"></script>
<script src="{{ url('js/residentials/pagination.js') }}"></script>
<script src="{{ url('js/mobileAndTabletCheck.js') }}"></script>
<script src="{{ url('js/validateInput.js') }}"></script>
<script src="{{ url('js/showSaleText.js') }}"></script>
<script src="{{ url('js/residentials/jquery.mask.min.js') }}"></script>
<script src="{{ url('js/addInputMask.js') }}"></script>
<script src="{{ url('/v2/js/accordion.js')}}"></script>
<script src="{{ url('/v2/js/residentials/jquery.mask.min.js') }}"></script>
<script src="{{ url('/v2/js/residentials/sticky-menu.js') }}"></script>
<script src="{{ url('/v2/js/mobileAndTabletCheck.js') }}"></script>
<script src="{{ url('/v2/js/jquery.collapser.min.js')}}"></script>


<script>
    var price_range = [{{$apartmentRanges['minPrice']}}, {{$apartmentRanges['maxPrice']}}];
        var area_range = [{{$apartmentRanges['minArea']}}, {{$apartmentRanges['maxArea']}}];
        var ga_popup_open_label = '{{$gaLabel}}';

</script>

<script type="text/x-template" id="tab-one">
    <div>
        <div class="tab-content" id="tab-1-content">
            <div class="tab-phone"><a class="main-phone" href="tel:+70000000000">+7 (000) 000-XX-XX</a></div>

            <div class="tab-phone-button" ref="tabPhoneButton" @click="showWorkTime">Показать номер</div>
            <div class="work-time-wrapper">
                <div class="work-time-icon">
                    <img src="/img/clock-gray.png">
                </div>
                <div class="work-time">
                    <div class="work-time-title">Режим работы:</div>
                    <div class="work-time-data">Ежедневно с 9:00 до 20:00</div>
                </div>
            </div>

        </div>
    </div>
</script>

<script type="text/x-template" id="tab-two">
    <div>
        <div class="price-number-wrapper">

            <div class="number-send" v-if="!requestSend">
                <div class="number-placeholder">
                    <input type="text" name="client_phone" id="client-phone" onclick="addInputMask(this)" placeholder="+7 (XXX) XXX-XX-XX">
                </div>
                <div class="number-button" @click.prevent="callbackStoreRequest('{{ getUrlPathFirstPart() }}')">
                    Отправить
                </div>
            </div>
            <div class="popup-apartment-form-success" v-else>
                <span>Спасибо за обращение!</span> с Вами свяжутся в течении 5 минут.
            </div>
            <div class="popup-apartment-specifications-title confidential-policy d-none d-md-block">
                Нажимая на кнопку "Отправить" Вы соглашаетесь с<br>
                <a href="/oferta.pdf" target="_blank">политикой конфиденциальности</a>
            </div>
        </div>

    </div>
</script>


<script>
    var TabPhone = {
            template: '#tab-one',
            methods: {
                showWorkTime: function () {
                    $(this.$refs.tabPhoneButton).css('display', 'none');
                    $('.work-time-wrapper').css('display', 'flex');
                    $('.tab-phone .main-phone').html($('.tab-phone .main-phone').attr('data-tel'));
                }
            }
        };
        var TabCallback = {
            template: '#tab-two',
            props: ['requestSend'],
            methods: {
                callbackStoreRequest: function (city) {
                    //this.$parent.$options.methods.storeRequest(city);
                    this.$parent.$emit('store-request', city);
                }
            }
        };

        new Vue({
            el: '#residentials',
            data: {
                // isActiveClass: false,
                area_range: area_range,
                price_range: price_range,
                rooms: [],
                selectedPriceRange: [],
                selectedAreaRange: [],
                selectedResidentials: [],
                <?php echo 'residentials: ' . $developer->residentials->toJson() . ',' ?>
                selectedResidentialIds: [],
                loading: false,
                totalApartments: 0,
                selectedLayoutIndex: -1,
                selectedLayout: [],
                selectedLayoutsCount: 0,
                selectedLayoutResidential: {},
                selectedLayoutImageHeight: 0,
                selectedLayoutImageResize: false,
                selectedLayoutImageUpsized: false,
                selectedLayoutImage: {},
                requestSend: false,
                mapResidential: {},
                ranges: [],
                room_labels: [],
                tabs: [['phone', 'Отдел продаж'], ['callback', 'Заказать обратный звонок']],
                currentTab: ['phone', 'Отдел продаж'],

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
            /* mounted: function () {
                this.$nextTick(function () {
                    this.$refs.slider.refresh();
                });
            }, */

            computed: {
                allRoomCheckbox: function () {
                    return this.rooms.length === 0 ? 'checked' : null
                },
                allRcCheckbox: function () {
                    return this.selectedResidentialIds.length === 0 ? 'checked' : null
                },
                currentTabComponent: function () {
                    return 'tab-' + this.currentTab[0].toLowerCase();
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
                checkAllRc: function () {
                    if (!this.allRcCheckbox) {
                        this.selectedResidentialIds = [];
                        //this.fetchLayouts(1);
                        return;
                    }
                    this.selectedResidentialIds = [];
                },
                filterLayouts: function () {
                    // console.log(this.residentials[0]);
                    // console.log(this.rooms);
                    this.selectedLayoutsCount = 0;
                    this.selectedResidentials = this.residentials.map(function (residential) {
                        residential.selectedLayouts = residential.layouts;
                        this.selectedLayoutsCount += residential.selectedLayouts.length;
                        return residential;
                    }.bind(this));
                    if (this.selectedResidentialIds.length) {
                        this.selectedResidentials = this.residentials.filter(function (residential) {
                            return this.selectedResidentialIds.indexOf(residential.id) != -1;
                        }.bind(this));
                    }
                    if (this.rooms.length) {
                        this.selectedLayoutsCount = 0;
                        this.selectedResidentials = this.selectedResidentials.map(function (residential) {
                            residential.selectedLayouts = residential.layouts.filter(function (layout) {
                                return this.rooms.indexOf(layout.merge_rooms) != -1;
                            }.bind(this));
                            this.selectedLayoutsCount += residential.selectedLayouts.length;

                            return residential;
                        }.bind(this));
                        
                    }
                    this.room_labels = this.ranges.filter(function (range) {
                        return this.rooms.indexOf(range.rooms+'') !== -1;
                    }.bind(this)).map(function(range){
                        return range.room_label;
                    })

                },
                filterRanges: function () {
                    this.ranges = [];
                    this.selectedResidentials.map(function (residential) {
                        Object.values(residential.mergedRanges).map(function (range) {
                            this.ranges = this.ranges.concat(range);
                            return range;
                        }.bind(this));
                        return residential;
                    }.bind(this));


                    this.ranges = Object.values(this.ranges.reduce((newRanges, range) => Object.assign(newRanges, {[range.rooms]: (newRanges[range.rooms] || []).concat(range)}), {}));

                    this.ranges = this.ranges.map(function (roomsGroup) {
                        var index_min_price = 0;
                        roomsGroup.map(function (range, index) {
                            if (range.price_min < roomsGroup[index_min_price].price_min) {
                                index_min_price = index;
                            }
                        });
                        return roomsGroup[index_min_price];
                    });
                    this.rooms = this.rooms.filter(function (n) {
                        return this.ranges.map(range => range.rooms + '').indexOf(n) !== -1;
                    }.bind(this));
                    // console.log(this.selectedLayoutResidential);
                },
                filterLayoutsRanges: function () {
                    this.filterLayouts();
                    this.filterRanges();
                    this.filterLayouts();
                },
                numberFormat: function (number) {
                    return String(number).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
                },
                increasePopupImage: function () {
                    $('.plan-image-box .main-popup-img').css('max-height', '100%').css('max-width', '100%').height(this.selectedLayoutImageHeight).height(this.selectedLayoutImageWidth);
                    this.selectedLayoutImageUpsized = true;
                },
                decreasePopupImage: function () {
                    $('.plan-image-box .main-popup-img').css('max-height', '100%').height('35vh');
                    this.selectedLayoutImageUpsized = false;
                },
                closePopup: function () {
                    this.selectedLayoutIndex = -1;
                    this.selectedLayoutImageHeight = 0;
                    this.selectedLayoutImageResize = false;
                    this.selectedLayoutImageUpsized = false;
                    $('body').css('overflow', 'auto');
                },
                selectLayout: function (layout, index) {
                    this.selectedLayout = layout;
                    this.selectedLayoutIndex = index;
                    $('body').css('overflow', 'hidden');
                    @if(app()->environment('production'))
                    ga('send', 'event', 'popup', 'open', this.ga_popup_open_label);
                    ga('send', 'event', 'popup', 'open', 'all-popup');
                    @endif
                    //reachGoal(this.ga_popup_open_label);

                    var selectResidentialIndex = 0;
                    this.residentials.map(function (residential, index) {
                        residential.layouts.map(function (layout) {
                            if(layout.id === this.selectedLayout.id) {
                                selectResidentialIndex = index;
                            }
                        }.bind(this));
                    }.bind(this));
                    this.selectedLayoutResidential = this.residentials[selectResidentialIndex];
                    // console.log(this.selectedLayoutResidential);

                    setTimeout(function () {
                        this.selectedLayoutImageHeight = $('.plan-image-box .main-popup-img').prop('naturalHeight');
                        if (this.selectedLayoutImageHeight >= (35 / 100) * $(window).height()) {
                            // $('.plan-image-box .main-popup-img').height('35vh');
                            this.selectedLayoutImageResize = true;
                            this.selectedLayoutImageUpsized = false;
                        }

                        accordion($(".popup .accordion"));
                    }.bind(this), 400);
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
                        @if(app()->environment('production'))
                        ga('send', 'event', 'popup', 'price-info', this.ga_popup_open_label);
                        ga('send', 'event', 'popup', 'price-info', 'all-popup');
                        @endif
                        @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('know_cost');
                        @endif
                        //reachGoal(this.ga_popup_open_label);
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
                // ---
                showMap: function (residential) {
                    this.mapResidential = residential;
                    
                    this.map.show = true;
                    $('body').css('overflow', 'hidden');
                    //if (this.map.container == '') {
                    this.map.geo_coords = [residential.latitude, residential.longitude];
                    

                    function initMap() {
                        map = DG.map('map', {
                            'center': this.map.geo_coords,
                            'zoom': 16,
                            'boxZoom': false,
                            'zoomControl': false,
                        });

                        myIcon = DG.icon({
                            iconUrl: '/img/developer/baloon-home-gray.png',
                            iconAnchor: [27.5, 70],
                            iconSize: [55, 70]
                            // iconAnchor: [22, 94],
                        });

                        DG.marker(this.map.geo_coords, {icon: myIcon}).addTo(map);
                    }


                    DG.then(setTimeout(initMap.bind(this), 700));
                    //}
                },
                closeMap: function(){
                     this.map.show = false;
                     $('body').css('overflow', 'auto');
                },
                resetFilters: function () {
                    this.rooms = [];
                    this.area_range = area_range;
                    this.price_range = price_range;
                },
                // ---
                showPayments: function (residentialIndex) {
                    this.payments.residential_index = residentialIndex;
                    this.payments.residential = this.residentials[this.payments.residential_index];
                    this.payments.show = true;
                    ga('send', 'event', 'popup', 'open', 'payment-methods');
                    ga('send', 'event', 'popup', 'open', 'all-popup');
                },
                phoneChange: function () {
                    var phone = $('.phone-top-menu .main-phone').first().text();
                    var tel = $('.phone-top-menu .main-phone').first().text().replace(/[^0-9]/gi, '');
                    $('.phone-number .main-phone').attr("href", 'tel:+' + tel);
                    if ($('.popup-phone-box .main-phone').length) {
                        $('.popup-phone-box .main-phone').html(phone);
                        $('.popup-phone-box .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.rooms-box .main-phone').length) {
                        // $('.rooms-box .main-phone').html(phone)
                        $('.rooms-box .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.popup-apartment-phone .main-phone').length) {
                        $('.popup-apartment-phone .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.tab-phone .main-phone').length) {
                        if ($(this.$refs.tabPhoneButton).length) {
                            $('.tab-phone .main-phone').html(phone.substr(0, 13) + 'XX-XX');
                        }
                        $('.tab-phone .main-phone').attr("href", 'tel:+' + tel);
                        $('.tab-phone .main-phone').attr("data-tel", phone);
                    }
                    if ($('.call-self .main-phone').length) {
                        $('.call-self .main-phone').html(phone);
                        $('.call-self .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.m-call-button .main-phone').length) {
                        $('.m-call-button .main-phone').attr("href", 'tel:+' + tel);
                    }
                },
                rcBackgroundClass: function (image) {
                    return {
                        //    background: 'linear-gradient(192.24deg, rgba(85, 108, 154, 0) 28.47%, #556C9A 81.82%), url(' + image + ')',
                        background: 'url(' + image + ') center center no-repeat',
                        'background-size': 'cover'
                    }
                },
                rcOneBackgroundClass: function (image) {
                    return {
                        background: 'linear-gradient(192.21deg, rgba(85, 108, 154, 0) 28.47%, rgba(85, 108, 154, 0.8) 77.47%), url(' + image + ') center center no-repeat',
                        'background-size': 'cover'
                    }
                }
                // hideGrayScale: function(){
                //     this.isActiveClass = !this.isActiveClass;
                // }
            },
            components: {
                'vueSlider': window['vue-slider-component'],
                'tab-phone': TabPhone,
                'tab-callback': TabCallback
            },
            created: function () {
                setTimeout(this.phoneChange(), 3000);
                this.filterLayouts();
                // setTimeout(this.fetchResidentials, 700);
                this.isMobile = mobileAndTabletCheck();
                this.filterRanges();
                
            },
            updated: function () {
                setTimeout(this.phoneChange(), 3000);
                // if (this.map.show == false) $('body').css('overflow', 'auto');
            }
        });

        if ($(window).width() < 600) {
            $('.property-developer-text').first().addClass('text-more-down');
        }
        $('.text-more-down').collapser({
            mode: 'lines',
            truncate: 15,
            showText: '<div class="text-more-down-button">Подробнее..</div>',
            hideText: '<div class="text-more-down-button">Скрыть..</div>',
        });

</script>
@endsection
 
@section('title', 'Все о наиболее популярных застройщиках города ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][1])

@section('content')

<div class="container padding-for-menu d-none d-md-block">
    <div class="bread-crumbs-wrapper">
        <a class="bread-crumbs" href="{{ url(getUrlPathFirstPart() . '/') }}">Главная</a>/
        <a class="bread-crumbs" href="{{ route('developers.index') }}">Застройщики</a>/
        <span class="bread-crumbs bread-end">ГК «{{ $developer->name }}»</span>
    </div>
</div>
<div class="container padding-for-menu d-block d-md-none">
    <div class="mob-property-logo">
        <img src="{{ $developer->logo }}" alt="{{ $developer->name }}">
    </div>
</div>

<div class="container">

    <div class="developer-detail-box">
        {{--
        <div class="developer-info-box"> --}}
            <div class="property-developer-text-wrapper">
                <h1 class="main-title-developer">{{ $developer->name }}</h1>
                <div class="property-developer-text">
                    {!! $developer->text !!} {{--
                    <div @click="" class="hide-text-dev">Подробне...</div>--}}
                </div>
            </div>

            {{--
            <div class="property-developer-wrapper"> --}}
                <div class="property-developer-wrapper-box">
                    <div class="property-developer d-none d-md-block" {{-- d-none d-md-block --}}>
                        <div class="property-developer-padding">
                            <div class="property-logo">
                                <img src="{{ $developer->logo }}" alt="{{ $developer->name }}">
                            </div>
                        </div>
                    </div>
                    <?php
                $howYears = now()->year - $developer->founding_year;
                ?>
                        @if(!empty($developer->founding_year))
                        <div class="property-developer">
                            <div class="property-developer-padding">
                                <div class="property-developer-up">{{ $howYears }} {{ number($howYears, ['год', 'года', 'лет']) }}</div>
                                <div class="property-developer-down">на рынке</div>
                                <img class="d-block d-md-none img-ok" src="/img/developer/ok-gray.svg">
                            </div>
                        </div>
                        @endif @if(!empty($developer->completes_on_time))
                        <div class="property-developer">
                            <div class="property-developer-padding">
                                <div class="property-developer-up">Сдает в срок</div>
                                <div class="property-developer-down">100% объектов</div>
                                <img class="d-block d-md-none img-ok" src="/img/developer/ok-gray.svg">
                            </div>
                        </div>
                        @endif @if(!empty($developer->objects_built))
                        <div class="property-developer">
                            <div class="property-developer-padding">
                                <div class="property-developer-up">
                                    {{$developer->objects_built}} {{ number($developer->objects_built, ['объект', 'объекта', 'объектов']) }}
                                </div>
                                <div class="property-developer-down">Уже построены</div>
                                <img class="d-block d-md-none img-ok" src="/img/developer/ok-gray.svg">
                            </div>
                        </div>
                        @endif @if(!empty($developer->urban_award_years))
                        <div class="property-developer property-developer-awards">
                            <div class="property-developer-padding pad-left-reward">
                                <img class="reward-img" src="/img/developer/win.jpg">
                                <div class="winner-year-wrapper">
                                    <div class="property-developer-up"> Призер <br class="winner-return">«Urban awards»</div>
                                    <div class="property-developer-down">в {{ implode(', ',json_decode($developer->urban_award_years))}} году</div>
                                </div>
                                <div class="info-question">
                                    <img src="/img/info-q.png">
                                </div>
                            </div>
                        </div>
                        @endif
                </div>
            </div>
        </div>
        <section id="residentials" data-ga-popup-open-label="{{ $gaLabel }}">

            <div class="container">

                @if($developer->residentials->count() == 1) {{-- if residential complex 1 --}}
                <div class="sk-fading-circle" v-if="loading">
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
                <div class="one-rc-developer-wrapper">

                    <div v-for="(residential, index) in residentials" class="one-choose-rc" :style="rcOneBackgroundClass(residential.search_image)">
                        <div class="one-main-info-rc-wrapper">
                            <div class="titleone-rc">Жилой комплекс</div>
                            <div class="one-name-info-rc">@{{ residential.title }}</div>
                            <div class="one-data-info-rc-wrapper">
                                <div class="one-data-info-rc">
                                    <div class="one-icon-info-rc"><img src="/img/baloon-map-white.svg"></div>
                                    <div class="one-info-rc">@{{ residential.address }}</div>
                                </div>
                                <div class="one-data-info-rc">
                                    <div class="one-icon-info-rc"><img src="/img/calendar-white.svg"></div>
                                    <div class="one-info-rc">@{{ residential.completion_date }}</div>
                                </div>
                            </div>
                            <div class="one-tooltip-rc" @click="showMap(residential)">i</div>
                        </div>
                    </div>

                    <h2 class="one-rc-apartaments-title-m">Подберите <br>себе квартиру</h2>
                    <div v-for="(residential, index) in residentials" class="one-choose-rc-m" :style="rcBackgroundClass(residential.search_image)">
                    </div>
                    <div v-for="(residential, index) in residentials" class="one-rc-info-wrapper-m">
                        <div class="one-main-info-rc-wrapper-m">
                            <div class="one-name-info-rc-title-m">@{{ residential.title }}</div>
                            <div class="one-data-info-rc-wrapper-m">
                                <div class="data-info-rc-m">
                                    <div class="icon-info-rc-m"><img src="/img/developer/rub-black.svg"></div>
                                    <div class="info-rc-m">@{{ residential.address }}</div>
                                </div>
                                <div class="data-info-rc-m">
                                    <div class="icon-info-rc-m"><img src="/img/developer/baloon-black.svg"></div>
                                    <div class="info-rc-m">@{{ residential.address }}</div>
                                </div>
                                <div class="data-info-rc-m">
                                    <div class="icon-info-rc-m"><img src="/img/developer/calendar-black.svg"></div>
                                    <div class="info-rc-m">@{{ residential.completion_date }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="button-more-info-rc" @click="showMap(residential)">Подробнее о ЖК</div>
                    </div>

                    <div class="rc-one-choose-number-rooms-wrapper">
                        <h2 class="choose-apartment-title one-choose-apartment-title">Подберите<br> себе квартиру</h2>
                        <div class="one-number-rooms-developer-wrapper-all">
                            <div class="one-number-rooms-developer-box">
                                <input class="input-number-rooms" type="checkbox" id="input-number-rooms0" :checked="allRoomCheckbox" @click="checkAllRooms"
                                    @change="filterLayouts">
                                <label class="one-label-number-rooms" for="input-number-rooms0">
                                        <div class="one-number-rooms-developer-wrapper">
                                            <div class="number-rooms-developer-title">Все</div>
                                            <div class="info-number-rooms-developer">от @{{ numberFormat(ranges[0].price_min) }} руб.</div>
                                            <div class="info-number-rooms-developer">от @{{ (+(ranges[0].area_min)).toFixed(0) }} м<sup>2</sup></div>
                                        </div>
                                    </label>
                            </div>

                            <template v-for="range in ranges">
                                    <div class="one-number-rooms-developer-box">
                                        <input class="input-number-rooms" type="checkbox" :id="'room-' + range.rooms" name="rooms[]" :value="range.rooms +''"
                                               v-model="rooms" @change="filterLayouts">
                                        <label class="one-label-number-rooms" :for="'room-' + range.rooms">
                                            <div class="one-number-rooms-developer-wrapper">
                                                <div class="number-rooms-developer-title">@{{ range.room_label }}</div>
                                                <div class="info-number-rooms-developer">от @{{ numberFormat(range.price_min) }} руб.</div>
                                                <div class="info-number-rooms-developer">от @{{  (+(range.area_min)).toFixed(0) }} м<sup>2</sup></div>
                                            </div>
                                        </label>
                                    </div>
                                </template>
                        </div>

                    </div>



                </div>
                <div class="gradient-filter-number-dev">
                    <div class="wrapper-filter-numbers-rc1">
                        <input type="checkbox" class="choose-input" id="choose-rooms">
                        <label for="choose-rooms" class="choose-label" @click="$('.all-number-button-dev-m-rc1').slideToggle(200)">
                                    <div class="choose-number-rooms">
                                        <div id="block-choose" class="number-rooms-m">
                                            <span class="choose-pre-text" v-if="room_labels.length">Выбрано:&nbsp;</span>
                                            @{{ room_labels.length ? room_labels.join(', ') : 'Выберите кол-во комнат'}}
                                        </div>
                                        <div class="options-img-wrapper"></div>
                                    </div>
                                </label>
                        <div class="all-number-button-dev-m-rc1">
                            <input class="rooms_decoration_checkbox-m d-none" type="checkbox" id="input-number-rooms0" :checked="allRoomCheckbox" @click="checkAllRooms"
                                @change="filterLayouts">
                            <label class="rooms-decoration-box-m d-md-none" for="input-number-rooms0">
                                                        <div class="number-of-rooms-decoration-m">Все</div>
                                                </label>

                            <template v-for="range in ranges">
                                                    <input class="d-none rooms_decoration_checkbox-m" type="checkbox" :id="'room-' + range.rooms" name="rooms[]" :value="range.rooms +''"
                                                           v-model="rooms" @change="filterLayouts">
                                                    <label class="rooms-decoration-box-m" :for="'room-' + range.rooms">
                                                            <div class="number-of-rooms-decoration-m">@{{ range.room_label }}</div>
                                                    </label>
                                            </template>
                        </div>
                    </div>
                </div>

                <div class="all-rooms-developers-rcs" id="search-new-layout-flats">
                    <template v-for="(residential, index) in selectedResidentials">
    @include('v2.layouts.card-rc-one', ['layoutsData' => 'residential.selectedLayouts'])
                    </template>
                </div>


                {{-- if residential complex 1 end--}} @else
                <div class="choose-mob-wrapper">

                    <h2 class="choose-apartment-title">Подберите себе квартиру</h2>
                    <div class="sk-fading-circle" v-if="loading">
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



                    <div class="choose-rc-wrapper">

                        <div class="static-number-rc-wrapper">
                            <input class="input-number-rc" type="checkbox" id="input-number-rc0" :checked="allRcCheckbox" disabled {{--@click="checkAllRc"
                                @change="filterLayouts" --}}>
                            <label class="label-number-rc" for="input-number-rc0">
                          <div class="static-number-rc">
                              <div class="number-rc-choose">1</div>
                              <div class="choose-rc-title">Выберите жилой комплекс</div>
                              <div class="static-rc-triangle"></div>
                          </div>
                      </label>
                        </div>
                        <div class="mob-text-static-choose-rc d-block d-md-none">1.&#8195;Выберите ЖК</div>
                        <div class="dynamic-choose-rc-wrapper">
                            <div v-for="(residential, index) in residentials" v-once class="dynamic-choose-rc-box" v-cloak>
                                <div class="dynamic-choose-rc-box-tooltip" style="position:relative">
                                    <div class="tooltip-rc" @click="showMap(residential)">i</div>
                                    <input @change="filterLayoutsRanges" class="choose-rc-input" type="checkbox" :id="'choose-rc-' + index" :value="residential.id"
                                        v-model="selectedResidentialIds" name="rc-list">
                                    <label class="choose-rc-label" :for="'choose-rc-' + index">
                                    <div  class="dynamic-choose-rc">
                                        <div  class="gradient-background">
                                            <div class="main-info-rc-wrapper">
                                                <div class="name-info-rc">@{{ residential.title }}</div>
                                                <div class="data-info-rc-wrapper">
                                                    <div class="data-info-rc dis-none">
                                                        <div class="icon-info-rc"><img src="/img/developer/rub-white.svg"></div>
                                                        <div class="info-rc">от @{{ numberFormat(residential.price_min) }} руб.</div>
                                                    </div>
                                                    <div class="data-info-rc">
                                                        <div class="icon-info-rc"><img src="/img/baloon-map-white.svg"></div>
                                                        <div class="info-rc">@{{ residential.address }}</div>
                                                    </div>
                                                    <div class="data-info-rc">
                                                        <div class="icon-info-rc"><img src="/img/calendar-white.svg"></div>
                                                        <div class="info-rc">@{{ residential.completion_date }}</div>
                                                    </div>
                                                </div>

                                                <div class="checked-button"><img src="/img/developer/ok-green.svg">Выбран{{--<span class="mob-letter-o">о</span>--}}</div>
                                            </div>

                                        </div>
                                        <div class="image-background" :style="rcBackgroundClass(residential.search_image)"></div
                                        >
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="choose-number-rooms-wrapper">
                        <div class="static-number-rooms-wrapper">
                            <input class="input-number-rooms" type="checkbox" id="input-number-rooms0" :checked="allRoomCheckbox" disabled {{--@click="checkAllRooms"
                                @change="filterLayouts" --}}>
                            <label class="label-number-rooms" for="input-number-rooms0">
                                
                                <div class="static-number-rooms">
                                    <div class="number-rooms-choose">2</div>
                                    <div class="choose-number-title">Выберите<br> кол-во комнат</div>
                                    <div class="static-number-triangle"></div>
                                </div>
                            </label>
                        </div>


                        <div class="number-rooms-developer-wrapper-all">
                            <div class="number-rooms-developer-box d-block d-md-none">
                                <input class="input-number-rooms" type="checkbox" id="input-number-rooms0" :checked="allRoomCheckbox" @click="checkAllRooms"
                                    @change="filterLayouts">
                                <label class="label-number-rooms" for="input-number-rooms0">
                                    <div class="number-rooms-developer-wrapper">
                                        <div class="number-rooms-developer-title">Все</div>
                                     
                                    </div>
                                </label>
                            </div>
                            <template v-for="range in ranges">
                                <div class="number-rooms-developer-box">
                                    <input class="input-number-rooms" type="checkbox" :id="'room-' + range.rooms" name="rooms[]" :value="range.rooms +''"
                                           v-model="rooms" @change="filterLayouts">
                                    <label class="label-number-rooms" :for="'room-' + range.rooms">
                                        <div class="number-rooms-developer-wrapper">
                                            <div class="number-rooms-developer-title">@{{ range.room_label }}</div>
                                            <div class="info-number-rooms-developer">от @{{ numberFormat(range.price_min) }} руб.</div>
                                            <div class="info-number-rooms-developer">от @{{  (+(range.area_min)).toFixed(0) }} м<sup>2</sup></div>
                                        </div>
                                    </label>
                                </div>
                            </template>
                        </div>


                    </div>

                    {{-- for Mobile--}} {{--
                    <div class="gradient-filter-number"> --}}
                        <div class="wrapper-filter-numbers-dev">
                            <div class="mob-text-static-choose-rc">2.&#8195;Выберите кол-во комнат</div>
                            {{-- <input type="checkbox" class="choose-input" id="choose-rooms">
                            <label for="choose-rooms" class="choose-label" @click="$('.all-number-button-wrapper').slideToggle(200)">
                                    <div class="choose-number-rooms">
                                        <div id="block-choose" class="number-rooms-m">
                                            <span class="choose-pre-text" v-if="roomLabels.length">Выбрано:&nbsp;</span>
                                            @{{ roomLabels.length ? roomLabels.join(', ') : 'Выберите кол-во комнат'}}
                                        </div>
                                        <div class="options-img-wrapper"></div>
                                    </div>
                                </label>--}}
                            <div class="all-number-button-dev-m">
                                <input class="rooms_decoration_checkbox-m d-none" type="checkbox" id="input-number-rooms0" :checked="allRoomCheckbox" {{----}}@click="checkAllRooms"
                                    @change="filterLayouts">
                                <label class="rooms-decoration-box-m d-md-none" for="input-number-rooms0">
                                                        <div class="number-of-rooms-decoration-m">Все</div>
                                                </label>

                                <template v-for="range in ranges">
                                                    <input class="d-none rooms_decoration_checkbox-m" type="checkbox" :checked="allRoomCheckbox" :id="'room-' + range.rooms" name="rooms[]" :value="range.rooms +''"
                                                           v-model="rooms" @change="filterLayouts">
                                                    <label class="rooms-decoration-box-m" :for="'room-' + range.rooms">
                                                            <div class="number-of-rooms-decoration-m">@{{ range.room_label }}</div>
                                                    </label>
                                            </template>
                            </div>
                            <div class="count-layouts-wrapper" v-cloak>
                                <div class="count-layouts">@{{selectedLayoutsCount}}</div>
                                <div class="count-layouts-text">Найдено вариантов планировок</div>
                            </div>
                        </div>


                        {{--</div>--}}
                </div>


                <div class="all-rooms-developers-rcs" id="search-new-layout-flats">
                    <template v-for="(residential, index) in selectedResidentials">
    @include('v2.layouts.card', ['layoutsData' => 'residential.selectedLayouts'])
                        {{--
    @include('v2.layouts.card-many-developer', ['layoutsData' => 'residential.selectedLayouts']) --}}
                    </template>
                </div>
                @endif
            </div>


            {{--@endforeach--}}
    @include('v2.developers.popup-map') {{--
    @include('v2.developers.popup-payments') --}}
    @include('v2.layouts.'.$popupType)
        </section>
@endsection