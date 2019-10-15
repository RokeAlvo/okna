@section('styles')
    <link href="{{ url('/css/popup/lite-specifications.css') }}" rel="stylesheet">
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
                                    <div class="popup-apartment-specifications-off">
                                        <div class="popup-apartment-specifications-off-item">
                                            <div class="popup-apartment-specifications-title">
                                                Этажи
                                            </div>
                                            <div class="popup-apartment-specifications-value">
                                                @{{selectedLayout.floor_range_popup}}
                                            </div>
                                        </div>
                                        <div class="popup-apartment-specifications-off-item">
                                            <div class="popup-apartment-specifications-title">
                                                Способы оплаты
                                            </div>
                                            <div class="popup-apartment-specifications-value">
                                                <span>Наличные</span>
                                                • <span>Ипотека</span>
                                                @if(!empty($residential->installment))
                                                    • <span>Рассрочка</span>
                                                @elseif(empty($residential))
                                                    • <span v-if="typeof residentials[payments.residential_index].installment != 'undefined'">Рассрочка</span>
                                                @endif
                                                @if(!empty($residential->tradeIn))
                                                    • <span>TRADE-IN</span>
                                                @elseif(empty($residential))
                                                    • <span v-if="typeof residentials[payments.residential_index].trade_in != 'undefined'">TRADE-IN</span>
                                                @endif
                                            </div>
                                        </div>
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