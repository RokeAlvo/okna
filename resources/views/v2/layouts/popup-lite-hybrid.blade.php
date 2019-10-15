@section('styles')
    <link href="{{ url('/v2/css/popup/lite-hybrid.css') }}" rel="stylesheet">
@endsection

<div v-cloak>  <!--style="display: none;"-->
    <transition id="apartment-popup-transition" appear name="fade" v-cloak> <!-- -->
        <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" id="{{ $popupType }}">
            <div class="close-popup-m" @click="closePopup"><img src="/img/sign-x.png" class="sign-x"> закрыть</div>
            <div class="popup popup-right" @click.self="closePopup">
                <div class="popup-body">
                    
                    <div class="close-popup d-none d-md-block" @click="closePopup"><img src="/img/close-popup.png"></div>
                    <div class="img-popup-arrow-back  d-block d-md-none" @click="closePopup"><img src="/img/arrow-left-gray.png"></div>
                    <div class="plan-image-box">
                        <img class="main-popup-img" :src="selectedLayout.main_image">
                        @include('v2.layouts.modules.loupe')
                    </div>
                    <div class="plan-info-cont-wrapper">
                        <div class="plan-info">

                            <div class="number-room-wrapper">
                                <div class="popup-apartment-specifications-title">Кол-во комнат:</div>
                                <div class="popup-apartment-specifications-value"> @{{selectedLayout.room_label}}
                                </div> {{--  @{{selectedLayout.room_label}}--}}
                            </div>
                            <div class="number-room-wrapper">
                                <div class="popup-apartment-specifications-title">Площадь:</div>
                                <div class="popup-apartment-specifications-value"> @{{selectedLayout.area}} м<sup>2</sup>
                                </div> {{--  @{{selectedLayout.area}}--}}
                            </div>

                            <div class="number-room-wrapper d-none d-md-block">
                                <div class="popup-apartment-specifications-title">Срок сдачи от:</div>
                                <div class="popup-apartment-specifications-value">@{{ selectedLayoutResidential.completion_date_short }}
                                </div>
                            </div>
                        </div>

                        <div class="number-room-date date-width d-block d-md-none">
                            <div class="popup-apartment-specifications-title">Срок сдачи от:</div>
                            <div class="popup-apartment-specifications-value">@{{ selectedLayoutResidential.completion_date_full }}
                            </div>
                        </div>

                        <div class="call-back popup-apartment-phone d-block d-md-none">
                            <div class=" call-text">Актуальную цену узнавайте по телефону в отделе продаж</div>
                            <a class="main-phone" href="tel:+73833884896">
                                <div class="call-button-box">
                                    <div class="call-image"><img src="/img/phone-green.png"></div>
                                    <div class="call-button popup-main-phone">Узнать цену</div>
                                </div>
                            </a>
                        </div>

                        <div class="house-info-wrapper">
                            <div class="house-info popup-apartment-specifications-title" v-if="selectedLayoutResidential.full_decoration">Ремонт:
                                <span class="popup-apartment-payment-methods pad-left">Под ключ</span>
                            </div>
                            <div class="house-info popup-apartment-specifications-title" v-if="selectedLayoutResidential.material">Дом:
                                <span class="popup-apartment-payment-methods pad-left">@{{ selectedLayoutResidential.material }}</span>
                            </div>
                        </div>

                        <div class="method">
                            <div class="popup-apartment-specifications-title">Способы оплаты:</div>
                            <div class="popup-apartment-payment-methods">@{{ selectedLayoutResidential.payment_methods }}</div>
                        </div>


                        {{--<div class="all-rooms-popup  d-block d-sm-none">Все 1-комнатные</div>--}}


                        <div class="price-number-wrapper d-none d-md-block">
                            <div class="popup-phone-box">
                                <div class="popup-text-info">Актуальную цену узнавайте в отделе продаж по тел.:</div>
                                <div><b> {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!} </b></div>
                            </div>
                            <div class="popup-apartment-specifications-title callback">Или закажите обратный звонок</div>
                            <div class="number-send row" v-if="!requestSend">
                                <div class="col-6 number-placeholder">
                                    <input type="text" name="client_phone" id="client-phone"
                                           onclick="addInputMask(this)"
                                           placeholder="+7 (___) ___-__-__">
                                </div>
                                <div class="col-6">
                                    <div class="number-button" @click.prevent="storeRequest('{{ getUrlPathFirstPart() }}')">
                                        Обратный звонок
                                    </div>
                                </div>
                            </div>
                            <div class="popup-apartment-form-success" v-else>
                                <span>Спасибо за обращение!</span> с Вами свяжутся в течении 5 минут.
                            </div>
                        </div>

                        <div class="popup-apartment-specifications-title confidential-policy d-none d-md-block">Нажимая на кнопку "Отправить",
                            Вы соглашаетесь с <a href="/oferta.pdf" target="_blank">политикой конфиденциальности</a></div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</div>