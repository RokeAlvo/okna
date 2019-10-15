var position = 0;
$(window).scroll(function () {
    var top = $(window).scrollTop();
    if ((top > 700) && (position == 0)) {
        position = 1;
        $('#top-sticky-menu-wrapper').animate(
            {top: 0},
            300
        )
    }
    else {
        if ((top < 700) && (position == 1)) {
            position = 0;
            $('#top-sticky-menu-wrapper').animate(
                {top: '-50px'},
                300
            );
        }
    }
});