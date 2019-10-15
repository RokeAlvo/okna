<div class="popup-wrapper popup-wrapper-pc" data-popup-window="map-2gis" v-if="map.show" v-cloak>
    <div class="popup-map popup-map-mob popup-map-right" @click.self="closeMap">
        <div class="dev-close-popup-m" @click="closeMap"><img src="/img/sign-x.png">Закрыть</div><div class="container popup-map-body" @click.self="closeMap">
            <div class="container-center">
                
            <div class="popup-block-dev">
                <div id="map" class="dev-poppup-map"></div>
                
                <img class="dev-close-popup" src="/img/developer/close-popup-dev.svg" @click.self="closeMap">
                <div class="right-info-map">
                    <div class="dev-popup-main-info-wrapper">
                        <div class="name-rc-developer-popup">@{{mapResidential.title}}</div>
                        <div class="main-info-rc-popup-wrapper">
                            <div class="main-info-rc-popup">
                                <div class="icon-info-rc-popup"><img class="" src="/img/developer/baloon-map-green.svg"></div>
                                <div class="data-info-rc-dev">@{{mapResidential.address}}</div>
                            </div>
                            <div class="main-info-rc-popup">
                                <div class="icon-info-rc-popup"><img class="" src="/img/developer/calendar-green.svg"></div>
                                <div class="data-info-rc-dev">@{{mapResidential.completion_date_full}}</div>
                            </div>
                        </div>
                        <table class="table-dev-popup dis-m-table-none">
                            <tr v-for="range in mapResidential.mergedRanges" v-if="range.apartments_count > 0">
                                <td>@{{ range.room_label }}</td>
                                <td>от @{{ numberFormat(range.price_min) }} р. - @{{ numberFormat(range.price_max) }} р.</td>
                                <td>@{{ (+(range.area_min)).toFixed(0) }} м<sup>2</sup> - @{{ (+(range.area_max)).toFixed(0) }} м<sup>2</sup></td>
                            </tr>
                            <tr>
                                <td>4-ком.+</td>
                                <td colspan="2" align="center">Узнавайте в отделе продаж</td>
                                <td ></td>
                            </tr>
                        </table>
                        <table class="table-dev-popup dis-m-table table-dev-popup-m">
                            <tr v-for="range in mapResidential.mergedRanges" v-if="range.apartments_count > 0">
                                <td>@{{ range.room_label }}</td>
                                <td>от @{{ numberFormat(range.price_min) }} р.</td>
                            </tr>
                            <tr>
                                <td>4-ком.+</td>
                                <td colspan="2" align="center"><img class="table-phone-img" src="/img/developer/phone-gray.svg"> По запросу</td>
                                <td ></td>
                            </tr>
                        </table>
                        <div class="all-info-dev-popup-wrapper">
                                <div class="row-data-dev-wrapper" v-if="mapResidential.metro_station">
                                <div class="column-name">Станция метро</div><div class="column-data">@{{mapResidential.metro_station.name}}</div>
                                </div>
                                <div class="row-data-dev-wrapper" v-if="mapResidential.material">
                                <div class="column-name">Материал дома</div><div class="column-data">@{{mapResidential.material}}</div>
                                </div>
                                <div class="row-data-dev-wrapper" v-if="mapResidential.full_decoration">
                                    <div class="column-name">Варианты отделки</div><div class="column-data">Чистовая</div>
                                </div>
                                <div class="row-data-dev-wrapper" >
                                    <div class="column-name">Этажность</div><div class="column-data">@{{mapResidential.houses_floor_range}}</div>
                                </div>
                                <div class="row-data-dev-wrapper" >
                                <div class="column-name">Тип парковки</div><div class="column-data">@{{mapResidential.count_underground_parking > 0 ? 'Подземная' : 'На территории ЖК' }}</div>
                                </div>
                                <div class="row-data-dev-wrapper" v-if="mapResidential.payment_methods">
                                    <div class="column-name">Способы покупки</div> <div class="column-data">@{{mapResidential.payment_methods}}</div>
                                </div>
                        </div>


                    </div>
                    <div class="step-by-rc"><a :href="mapResidential.routeShow" target="_blank" >Перейти на страницу ЖК <img src="/img/developer/arrow-right-gray.svg"></a></div>
                    <a class="button-more-info-rc button-more-info-rc-link" :href="mapResidential.routeShow" target="_blank" ><div class="button-more-in-popup" >Подробнее о ЖК</div></a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

