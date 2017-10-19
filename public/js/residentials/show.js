new Vue({
    el: '#layouts',
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
        areaRange: [],
        phone: ''
    },
    computed: {
        allRoomCheckbox: function () {
            return this.rooms.length === 0
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
                this.$http.get(url, options)
                    .then(function (response) {
                        this.layouts = response.data;
                        this.totalLayouts = parseInt(response.headers.get('x-total-layouts'));
                        this.currentPage = page;
                        this.fetching = false;
                    }, console.log)
                    .catch(function () {
                        setTimeout(this.fetchLayouts, 900, page);
                    })


            }
        },
        checkAllRooms: function () {
            if (!this.allRoomCheckbox) {
                this.rooms = [];
                this.fetchLayouts(1);
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
                this.$http.get(url, options).then(function (response) {
                    this.oneRoomLayouts = response.data;
                    this.room = room;
                }, console.log);
            }
        },
        selectLayout: function (index) {
            this.selectedLayoutIndex = index;
            this.addInputMask();
        },
        closePopup: function () {
            this.selectedLayoutIndex = -1;
        },
        addInputMask: function () {
            var options = {
                onComplete: function (e) {
                    var event = document.createEvent('HTMLEvents');
                    event.initEvent('input', true, true);
                    e.currentTarget.dispatchEvent(event);
                    $("").trigger('change');
                }
            };
            $("#phone").mask("+7 (999) 999-9999", options);

            /* TODO ТЕПЕРЬ почему-то не работает, хотя до этого работало и код я не трогал :( */
        }
    },
    created: function () {
        setTimeout(this.fetchLayouts(1), 500);

    }
});