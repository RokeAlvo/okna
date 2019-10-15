function showPopup(id) {
    $('[data-popup-window=' + id + ']').fadeIn(200).click(closePopup);
    $('[data-popup-action="close"]').click(closePopup);
    $('[data-popup-block]').click(function (e) {
        e.stopPropagation();
    });
    $(document).keydown(function (e) {
        if (e.keyCode === 27) {
            enableScroll();
            $('[data-popup-window]').fadeOut(200);
            return false;
        }
    });
}

function closePopup() {
    /*enableScroll();*/
    $('[data-popup-window]').fadeOut(200);
}

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove = preventDefault; // mobile
    document.onkeydown = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}