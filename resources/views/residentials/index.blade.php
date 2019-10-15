@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][1])

@section('footer-scripts')
    <script src="{{ url('js/residentials/accordion.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <h1>Новостройки {{SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][1]}}</h1>
        <div class="row">
            <div class="col-md-3 col-md-4">
                <form class="new-building-filter" method="get" action="{{ route('residentials.index') }}">
                    {{--Price Range--}}
                    <div class="new-building-filter-block">
                        <div class="new-building-filter-block-title" data-accordion-title="priceRange">
                            <i class="accordion-triangle"></i><span>Цена в тыс. руб.</span>
                        </div>
                        <div class="new-building-filter-block-content" data-accordion-content="priceRange">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="new-building-filter-block-item">
                                        <div class="new-building-filter-block-item-left">
                                            <label for="priceFrom">От</label>
                                        </div>
                                        <div class="new-building-filter-block-item-right">
                                            <input id="priceFrom" type="number" min="500" max="100000" step="10" name="price_range[]" value="@if(isset($_GET['price_range'][0])){{$_GET['price_range'][0]}}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="new-building-filter-block-item">
                                        <div class="new-building-filter-block-item-left">
                                            <label for="priceTo">До</label>
                                        </div>
                                        <div class="new-building-filter-block-item-right">
                                            <input id="priceTo" type="number" min="700" max="100000" step="10" name="price_range[]" value="@if(isset($_GET['price_range'][1])){{$_GET['price_range'][1]}}@endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Number Rooms--}}
                    <div class="new-building-filter-block">
                        <div class="new-building-filter-block-title" data-accordion-title="numberRooms">
                            <i class="accordion-triangle"></i><span>Кол-во комнат</span>
                        </div>
                        <div class="new-building-filter-block-content" data-accordion-content="numberRooms">
                            <div class="row">
                                @foreach(ROOMS['short'] as $value => $label)
                                    @if(empty(ROOMS['merge'][$value]))
                                        <div class="col-md-6 col-sm-6">
                                            <div class="new-building-filter-block-item">
                                                <input id="room-{{$value}}" type="checkbox" name="rooms[{{$value}}]" value="{{$value}}"@if(isset($_GET['rooms'][$value])){!!' checked'!!}@endif><label for="room-{{$value}}">{{$label}}</label>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{--Area Range--}}
                    <div class="new-building-filter-block">
                        <div class="new-building-filter-block-title" data-accordion-title="areaRange">
                            <i class="accordion-triangle"></i><span>Площадь в м<sup>2</sup></span>
                        </div>
                        <div class="new-building-filter-block-content" data-accordion-content="areaRange">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="new-building-filter-block-item">
                                        <div class="new-building-filter-block-item-left">
                                            <label for="areaFrom">От</label>
                                        </div>
                                        <div class="new-building-filter-block-item-right">
                                            <input id="areaFrom" name="area_range[]" type="number" min="1" max="500" step="1" value="@if(isset($_GET['area_range'][0])){{$_GET['area_range'][0]}}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="new-building-filter-block-item">
                                        <div class="new-building-filter-block-item-left">
                                            <label for="areaTo">До</label>
                                        </div>
                                        <div class="new-building-filter-block-item-right">
                                            <input id="areaTo" name="area_range[]" type="number" min="1" max="500" step="1" value="@if(isset($_GET['area_range'][1])){{$_GET['area_range'][1]}}@endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Deadline--}}
                    <div class="new-building-filter-block">
                        <div class="new-building-filter-block-title" data-accordion-title="deadline">
                            <i class="accordion-triangle"></i><span>Срок сдачи</span>
                        </div>
                        <div class="new-building-filter-block-content" data-accordion-content="deadline">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="new-building-filter-block-item">
                                        <div class="new-building-filter-block-item-left">
                                            <label for="priceFrom">От</label>
                                        </div>
                                        <div class="new-building-filter-block-item-right">
                                            <select id="deadlineFrom" name="completion_date_range[]">
                                                <option value="">-</option>
                                                <option value="-1">Сдан</option>
                                                @foreach($completionDatesList as $key => $date)
                                                    <option value="{{$key}}"@if(isset($_GET['completion_date_range'][0]) && $_GET['completion_date_range'][0] == $key){{ ' selected' }}@endif>{{$date}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="new-building-filter-block-item">
                                        <div class="new-building-filter-block-item-left">
                                            <label for="priceTo">До</label>
                                        </div>
                                        <div class="new-building-filter-block-item-right">
                                            <select id="deadlineTo" name="completion_date_range[]">
                                                <option value="">-</option>
                                                <option value="-1">Сдан</option>
                                                @foreach($completionDatesList as $key => $date)
                                                    <option value="{{$key}}"@if(isset($_GET['completion_date_range'][1]) && $_GET['completion_date_range'][1] == $key){{ ' selected' }}@endif>{{$date}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Districts--}}
                    <div class="new-building-filter-block">
                        <div class="new-building-filter-block-title collapsed" data-accordion-title="districts">
                            <i class="accordion-triangle"></i><span>Районы</span>
                        </div>
                        <div class="new-building-filter-block-content  collapse-in" data-accordion-content="districts">
                            <div class="row">
                                {{--@php(dd($_GET))--}}
                                @foreach($districts as $district)
                                    <div class="col-md-12 col-sm-6">
                                        <div class="new-building-filter-block-item">
                                            <input id="district-{{$district->id}}" type="checkbox" name="districts[{{$district->id}}]" value="{{$district->id}}"@if(isset($_GET['districts'][$district->id])){!!' checked'!!}@endif><label for="district-{{$district->id}}">{{$district->name}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{--Button--}}
                    <div class="new-building-filter-block">
                        <button class="new-building-filter-button" type="submit">Показать</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-9 col-md-8">
                <div id="search-new-buildings" class="list-view">
                    @foreach($residentials as $residential)
                        <div class="new-building-item" data-key="{{ $residential->id }}">
                            <div class="row">
                                <div class="col-lg-10 col-md-12">
                                    <div class="new-building-main-block block-shadow">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-6">
                                                <div class="new-building-image">
                                                    <a href="{{ route('residentials.show', [$residential->alias]) }}">
                                                        <div class="new-building-image-background"
                                                             style="background-image: url({{ $residential->thumbnail }}); "></div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6 col-sm-6">
                                                <div class="new-building-info">
                                                    <div class="new-building-title">
                                                        <a href="{{ route('residentials.show', [$residential->alias]) }}">{{ $residential->title }}</a></div>
                                                    <ul class="list-unstyled list-params">
                                                        <li>Район: <span>{{ !empty($residential->district) ? $residential->district->name : '' }}</span></li>
                                                        <li>Застройщик: <span>{{ $residential->developer->name }}</span></li>
                                                        <li>Срок
                                                            сдачи от:<span>{{ $residential->getCompletionDate() }}</span>
                                                        </li>
                                                        <li>Класс
                                                            жилья:<span>{{ !empty(COMFORT_CLASSES[$residential->comfort_class]) ? COMFORT_CLASSES[$residential->comfort_class] : '-' }}</span>
                                                        </li>
                                                    </ul>
                                                    <div class="new-building-footer">
                                                        @if(!empty($residential->price_meter_from))
                                                            <div class="new-building-price-from pull-left">
                                                                <p>Цена от:</p>
                                                                <p class="new-building-price-from-value">
                                                                    <span>{{ number_format($residential->price_meter_from, 0, '.', ' ') }}</span>
                                                                    <i class="fa fa-ruble"></i>/М<sup>2</sup>
                                                                </p>
                                                            </div>
                                                        @endif
                                                        <div class="new-building-more-info pull-right">
                                                            <a class="btn  btn-lg btn-round btn-green btn-custom-lg btn-more"
                                                               href="{{ route('residentials.show', [$residential->alias]) }}">Подробнее</a></div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <div class="new-building-range-prices">
                                        <div class="row">
                                            @foreach($residential->ranges as $range)
                                                <div class="col-lg-12 col-md-4 col-sm-4">
                                                    <div class="new-building-range-item block-shadow">
                                                        <div class="new-building-range-item-title">
                                                            {{ ROOMS['full'][$range->rooms] }} {{ $range->plus }}
                                                        </div>
                                                        <div class="new-building-range-item-area">
                                                            от {{ $range->area_min }} м<sup>2</sup> до {{ $range->area_max }} м<sup>2</sup></div>
                                                        <div class="new-building-range-item-cost">
                                                            {{ number_format($range->price_min, 0, ',', ' ') }} р.
                                                            - {{ number_format($range->price_max, 0, ',', ' ') }} р.
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $residentials->appends(request()->query())->render() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection