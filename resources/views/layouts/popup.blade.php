<transition id="apartment-popup-transition" appear name="fade" v-cloak>
    <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" style="display: block">
        <div class="popup" @click.self="closePopup">
            <div class="container">
                <div class="popup-block" data-popup-block="true">
                    <div class="popup-apartment">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="popup-apartment-left">
                                    <div class="popup-apartment-info">
                                        <div class="popup-apartment-type">
                                            <span>@{{layouts[selectedLayoutIndex].room_label}}</span><span>@{{layouts[selectedLayoutIndex].area}}
                                                м<sup>2</sup></span>
                                        </div>
                                        <div class="popup-apartment-floor">
                                            <b>@{{layouts[selectedLayoutIndex].floor_range}}</b>
                                        </div>
                                    </div>
                                    <div class="popup-apartment-layout">
                                        <div class="popup-apartment-wrapper">
                                            <img :src="layouts[selectedLayoutIndex].main_image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="popup-apartment-right">
                                    <ul class="popup-apartment-payment">
                                        <li>
                                            <i style="background-image: url({{ url('/img/apartment/mortgage.png') }})"></i><span>Ипотека от 8% годовых</span>
                                        </li>
                                        <li>
                                            <i style="background-image: url({{ url('/img/apartment/installment.png') }})"></i><span>Рассрочка 0% годовых</span>
                                        </li>
                                        <li>
                                            <i style="background-image: url({{ url('/img/apartment/trade-in.png') }})"></i><span>TRADE-in без переплат</span>
                                        </li>
                                        <li>
                                            <i style="background-image: url({{ url('/img/apartment/down-payment.png') }})"></i><span>Ипотека без первоначального взноса</span>
                                        </li>
                                    </ul>
                                    <div class="popup-apartment-cta-form">
                                        <div class="popup-apartment-price">
                                            <div class="popup-apartment-price-cta">
                                                <span>Актуальную цену</br>узнавайте в отделе продаж</span>
                                                <button>i</button>
                                            </div>
                                            <div class="popup-apartment-price-value">
                                                <div class="popup-apartment-price-from">от <b>@{{layouts[selectedLayoutIndex].price_min_format}}</b><sup> руб.</sup></div>
                                                <div class="popup-apartment-price-to">до <b>@{{layouts[selectedLayoutIndex].price_max_format}}</b><sup> руб.</sup></div>
                                            </div>
                                        </div>
                                        <div class="popup-apartment-form">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="hidden" name="layout_id" :value="layouts[selectedLayoutIndex].id">
                                                    <input id="phone" type="text" v-model="phone" onclick="addInputMask(this)" placeholder="+7 (___) ___-__-__">
                                                    <script>
                                                        function addInputMask(element) {
                                                            var options = {
                                                                onComplete: function (e) {
                                                                    var event = document.createEvent('HTMLEvents');
                                                                    event.initEvent('input', true, true);
                                                                    e.currentTarget.dispatchEvent(event);
                                                                    $("").trigger('change');
                                                                }
                                                            };
                                                            $(element).mask("+7 (999) 999-99-99", options);
                                                        }
                                                    </script>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button>Узнать цену</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="popup-apartment-phone">Телефон отдела продаж:
                                            <b>{{ SITE_CONTACTS['phone'] }}</b></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img @click="closePopup" class="close-popup-mobile" src="/img/apartment/close-mobile.png">
                    </div>
                    <img @click="closePopup" class="close-popup" src="/img/icon-close-popup.png">
                </div>
            </div>
        </div>
    </div>
</transition>