function validateInput(element) {
    
    if (element.classList.contains('sale-text--hiden')) {
        $(element).removeClass('sale-text--hiden');
    }

    else {
        $(element).addClass('sale-text--hiden');
    }
}