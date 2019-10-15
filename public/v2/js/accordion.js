
    var acc = document.getElementsByClassName("accordion");

function accordion(acc) {
    for (var i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("accordion-active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
}

accordion(acc);


/* var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        this.classList.toggle("activem");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
} */

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