function showInputPhone(element) {

    if (element.classList.contains('btn--hiden')) {
        $(element).removeClass('btn--hiden');
    }

    else {
        $(element).addClass('btn--hiden');

    }
//     const template = `<div class="">
//     <div class="popup-text-info">
//         <div class="popup-text-welcome">Спасибо за заявку!</div>
//     </div>
//     <div class="popup-text-welcome-under">Наш менеджер свяжется с вами в течение пяти минут (в рабочее время) и ответит на все вопросы</div>
// </div>


// <div class="schedule"> График работы отдела продаж: <div class="time"> Пн-Пт 9:00–18:00</div></div>


// `
//     $('.price-number-wrapper').html(template);
    // const wrapper = $(element).createElement(`div`);
    // wrapper.innerHTML = ("template");


}