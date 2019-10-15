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
        if ($('.popup-apartment-phone .main-phone').length) {
            document.querySelector('.popup-apartment-phone .main-phone').innerHTML = document.querySelector('.main-phone').innerHTML;
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
                yaCounter49590640.reachGoal('know_cost');
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
    }
});