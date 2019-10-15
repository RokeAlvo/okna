function showDiscount() {
    $("body").css("overflow-y", "hidden");
    // $('.discount-overlay').css("position", "fixed", "background-color", "rgba(26, 23, 55, 0.7)");
    // $('.discount-overlay').css("background-color", "rgba(26, 23, 55, 0.7)");
    $('.discount-overlay-off').addClass('discount-overlay-on');
    $('.discount__close').css("display", "block");
}