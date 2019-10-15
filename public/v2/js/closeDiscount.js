function closeDiscount() {
    $("body").css("overflow", "unset");
    $('.discount-overlay-off').removeClass('discount-overlay-on');
    $('.discount__close').css("display", "none");
}