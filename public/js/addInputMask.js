function addInputMask(element) {
    if (!mobileAndTabletCheck()) {
        $(element).mask("+7 (999) 999-99-99");
    }
}