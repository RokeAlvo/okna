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
                                            <span>@{{selectedLayout.room_label}}</span><span>@{{selectedLayout.area}}
                                                м<sup>2</sup></span>
                                        </div>
                                        <div class="popup-apartment-floor">@{{selectedLayout.floor_range}}
                                        </div>
                                    </div>
                                    <div class="popup-apartment-layout">
                                        <div class="popup-apartment-wrapper">
                                            <img :src="selectedLayout.main_image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="popup-apartment-right">
                                    <ul class="popup-apartment-payment">
                                        <li>
                                            <i style="background-image: url({{ url('/img/apartment/mortgage.png') }})"></i><span>Ипотека от {{ !empty($residential->mortgageOST) ? $residential->mortgageOST->percent_from : 9 }}
                                                % годовых</span>
                                        </li>
                                        @if(!empty($residential->installment))
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/installment.png') }})"></i><span>Рассрочка {{ !empty($residential->installment->percent) ? $residential->installment->percent.'% годовых' : 'на выгодных условиях' }}</span>
                                            </li>
                                        @endif
                                        @if(!empty($residential->tradeIn))
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/trade-in.png') }})"></i><span>TRADE-in без переплат</span>
                                            </li>
                                        @endif
                                        @if(!empty($residential->mortgageWIF))
                                            <li>
                                                <i style="background-image: url({{ url('/img/apartment/down-payment.png') }})"></i><span>Ипотека без первоначального взноса</span>
                                            </li>
                                        @endif
                                    </ul>
                                    <div class="popup-apartment-cta-form">
                                        <div class="popup-apartment-price">
                                            <div class="popup-apartment-price-cta">
                                                <span>Актуальную цену</br>узнавайте в отделе продаж</span>
                                                <button onclick="showTooltip(this)">i</button>
                                                <div class="popup-apartment-tooltip">
                                                    Стоимость квартиры может варьироваться от этажа, срока сдачи, способа покупки, площади, и множества других факторов.
                                                </div>
                                            </div>
                                        <!--<div class="popup-apartment-price-value">
                                                <div class="popup-apartment-price-from">от <b>@{{selectedLayout.price_min_format}}</b><sup> руб.</sup></div>
                                                <div class="popup-apartment-price-to">до <b>@{{selectedLayout.price_max_format}}</b><sup> руб.</sup></div>
                                            </div>-->
                                        </div>
                                        <div class="popup-apartment-form">
                                            <div class="row" v-if="!requestSend">
                                                <div class="col-xs-6">
                                                    <input type="text" name="client_phone" id="client-phone" onclick="addInputMask(this)" placeholder="+7 (___) ___-__-__">
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
                                                    <button type="button" @click.prevent="storeRequest">Заказать звонок</button>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="popup-apartment-form-description">*менеджер отдела продаж перезвонит вам в кратчайшие сроки</div>
                                                </div>
                                            </div>
                                            <div class="popup-apartment-form-success" v-else>
                                                <span>Спасибо за обращение!</span> с вами свяжутся в течении 5 минут.
                                            </div>
                                        </div>
                                        <div class="popup-apartment-phone">Или по телефону:
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