function validateInput(element) {
    window.checkValidate;
    if (element.value.split(/[-()+_]/).length > 7 || element.value.split(/[-()+_]/).length === 1) {
        $(element).addClass('input__back-phone--error');
        checkValidate = false;
        return checkValidate;
    } else {
        $(element).removeClass('input__back-phone--error');
        checkValidate = true;
        return checkValidate;
    }
}