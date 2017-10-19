<section id="apartments">
    <template id="pagination-template">
        <ul class="pagination">
            {{--<li class="first"><span v-if="hasFirst()" @click="changePage(1)">В начало</span></li>--}}
            <li class="prev" :class="{ disabled: current == 1 }"><span @click="changePage(prevPage)">«</span></li>
            <li v-for="page in pages" :class="{ active: current == page }"><span @click="changePage(page)">@{{ page }}</span></li>
            <li class="next" :class="{ disabled: current == totalPages }"><span @click="changePage(nextPage)">»</span></li>
            {{--<li class="last"><span v-if="hasLast()" @click="changePage(totalPage)">В конец</span></li>--}}
        </ul>
    </template>
    <div class="container" id="layouts-vue">
        <h2>Квартиры от застройщика</h2>

        {{--APARTMENTS-MOBILE--}}

        <div class="panel-group visible-sm visible-xs" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($residential->ranges as $range)
                <div class="panel">
                    <div class="panel-heading" role="tab" id="headingroom-{{$range->rooms}}">
                        <div class="panel-heading-button collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseroom-{{$range->rooms}}" aria-expanded="true"
                             aria-controls="collapseroom-{{$range->rooms}}">
                            <div class="apartment-acc-info">
                                <div class="apartment-acc-info-room">
                                    {{ $range->getRoomLabel() }}
                                </div>
                                <div class="apartment-acc-info-price">
                                    {{ $range->getPriceRange() }} руб.
                                </div>
                            </div>
                            <div class="apartment-acc-amount" @click="fetchOneRoomLayouts('{{$range->rooms}}')">
                                @php($layoutCount = $residential->layouts->where('rooms', $range->rooms)->count())
                                {{ $layoutCount }} {{ number($layoutCount, ['вариант', 'варианта', 'вариантов']) }}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div id="collapseroom-{{$range->rooms}}" role="tabpanel" aria-labelledby="headingroom-{{$range->rooms}}">
                        <div class="visible-xs visible-sm" v-if="room == {{$range->rooms}}">
                            <div class="row">
                                @include('layouts.card', ['layoutsData' => 'oneRoomLayouts'])
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{--APARTMENTS-DESKTOP--}}

        <div class="visible-md visible-lg">
            <form class="apartment_filter">
                <div class="apartment_filter_number_rooms2">
                    <div class="row">
                        <div class="col-xs-five">
                            <div class="apartment_filter_number_rooms_group">
                                <input type="checkbox" name="rooms" v-model="allRoomCheckbox" @change="checkAllRooms">
                                <label for="all-rooms">
                                    <div class="type-rooms-vlaue">Все</div>
                                    <div class="cost-distance">
                                        {{ number_format($residential->ranges->min('price_min'), 0, ',', ' ') }}
                                        - {{ number_format($residential->ranges->max('price_max'), 0, ',', ' ') }} руб.
                                    </div>
                                </label>
                            </div>
                        </div>
                        @foreach($residential->ranges as $range)
                            <div class="col-xs-five">
                                <div class="apartment_filter_number_rooms_group">
                                    <input type="checkbox" name="rooms" id="room-{{$range->id}}" value="{{$range->rooms}}" v-model="rooms" @change="fetchLayouts(1)">
                                    <label for="room-{{$range->id}}">
                                        <div class="type-rooms-vlaue">
                                            {{ $range->getRoomLabel() }}
                                        </div>
                                        <div class="cost-distance">
                                            {{ $range->getPriceRange() }} руб.
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="apartment-filter-cost-area-floor">
                    <div class="row">
                        <div class="col-xs-five">
                            <div class="apartment-filter-area">
                                <p>Площадь, м<sup>2</sup>:</p>
                                <input name="area_range[min]" placeholder="30" v-model="areaRange[0]" @change="fetchLayouts(1)">
                                <span class="h-sep"></span>
                                <input name="area_range[max]" placeholder="145" v-model="areaRange[1]" @change="fetchLayouts(1)">
                            </div>
                        </div>
                        <div class="col-xs-five">
                            <div class="apartment-filter-floor">
                                <p>Этаж:</p>
                                <input name="floor_range[min]" placeholder="1" v-model="floorRange[0]" @change="fetchLayouts(1)">
                                <span class="h-sep"></span>
                                <input name="floor_range[max]" placeholder="24" v-model="floorRange[1]" @change="fetchLayouts(1)">
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="apartment_filter_buttons">
                                <div class="apartment-filter-buttons-container">
                                    {{--<button class="apartment_filter_buttons_apply" type="button">Показать
                                        результаты
                                    </button>--}}
                                    {{--<button class="apartment_filter_buttons_reset" type="reset">Сбросить
                                        фильтры
                                    </button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="preview-apartment">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row">
                            <div>
                                <div v-if="fetching">Загрузочка</div>
                                <div v-else id="search-new-layout-flats" class="list-view">
                                    @include('layouts.card', ['layoutsData' => 'layouts'])
                                    <div class="col-xs-12">
                                        <pagination :current="currentPage" :perPage="perPage" :total="totalLayouts" @page-changed="fetchLayouts" v-if="totalLayouts > perPage"></pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.popup')
    </div>
</section>