{{--<div class="popup-wrapper popup-wrapper-pc" data-popup-window="map-2gis" v-if="map.show" v-cloak><div class="dev-close-popup-m" @click="closeMap"><img src="/img/developer/close-popup-white.svg">Закрыть</div><div class="container popup-map-body" @click.self="closeMap">
    <div class="popup-map popup-map-mob popup-map-right" @click.self="closeMap">
        
            <div class="container-center">
                
            <div class="popup-block-dev">
                <div id="map" class="dev-poppup-map"></div>
                
                <img class="dev-close-popup" src="/img/developer/close-popup-dev.svg" @click.self="closeMap">
                <div class="right-info-map">
                    <div class="dev-popup-main-info-wrapper">
                        <div class="name-rc-developer-popup">Стрижи на Кирова</div>
                        <div class="main-info-rc-popup-wrapper">
                            <div class="main-info-rc-popup">
                                <div class="icon-info-rc-popup"><img class="" src="/img/developer/baloon-map-green.svg"></div>
                                <div class="data-info-rc-dev">Гагаринская 27</div>
                            </div>
                            <div class="main-info-rc-popup">
                                <div class="icon-info-rc-popup"><img class="" src="/img/developer/calendar-green.svg"></div>
                                <div class="data-info-rc-dev">IV квартал 2019</div>
                            </div>
                        </div>
                        <table class="table-dev-popup dis-m-table-none">
                            <tr v-for="range in mapResidential.mergedRanges" v-if="range.apartments_count > 0">
                                <td>@{{ range.room_label }}</td>
                                <td>от @{{ numberFormat(range.price_min) }} р. - @{{ numberFormat(range.price_max) }} р.</td>
                                <td>@{{ range.area_min.toFixed(0) }} м<sup>2</sup> - @{{ range.area_max.toFixed(0) }} м<sup>2</sup></td>
                            </tr>
                            <tr>
                                <td>4-ком.+</td>
                                <td colspan="2" align="center">Узнавайте в отделе продаж</td>
                                <td ></td>
                            </tr>
                        </table>
                        <table class="table-dev-popup dis-m-table table-dev-popup-m">
                            <tr v-for="range in mapResidential.mergedRanges" v-if="range.apartments_count > 0">
                                <td>@{{ range.room_label }}</td>
                                <td>от @{{ numberFormat(range.price_min) }} р.</td>
                            </tr>
                            <tr>
                                <td>4-ком.+</td>
                                <td colspan="2" align="center"><img class="table-phone-img" src="/img/developer/phone-gray.svg"> По запросу</td>
                                <td ></td>
                            </tr>
                        </table>
                        <div class="all-info-dev-popup-wrapper">
                                <div class="row-data-dev-wrapper" v-if="mapResidential.metro_station">
                                <div class="column-name">Станция метро</div><div class="column-data">@{{mapResidential.metro_station.name}}</div>
                                </div>
                                <div class="row-data-dev-wrapper" v-if="mapResidential.material">
                                <div class="column-name">Материал дома</div><div class="column-data">@{{mapResidential.material}}</div>
                                </div>
                                <div class="row-data-dev-wrapper" v-if="mapResidential.full_decoration">
                                    <div class="column-name">Варианты отделки</div><div class="column-data">Чистовая</div>
                                </div>
                                <div class="row-data-dev-wrapper" >
                                    <div class="column-name">Этажность</div><div class="column-data">@{{mapResidential.houses_floor_range}}</div>
                                </div>
                                <div class="row-data-dev-wrapper" >
                                <div class="column-name">Тип парковки</div><div class="column-data">@{{mapResidential.count_underground_parking > 0 ? 'Подземная' : 'На территории ЖК' }}</div>
                                </div>
                                <div class="row-data-dev-wrapper" v-if="mapResidential.payment_methods">
                                    <div class="column-name">Способы покупки</div> <div class="column-data">@{{mapResidential.payment_methods}}</div>
                                </div>
                        </div>


                    </div>
                    <div class="step-by-rc"><a :href="mapResidential.routeShow" target="_blank" >Перейти на страницу ЖК <img src="/img/developer/arrow-right-gray.svg"></a></div>
                    <a class="button-more-info-rc button-more-info-rc-link" :href="mapResidential.routeShow" target="_blank" ><div class="button-more-in-popup" >Подробнее о ЖК</div></a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>--}}