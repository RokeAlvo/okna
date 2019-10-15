@section('styles')
    <link href="{{ url('/v2/css/popup/discount.css') }}" rel="stylesheet">
@endsection

<div :class="[canShowPopup ? 'visible-block' : '']" style="display: none;">  <!--style="display: none;"-->
    <transition id="apartment-popup-transition" appear name="fade" v-cloak> <!-- -->
        <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" id="{{ $popupType }}">
            <div class="popup popup-right" @click.self="closePopup">
                <div class="popup-body">
                    <div class="close-popup-m d-block d-md-none" @click="closePopup"><img src="/img/sign-x.png" class="sign-x"> закрыть</div>
                    <div class="close-popup d-none d-md-block" @click="closePopup"><img src="/img/close-popup.png"></div>
                    <div class="plan-image-box">
                        <img class="main-popup-img" :src="selectedLayout.main_image">
                        {{-- <div class="maxsize-wrapper">
                            <div class="maxsize-img"><img src="/img/maxsize.png"></div>
                            <div class="maxsize-text">Увеличить</div>    
                        </div> --}}
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
                                <div class="popup-apartment-specifications-title">Стоимость от:</div>
                                <div class="popup-apartment-specifications-value">@{{selectedLayout.price_min_format}} <sup>руб.</sup></div>
                            </div>
                        </div>
                        <div class="number-room-wrapper date-width d-block d-md-none">
                            <div class="popup-apartment-specifications-title m-specifications-title">Стоимость без скидки от:</div>
                            <div class="popup-apartment-specifications-value m-">@{{selectedLayout.price_min_format}} <sup>руб.</sup></div>
                        </div>

                        <div id="popup-apatrament" class="info-popup-wrapper">
                            <div class="info-popup-title accordion">
                                <span class="info-popup-title-full">Дополнительная информация</span>
                                <span class="info-popup-title-short">Доп. информация</span>
                            </div>
                            <div class="table-wrapper panel">
                                <div class="info-popup-wrapper-list">
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Срок сдачи</div>
                                        <div class="data-popup-base">{{ $residential->completion_date_range }}</div>
                                    </div>
                                    @if($residential->material)
                                        <div class="info-popup-wrapper-list-item">
                                            <div class="data-popup">Материал дома</div>
                                            <div class="data-popup-base">{{ $residential->material }}</div>
                                        </div>
                                    @endif
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Количество этажей</div>
                                        <div class="data-popup-base">@{{selectedLayout.floor_range_numbers}}</div>
                                    </div>
                                    @if($residential->full_decoration)
                                        <div class="info-popup-wrapper-list-item">
                                            <div class="data-popup">Тип отделки</div>
                                            <div class="data-popup-base">Под ключ</div>
                                        </div>
                                    @endif
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Тип парковки</div>
                                        <div class="data-popup-base">{{ $residential->count_underground_parking > 0 ? 'Подземная' : 'На территории ЖК' }}</div>
                                    </div>
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Способы покупки</div>
                                        <div class="data-popup-base">{{ $residential->getPaymentMethods(true) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="price-number-wrapper">
                            <div class="popup-phone-box">
                                <div class="popup-text-info">Узнайте цену со скидкой прямо сейчас<span>!</span></div>
                                <div class="popup-text-under">Введите номер телефона без первой «8»</div>
                            </div>
                            <div class="number-send row" v-if="!requestSend">
                                <div class="col-lg-6 col-md-12 number-placeholder">
                                    <input type="text" name="client_phone" id="client-phone"
                                           onclick="addInputMask(this)"
                                           placeholder="+7 (XXX) XXX-XX-XX">
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="number-button" @click.prevent="storeRequest('{{ getUrlPathFirstPart() }}')">
                                        <span>%</span> Узнать скидку
                                    </div>
                                </div>
                            </div>
                            <div class="popup-apartment-form-success" v-else>
                                <span>Спасибо за обращение!</span> с Вами свяжутся в течении 5 минут.
                            </div>
                        </div>
                    </div>

                    {{--<div class="all-rooms-popup  d-block d-sm-none">Все 1-комнатные</div>--}}

                       
                    </div>

                    {{-- <div class="popup-apartment-specifications-title confidential-policy d-none d-md-block">Нажимая на кнопку "Отправить",
                        Вы соглашаетесь с <a href="/oferta.pdf" target="_blank">политикой конфиденциальности</a></div> --}}
                </div>
            </div>
    </transition>
</div>