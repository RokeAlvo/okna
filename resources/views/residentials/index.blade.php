@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города Новосибирска')

@section('content')
    <div class="container">
    <h1>Новостройки Новосибирска</h1>
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
                                                    сдачи:<span>{{ !empty(QUARTERS['full'][$residential->completion_decade]) ? QUARTERS['full'][$residential->completion_decade] : '' }} {{ $residential->completion_year }}</span>
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
            {{ $residentials->render() }}
        </div>
    </div>
    </div>
@endsection