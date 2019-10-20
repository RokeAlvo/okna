import './section4.scss'
import './../../../../blocks/promo-card/promo-card'

$(document).ready(function () {
  $('.section4__content').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 3
  });
});
