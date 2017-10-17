new Vue({
    el: '#layouts',
    data: {
        layouts: [],
        totalLayouts: 0,
        perPage: 15,
        currentPage: 0,
        rooms: [],
        floorRange: [],
        areaRange: [],
        oldData: {}
    },
    methods: {
        fetchLayouts: function (page) {

            if (page > 0/* && this.oldData != data*/) {

                //var url = $('h1:first').data('residential-url');
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

                this.$http.get(url, options).then(function (response) {

                    this.oldData = this.data;
                    this.layouts = response.data;
                    this.totalLayouts = parseInt(response.headers.get('x-total-layouts'));
                    console.log(this.totalLayouts);
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