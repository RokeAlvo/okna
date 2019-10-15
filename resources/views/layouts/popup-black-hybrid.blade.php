@section('styles')
    <link href="{{ url('/css/popup/black-hybrid.css') }}" rel="stylesheet">
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
                                    <div class="popup-apartment-layout">
                                        <div class="popup-apartment-wrapper">
                                            <img :src="selectedLayout.main_image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="popup-apartment-right">
                                    <div class="popup-apartment-specifications">
                                        <div class="popup-apartment-specifications-item">
                                            <div class="popup-apartment-specifications-title">
                                                кол-во комнат
                                            </div>
                                            <div class="popup-apartment-specifications-value">
                                                @{{selectedLayout.room_label}}
                                            </div>
                                        </div>
                                        <div class="popup-apartment-specifications-item">
                                            <div class="popup-apartment-specifications-title">
                                                площадь в м<sup>2</sup>
                                            </div>
                                            <div class="popup-apartment-specifications-value">
                                                @{{selectedLayout.area}}
                                            </div>
                                        </div>
                                        <div class="popup-apartment-specifications-item">
                                            <div class="popup-apartment-specifications-title">
                                                срок сдачи от
                                            </div>
                                            <div class="popup-apartment-specifications-value">
                                                @{{ selectedLayout.residential_completion_date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popup-apartment-payment">
                                        @if(!empty($residential->mortgageWIF))
                                            <div class="popup-apartment-payment-item">
                                                <img src="/img/apartment/check-mark.png"><span>Ипотека от {{ !empty($residential->mortgageOST) ? $residential->mortgageOST->percent_from : 9 }}% годовых</span>
                                            </div>
                                        @elseif(empty($residential))
                                            <div class="popup-apartment-payment-item" v-if="typeof residentials[payments.residential_index].minMortgagePercent != 'undefined'">
                                                <img src="/img/apartment/check-mark.png"><span>Ипотека от @{{ residentials[payments.residential_index].minMortgagePercent }}% годовых</span>
                                            </div>
                                        @endif
                                        @if(!empty($residential->mortgageWIF))
                                            <div class="popup-apartment-payment-item">
                                                <img src="/img/apartment/check-mark.png"><span>Ипотека без первоначального взноса</span>
                                            </div>
                                        @elseif(empty($residential))
                                            <div class="popup-apartment-payment-item" v-if="typeof residentials[payments.residential_index].mortgage_w_i_f != 'undefined'">
                                                <img src="/img/apartment/check-mark.png"><span>Ипотека без первоначального взноса</span>
                                            </div>
                                        @endif
                                        @if(!empty($residential->installment))
                                            <div class="popup-apartment-payment-item">
                                                <img src="/img/apartment/check-mark.png"><span>Рассрочка {{ (!empty($residential->installment->percent) || $residential->installment->percent == 0) ? $residential->installment->percent.'% годовых' : 'на выгодных условиях' }}</span>
                                            </div>
                                        @elseif(empty($residential))
                                            <div class="popup-apartment-payment-item" v-if="typeof residentials[payments.residential_index].installment.percent != 'undefined'">
                                                <img src="/img/apartment/check-mark.png"><span>Рассрочка @{{ residentials[payments.residential_index].installment.percent || 0 }}% годовых</span>
                                            </div>
                                            <div class="popup-apartment-payment-item" v-else>
                                                <img src="/img/apartment/check-mark.png"><span>Рассрочка на выгодных условиях</span>
                                            </div>
                                        @endif
                                        @if(!empty($residential->tradeIn))
                                            <div class="popup-apartment-payment-item">
                                                <img src="/img/apartment/check-mark.png"><span>trade-in без переплат</span>
                                            </div>
                                        @elseif(empty($residential))
                                            <div class="popup-apartment-payment-item" v-if="typeof residentials[payments.residential_index].trade_in != 'undefined'">
                                                <img src="/img/apartment/check-mark.png"><span>trade-in без переплат</span>
                                            </div>
                                        @endif
                                    </div>
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