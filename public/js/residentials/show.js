new Vue({
    el: '#layouts',
    data: {
        layouts: [],
        totalLayouts: 0,
        perPage: 15,
        currentPage: 0,
        rooms: [],
        floorRange: [],
        areaRange: []
    },
    methods: {
        fetchLayouts: function (page) {

            if (page > 0 && this.currentPage !== page) {
                var options = {
                    params: {
                        page: page,
                        per_page: this.perPage,
                        rooms: this.rooms,
                        floor_range: this.floorRange,
                        area_range: this.areaRange
                    }
                };

                var url = $('h1:first').data('residential-url');
                this.$http.get(url, options).then(function (response) {

                    console.log(response.headers.get('x-area-range'));
                    this.layouts = response.data;
                    this.totalLayouts = parseInt(response.headers.get('x-total-layouts'));
                    this.currentPage = page;

                }, console.log);
            }
        }
    },
    created: function () {
        this.fetchLayouts(1);
        //pagination.changePage(1);
    }
});