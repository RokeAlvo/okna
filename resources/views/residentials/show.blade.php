@extends('templates.main')

@section('head-scripts')
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
@endsection

@section('footer-scripts')
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/vue-resource.js') }}"></script>
    <script src="{{ url('js/residentials/jquery.mask.min.js') }}"></script>
    <script src="{{ url('js/residentials/pagination.js') }}"></script>
    <script src="{{ url('js/popup.js') }}"></script>
    <script src="{{ url('js/residentials/apartment-tooltip.js') }}"></script>
    <script src="{{ url('js/validateInput.js') }}"></script>
    <script src="{{ url('js/showSaleText.js') }}"></script>
    <script src="{{ url('js/mobileAndTabletCheck.js') }}"></script>
    <script src="{{ url('js/addInputMask.js') }}"></script>
    <script src="{{ url('js/residentials/sticky-menu.js') }}"></script>
    <script>
        new Vue({
            el: '#layouts-vue',
            data: {
                fetching: false,
                fetchingMobile: false,
                oneRoomLayouts: [],
                room: 0,
                selectedLayoutIndex: -1,
                selectedLayout: [],
                layouts: [],
                totalLayouts: 0,
                perPage: 15,
                currentPage: 0,
                rooms: [],
                floorRange: [],
                areaRange: [],
                requestSend: false,
                accordionActive: false,
                firstLoadLayouts: false,
                layoutsHeight: 0
            },
            updated: function () {
                setTimeout(function () {
                    $('.header-main-phone .main-phone').attr("href", 'tel:+' + $('.header-main-phone .main-phone').text().replace(/[^0-9]/gi, ''));
                }, 3000);
                if ($('.popup-apartment-phone .main-phone').length) {
                    document.querySelector('.popup-apartment-phone .main-phone').innerHTML = document.querySelector('.main-phone').innerHTML;
                }
                if ($('.popup-main-phone .main-phone').length) {
                    $('.popup-main-phone .main-phone:not(.text-button-popup)').html($('.header-main-phone .main-phone').text());
                    $('.popup-main-phone .main-phone').attr("href",  $('.header-main-phone .main-phone').attr("href"));
                }
            },
            computed: {
                allRoomCheckbox: function () {
                    return this.rooms.length === 0 ? 'checked' : null
                }
            },
            methods: {
                fetchLayouts: function (page) {
                    if (page > 0) {
                        var url = this.$route;
                        var options = {
                            params: {
                                page: page,
                                per_page: this.perPage,
                                rooms: this.rooms,
                                floor_range: this.floorRange,
                                area_range: this.areaRange
                            }
                        };
                        if (this.firstLoadLayouts == true ) {
                            /*this.layoutsHeight = this.$refs.layoutFlats.clientHeight;*/
                        }
                        this.fetching = true;
                        this.$http
                            .get(url, options)
                            .then(function (response) {
                                this.layouts = response.data;
                                this.totalLayouts = parseInt(response.headers.get('x-total-layouts'));
                                this.currentPage = page;
                                this.fetching = false;
                            }, console.log)
                            .catch(function () {
                                setTimeout(this.fetchLayouts, 900, page);
                            });
                        this.firstLoadLayouts = true;
                    }
                },
                checkAllRooms: function () {
                    if (!this.allRoomCheckbox) {
                        this.rooms = [];
                        this.fetchLayouts(1);
                        return;
                    }
                    this.rooms = [];
                },
                fetchOneRoomLayouts: function (room) {
                    var url = this.$route;
                    var options = {
                        params: {
                            room: room
                        }
                    };
                    if (this.room !== room) {
                        this.oneRoomLayouts = [];
                        this.room = room;
                        this.fetchingMobile = true;
                        this.$http
                            .get(url, options)
                            .then(function (response) {
                                this.oneRoomLayouts = response.data;
                                this.fetchingMobile = false;
                            }, console.log)
                            .catch(function () {
                                setTimeout(this.fetchOneRoomLayouts, 900, room);
                            });
                        this.accordionActive = true;
                    }else {
                        this.toggleAccordionActive();
                    }
                },
                selectLayout: function (layout, index) {
                    this.selectedLayout = layout;
                    this.selectedLayoutIndex = index;
                    var gaLabel = $('#pagination-template').data('ga-popup-open-label');
                    ga('send', 'event', 'popup', 'open', gaLabel);
                    ga('send', 'event', 'popup', 'open', 'all-popup');
                    //yaCounter40405240.reachGoal('pop_up_open');
                },
                closePopup: function () {
                    this.selectedLayoutIndex = -1;
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
                                setTimeout(this.storeRequest, 1000);
                            });
                        var gaLabel = $('#pagination-template').data('ga-popup-open-label');
                        ga('send', 'event', 'popup', 'price-info', gaLabel);
                        ga('send', 'event', 'popup', 'price-info', 'all-popup');
                        //yaCounter40405240.reachGoal('know_cost');
                        @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                            yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('know_cost');
                        @endif
                        //reachGoal('know_cost');
                    }
                },
                toggleRequestSend: function () {
                    this.requestSend = !this.requestSend;
                },
                toggleAccordionActive: function () {
                    this.accordionActive = !this.accordionActive;
                }
            },
            created: function () {
                setTimeout(this.fetchLayouts(1), 700);
                @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                    setTimeout(function () {
                        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('old-design');
                    }, 10000);
                @endif
                //reachGoal('old-design');
            }
        });
    </script>
@endsection

@section('title', 'Все о наиболее популярных новостройках города ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][1])

@section('content')

    {{--RC-MAIN-BLOCK--}}

    @include('residentials.rc-main-block')


    {{--DESCRIPTION--}}

    @include('residentials.description')

    {{--APARTMENTS--}}

    @include('residentials.apartments')

    {{--FEATURES--}}

    @if (!$residential->features->isEmpty())
        @include('residentials.features')
    @endif

    {{--GALLERY--}}

    @if (!$residential->images->isEmpty())
        @include('residentials.gallery')
    @endif

    {{--MAP--}}
    @if(\Illuminate\Support\Facades\App::environment() == 'production')
        @if (!empty($residential->latitude) && !empty($residential->longitude))
            @include('residentials.map')
        @endif
    @endif

    {{--OTHER-RC-COMPLEXES--}}

    @if(!$residential->developer->residentials->isEmpty())
        @include('residentials.card', ['residentials' => $residential->developer->residentials])
    @endif
@endsection