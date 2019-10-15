function showTooltip(element) {
    var item = $(element).parent().find('.popup-apartment-tooltip');
    $(item).fadeIn(200);
    $(document).mousedown(function (e) {
        var container = $(element).parent();
        if (container.has(e.target).length === 0) {
            $(item).fadeOut(200);
        }
    });
/*/!*    var top = $(element).offset().top;
    var height = $(item).height();
    var endPosition  = $(element).outerHeight() + 25;
    var startPosition = endPosition + 30;*!/
    var direction = (height < top) ? 'bottom' : 'top';
    var directionShow = {opacity: 1};
    var directionHide = {opacity: 0};
    directionHide[direction] = startPosition + 'px';
    directionShow[direction] = endPosition + 'px';*//*
    $(item)
        .animate({'opacity': '1'}, 200)
        .animate({'top': '25px'}, 200)
    ;*/
/*    if (item.css('display') != 'block') {
        item.css(direction, startPosition + 'px');
    }
    $(item).animate(directionShow, 200).show();
    $(document).click(function (e) {
        var container = $(element).parent();
        if (container.has(e.target).length === 0){
            slideUp(item, directionHide);
        }
    });*/
}
/*

function slideUp (item, directionHide) {
    $(item).animate(directionHide, 200);
    setTimeout(hideDiscount, 300, item);
}

function hideDiscount (item) {
    $(item).hide()
}*/
