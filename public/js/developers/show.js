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
                yaCounter49590640.reachGoal('know_cost');
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