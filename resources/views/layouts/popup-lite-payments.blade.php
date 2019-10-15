@section('styles')
    <link href="{{ url('/css/popup/lite-payments.css') }}" rel="stylesheet">
@endsection
<transition id="apartment-popup-transition" appear name="fade" v-cloak>
    <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" style="display: block" id="{{ $popupType }}">
        <div class="popup" @click.self="closePopup">
            <div class="container">
                <div class="popup-block" data-popup-block="true">
                    <div class="popup-apartment">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="popup-apartment-left">
                                    <div class="popup-apartment-info">
                                        <div class="popup-apartment-type">
                                            <span>@{{selectedLayout.room_label}}</span> <span>@{{selectedLayout.area}}
                                                м<sup>2</sup></span>
                                        </div>
                                        <div class="popup-apartment-floor">@{{selectedLayout.floor_range_popup}}
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
                                        <div class="popup-apartment-cta">
                                            <div class="popup-apartment-cta-img">
                                                <img src="/img/apartment/ruble.png">
                                            </div>
                                            <div class="popup-apartment-cta-title">
                                                Узнайте актуальную цену
                                            </div>
                                            <div class="popup-apartment-cta-subtitle">
                                                Введите номер телефона без первой «8»
                                            </div>
                                        </div>
                                        <div class="popup-apartment-form">
                                            <div class="row" v-if="!requestSend">
                                                <div class="col-xs-6">
                                                    <input type="text" name="client_phone" id="client-phone" onclick="addInputMask(this)" placeholder="+7 (___) ___-__-__">
                                                </div>
                                                <div class="col-xs-6">
                                                    <button type="button" @click.prevent="storeRequest('{{ getUrlPathFirstPart() }}')">Узнать цену</button>
                                                </div>
                                            </div>
                                            <div class="popup-apartment-form-success" v-else>
                                                <span>Спасибо за обращение!</span> с вами свяжутся в течении 5 минут.
                                            </div>
                                        </div>
                                        <div class="popup-apartment-phone">Или узнавайте цену в отделе продаж: <b>{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</b></div>
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