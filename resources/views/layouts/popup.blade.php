@section('styles')
    <link href="{{ url('/css/popup/old.css') }}" rel="stylesheet">
@endsection
<transition id="apartment-popup-transition" appear name="fade" v-cloak>
    <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" style="display: block" id="{{ $popupType }}">
        <div class="popup" @click.self="closePopup">
            <div class="modal-dialog modal-dialog-custom-rc"
                 role="document"{{-- v-if="~selectedLayoutIndex" data-popup-window="apartment" style="display: block"--}}>
                <div class="modal-content modal-on-detail-rc">
                    <div class="row">
                        <div class="col-md-6 pr0">
                            <div class="modal-header-sm">
                                <button type="button" class="close" @click="closePopup"><span>&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Информация о квартире</h4>
                            </div>
                            <div class="modal-apartment-img">
                                <img :src="selectedLayout.main_image">
                            </div>
                        </div>
                        <div class="col-md-6 pl0">
                            <div class="modal-apartment-container">
                                <div class="modal-apartment-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" @click="closePopup"><span>&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Информация о квартире</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-apartment-info"><img src="/img/quickview-apartment/popup-key.png"/><span>Кол-во комнат</span><span
                                                    class="modal-apartment-info-value">@{{selectedLayout.room_label}}</span>
                                        </div>
                                        <div class="modal-apartment-info"><img src="/img/quickview-apartment/area.png"/><span>Площадь</span><span
                                                    class="modal-apartment-info-value">@{{selectedLayout.area}} м<sup>2</sup></span>
                                        </div>
                                        <div class="modal-apartment-info"><img src="/img/quickview-apartment/stairsl.png"/><span>Этаж</span><span
                                                    class="modal-apartment-info-value">@{{selectedLayout.floor_range_popup}}</span>
                                        </div>
                                        <div class="modal-apartment-info"><img src="/img/quickview-apartment/calendar.png"/><span>Срок сдачи</span><span
                                                    class="modal-apartment-info-value">@{{ selectedLayout.residential_completion_date }}</span>
                                        </div>
                                        <div class="modal-apartment-info">
                                            <img src="/img/quickview-apartment/popup-wallet.png"/>
                                            <span>Варианты оплаты</span>
                                            @if(!empty($residential))
                                                <span class="modal-apartment-info-value">наличные, ипотека{{ !empty($residential->installment) ? ', рассрочка' : '' }}{{ !empty($residential->tradeIn) ? ', trade-in' : '' }}</span>
                                            @else
                                                <span class="modal-apartment-info-value">наличные, ипотека<template v-if="typeof residentials[payments.residential_index].installment != 'undefined'">, рассрочка</template><template v-if="typeof residentials[payments.residential_index].trade_in != 'undefined'">, trade-in</template></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="apartment-modal-form" v-if="!requestSend">
                                            <div class="apartment-modal-form-title">
                                                Узнайте актуальную цену
                                            </div>
                                            <div class="apartment-modal-form-description">
                                                Введите ваш номер телефона без первой “8”.
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input
                                                            class="form-control modal-apartment-phone"
                                                            type="tel"
                                                            name="client_phone"
                                                            id="client-phone"
                                                            onclick="addInputMask(this)"
                                                            placeholder="+7 (___) ___-__-__"
                                                    >
                                                </div>
                                                <div class="col-xs-6">
                                                    <button
                                                            type="button"
                                                            @click.prevent="storeRequest('{{ getUrlPathFirstPart() }}')"
                                                            class="btn btn-block btn-lg modal-button btn-custom-lg"
                                                    >
                                                        Узнать цену
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="apartment-modal-form-sub-title">
                                                или в отделе продаж: <b>{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</b>
                                            </div>
                                        </div>
                                        <div class="popup-apartment-form-success" v-else>
                                            <span>Спасибо за обращение!</span> с вами свяжутся в течение 5 минут.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="apartment-modal-price-info">
                    <b>i</b><span>Стоимость <span v-if="selectedLayout.room_label != 'Студия'">@{{selectedLayout.room_label}}</span><span v-else>студий</span> <span
                                v-if="selectedLayout.room_label != 'Студия'">квартир</span> в данном ЖК: @{{selectedLayout.price_min_format}}
                        - @{{selectedLayout.price_max_format}} руб.</span>
                </div>
            </div>
        </div>
    </div>
</transition>

{{--
<div class="modal fade" id="myModal" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"--}}
{{-- @click.self="closePopup"--}}{{--
></div>--}}
