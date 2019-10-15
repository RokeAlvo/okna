$(document).ready(function() {
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

    $('[data-accordion-title]').click(function () {
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
    });
}


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

var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("activem");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}

// var acc4 = document.getElementsByClassName("accordionm");
// var i4;
// for (i4 = 0; i4 < acc.length; i4++) {
//   acc4[i4].addEventListener("click", function() {
//     this.classList.toggle("activem");
//     var panell = this.prevElementSibling;
//     if (panelm.style.maxHeight){
//       panelm.style.maxHeight = null;
//     } else {
//       panelm.style.maxHeight = panelm.scrollHeight + "px";
//     } 
//   });
// }


// $(function() {
//     var accordion_head = $('.accordion-m > .service2 > div'),
//         accordion_body = $('.accordion-m .service2 > .sub-menu');
//     accordion_head.on('click', function(event) {
//     event.preventDefault();
//     accordion_head.not($(this).toggleClass('active')).removeClass('active')
//     accordion_body.not($(this).prev().slideToggle()).slideUp('normal');
//     });
//    });