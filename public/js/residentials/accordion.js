/*$(document).ready(function() {
    accordionCollapse()
});

function accordionCollapse() {
    var accordionArray = [];
    $('[data-accordion-content]').each(function (i, elem) {
        var accordionArrayElement = $(this).attr('data-accordion-content');
        var accordionArrayElementHeight = $(this).outerHeight();
        accordionArray[accordionArrayElement] = {height: accordionArrayElementHeight};
    });
    $('.collapse-in').css('display', '0');

    /!*$('[data-accordion-title]').click(function () {
        $(this).toggleClass('collapsed');
        var accordion = $(this).attr('data-accordion-title');
        var accordionActive = $('[data-accordion-content=' + accordion + ']');
        if (accordionActive.hasClass('collapse-in')) {
            var accordionActiveHeight = accordionArray[accordion];
            accordionActive.removeClass('collapse-in').animate(accordionActiveHeight, 200);
        }
        else {
            accordionActive.addClass('collapse-in').animate({'height': 0}, 200)
            ;
        }
    });*!/
}*/


$('[data-accordion-title]').click(function () {
    $(this).toggleClass('collapsed');
    var accordionID = $(this).attr('data-accordion-title');
    $('[data-accordion-content=' + accordionID + ']').slideToggle(200);
});

if (window.matchMedia("(max-width: 991px)").matches) {
    $('[data-accordion-title]').each(function () {
        $(this).addClass('collapsed')
    });
    $('[data-accordion-content]').each(function () {
        $(this).addClass('collapse-in')
    });
}