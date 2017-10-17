Vue.component('pagination', {
    template: '#pagination-template',
    props: {
        current: {
            type: Number,
            default: 1
        },
        total: {
            type: Number,
            default: 0
        },
        perPage: {
            type: Number,
            default: 15
        },
        pageRange: {
            type: Number,
            default: 2
        }
    },
    computed: {
        pages: function () {
            var pages = [];
            /* for many-many pages
            for (var i = this.rangeStart; i <= this.rangeEnd; i++) {
                pages.push(i);
            }*/
            for (var i = 1; i <= this.totalPages; i++) {
                pages.push(i);
            }
            return pages;
        },
        nextPage: function () {
            return (this.current < this.totalPages) ? this.current + 1 : this.totalPages;
        },
        prevPage: function () {
            return (this.current > 1) ? this.current - 1 : 1;
        },
        totalPages: function () {
            return Math.ceil(this.total / this.perPage);
        },
        rangeStart: function () {
            var start = this.current - this.pageRange;
            return (start > 0) ? start : 1;
        },
        rangeEnd: function () {
            var end = this.current + this.pageRange;
            return (end > this.totalPages) ? end : this.totalPages;
        }

    },
    methods: {
        hasFirst: function () {
            return this.rangeStart !== 1;
        },
        hasLast: function () {
            return this.rangeEnd !== this.totalPages;
        },
        hasPrev: function () {
            return this.current > 1;
        },
        hasNext: function () {
            return this.current < this.totalPages;
        },
        changePage: function (page) {
            this.$emit('page-changed', page)
        }
    }
});