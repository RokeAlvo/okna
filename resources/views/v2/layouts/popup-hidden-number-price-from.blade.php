@section('styles')
    <link href="{{ url('/v2/css/popup/hidden-number-price-from.css') }}" rel="stylesheet">
@endsection

<div v-cloak>  <!--style="display: none;"-->
    <transition id="apartment-popup-transition" appear name="fade" v-cloak> <!-- -->
        <div class="popup-wrapper" v-if="~selectedLayoutIndex" data-popup-window="apartment" id="{{ $popupType }}">
            <div class="close-popup-m" @click="closePopup"><img src="/img/sign-x.png" class="sign-x"> закрыть</div>
            <div class="popup popup-right" @click.self="closePopup">
                <div class="popup-body">
                    
                    <div class="close-popup d-none d-md-block" @click="closePopup"><img src="/img/close-popup.png"></div>
                    <div class="img-popup-arrow-back  d-block d-md-none"  @click="closePopup"><img src="/img/arrow-left-gray.png"></div>
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
                                <div class="popup-apartment-specifications-title">Стоимость от:</div>
                                <div class="popup-apartment-specifications-value">@{{selectedLayout.price_min_format}} <sup>руб.</sup></div>
                            </div>
                        </div>
                        <div class="number-room-date date-width d-block d-md-none">
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
                                        <div class="data-popup-base">@{{ selectedLayoutResidential.completion_date_range }}</div>
                                    </div>
                                    <div class="info-popup-wrapper-list-item" v-if="selectedLayoutResidential.material">
                                        <div class="data-popup">Материал дома</div>
                                        <div class="data-popup-base">@{{ selectedLayoutResidential.material }}</div>
                                    </div>
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Этажность дома</div>
                                        <div class="data-popup-base">@{{ selectedLayoutResidential.houses_floor_range }}</div>
                                    </div>
                                    <div class="info-popup-wrapper-list-item" v-if="selectedLayoutResidential.full_decoration">
                                        <div class="data-popup">Тип отделки</div>
                                        <div class="data-popup-base">Под ключ</div>
                                    </div>
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Тип парковки</div>
                                        <div class="data-popup-base">@{{ selectedLayoutResidential.count_underground_parking > 0 ?
                                            'Подземная' : 'На территории ЖК' }}
                                        </div>
                                    </div>
                                    <div class="info-popup-wrapper-list-item">
                                        <div class="data-popup">Способы покупки</div>
                                        <div class="data-popup-base">@{{ selectedLayoutResidential.payment_methods }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="sale-phone-wrapper d-none d-md-block">
                                <div class="tabs-wrapper">
                                    <div class="button-wrapper">
    
                                        <div class="d-none d-md-block" v-for="tab in tabs" v-bind:key="tab[0]" v-bind:class="['tab-button', { 'tab-active': currentTab[0] === tab[0] }]"
                                            v-on:click="currentTab = tab">@{{ tab[1] }}
                                        </div>
    
                                        <div class="d-block d-md-none">
                                        </div>
    
                                    </div>
                                    <keep-alive>
                                    <component v-bind:is="currentTabComponent" class="tab"></component>
                                    </keep-alive>
                                </div>
                            </div>
    
                            {{-- for Mobile --}}
    
                            {{-- <div class="sale-phone-wrapper  d-block d-md-none" id="tab-mobile">
                                    <keep-alive>
                                            <component v-bind:is="currentTabComponent" class="tab"></component>
                                        </keep-alive>
                            </div> --}}
    
                            <div class="sale-phone-wrapper m-min-height d-block d-md-none">
                                <div class="m-sale-phone-box" id="tab1-mobile" ref="mobileSalePhone">
                                    <div class="m-phone-title">Отдел продаж</div>
                                    <div class="m-phone-text">Ежедневно<br>с 08:00 до 20:00</div>
                                    <div class="m-button-wrapper">
                                        <div class="m-call-button padd-button"><img src="/img/phone-white.png">
                                            <a class="main-phone" href="tel:+73833884896">Позвонить</a></div>
                                        <div class="m-call-back"  @click="showCallBack(true)">Обратный звонок</div>
                                    </div>
                                </div>
    
                                <div class="m-sale-phone-box2" id="tab2-mobile" ref="mobileCallBack">
                                    <div class="m-button-back" @click="showCallBack(false)">Назад</div>
                                    <div class="m-phone-title2">Обратный звонок</div>
                                    <div class="m-button-wrapper">
                                        <div class="m-number-placeholder">
                                            <input type="text" name="client_phone" id="client-phone" onclick="addInputMask(this)"
                                            placeholder="+7 (XXX) XXX-XX-XX">
                                        </div>
                                        <div class="m-call-button m-mar-bot0">Отправить</div>
                                    </div>
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