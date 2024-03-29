@section('styles')
<link href="{{ url('/v2/css/v2-popups/actual-price-green.css') }}" rel="stylesheet">
@endsection




<div v-cloak>
    <!--style="display: none;"-->
    <transition id="apartment-popup-transition" appear name="fade" v-cloak>
        <!-- -->
        <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" id="{{ $popupType }}">
            <div class="close-popup-m" @click="closePopup"><img src="/img/sign-x.png" class="sign-x">
                <div></div>
            </div>
            <div class="popup popup-right" @click.self="closePopup">
                <div class="popup-body">

                    <div class="close-popup d-none d-md-block" @click="closePopup"><img src="/img/close-popup.png"></div>
                    <!-- <div class="img-popup-arrow-back  d-block d-md-none" @click="closePopup"><img src="/img/arrow-left-gray.png"></div> -->
                    <div class="plan-image-box">
                        <img class="main-popup-img" :src="selectedLayout.main_image">
    @include('v2.layouts.modules.loupe')
                    </div>
                    <div class="plan-info-cont-wrapper">
                        <div class="plan-info">

                            <div class="number-room-wrapper">
                                <div class="popup-apartment-specifications-title">Комнат:</div>
                                <div class="popup-apartment-specifications-value"> @{{selectedLayout.room_label}}
                                </div> {{-- @{{selectedLayout.room_label}}--}}
                            </div>
                            <div class="number-room-wrapper">
                                <div class="popup-apartment-specifications-title">Площадь</div>
                                <div class="popup-apartment-specifications-value"> @{{selectedLayout.area}} м<sup>2</sup>
                                </div> {{-- @{{selectedLayout.area}}--}}
                            </div>
                            <div class="number-room-wrapper">
                                <div class="popup-apartment-specifications-title">Стоимость</div>
                                <!-- <div class="popup-apartment-specifications-value">1 890 000 – 2 150 000 ₽</div> -->
                                <div class="popup-apartment-specifications-value">@{{selectedLayout.price_range}}&nbsp;₽</div>
                            </div>

                        </div>

                        <div class="price-number-wrapper price-number-wrapper--call" v-if="!requestSend">
                            <div class="popup-phone-box">
                                <div class="popup-text-info"><img src="/img/white-rub.png">
                                    <div class="popup-text-title-rub">Хотите узнать актуальную цену?</div>
                                </div>
                                <div class="popup-text-under">Позвоните в <span class="sale-departes">отдел продаж</span> и получите ответы на все интересующие
                                    вас вопросы!</div>
                            </div>

                            <div class="button__phone btn--white">
                                {{-- {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!} --}}
                                <a href="" class="change-phone">+7 (383) 388-4896</a>
                            </div>



                            <!-- <input class="button__phone__input__back-phone button__phone__input__back-phone--hiden" 
                            type="text" name="client_phone"
                                        onkeypress ="validateInput(this)"       
                                        onclick="addInputMask(this)"
                                           
                                           placeholder="+7 (___) __-__-__">
                                 -->

                            <div class="to-order-call btn--white" onclick="showInputPhone(this)">
                                Заказать звонок
                            </div>

                            <input type="text" name="client_phone" id="client-phone" class="input__back-phone mask-phone" inputmode="numeric" placeholder="+7 (___) ___-__-__"
                                autocomplete="on">

                            <div class="label--green-btn" @click.prevent="storeRequest('{{ getUrlPathFirstPart() }}')"></div>

                        </div>

                        <div class="welcome-wrapper" v-else>
                            <div class="popup-text-info">
                                <div class="popup-text-welcome">Спасибо за заявку!</div>
                            </div>
                            <div class="popup-text-welcome-under">Наш менеджер свяжется с вами в течение пяти минут (в рабочее время) и ответит на все вопросы</div>


                            <div class="bottom__phone welcome__bottom">
                                {{-- {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!} --}}
                                <a href="" class="change-phone">+7 (383) 388-4896</a>

                            </div>
                        </div>


                    </div>
                    <div class="modal-bottom">
                        <div class="modal-bottom__conf">Отправляя форму, вы соглашаетесь с <a href="/oferta.pdf" target="_blank">Политикой конфиденциальности</a></div>
                        <div class="modal-bottom__no-affert">Цена указана на диапазон @{{selectedLayout.room_label}} квартир. Не является публичной офертой</div>
                    </div>

                    {{--
                    <div class="all-rooms-popup  d-block d-sm-none">Все 1-комнатные</div>--}}


                </div>

                {{--
                <div class="popup-apartment-specifications-title confidential-policy d-none d-md-block">Нажимая на кнопку "Отправить", Вы соглашаетесь с <a href="/oferta.pdf" target="_blank">политикой конфиденциальности</a></div>
                --}}
            </div>
        </div>
    </transition>
</div>