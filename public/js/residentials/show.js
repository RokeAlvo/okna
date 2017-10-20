new Vue({
    el: '#layouts-vue',
    data: {
        fetching: false,
        oneRoomLayouts: [],
        room: 0,
        selectedLayoutIndex: -1,
        layouts: [],
        totalLayouts: 0,
        perPage: 15,
        currentPage: 0,
        rooms: [],
        floorRange: [],
        areaRange: []
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
                this.$http
                    .get(url, options)
                    .then(function (response) {
                        this.oneRoomLayouts = response.data;
                        this.room = room;
                    }, console.log)
                    .catch(function () {
                        setTimeout(this.fetchOneRoomLayouts, 900, room);
                    });
            }
        },
        selectLayout: function (index) {
            this.selectedLayoutIndex = index;
        },
        closePopup: function () {
            this.selectedLayoutIndex = -1;
        },
        storeRequest: function () {
            var url = window.location.protocol + '//' +window.location.hostname + '/requests/store';
            var options = {
                params: {
                    layout_id: this.layouts[this.selectedLayoutIndex].id,
                    client_phone: $('#client-phone').val(),
                    type: 1,
                    _token: window.Laravel.csrfToken
                },
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                }
            };
            this.$http
                .post(url, options)
                .then(function (response) {
                    console.log(response);
                }, console.log)
                .catch(function () {
                    setTimeout(this.storeRequest, 900);
                });
        }
    },
    created: function () {
        setTimeout(this.fetchLayouts(1), 700);
    }
});