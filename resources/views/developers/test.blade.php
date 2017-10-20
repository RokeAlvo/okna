@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города Новосибирска')

@section('content')
    <div class="container">
        <h1>{{ $developer->name }} ТЕСТ</h1>
        <div class="developer-detail-box">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-developer-detail">
                        <div class="mb30">
                            <img src="{{ $developer->logo }}" alt="{{ $developer->name }}">
                        </div>
                        {{ $developer->text }}
                    </div>
                </div>
            </div>

            <div class="property-developer-statistic">
                <div class="row">
                    @foreach ($developer->statistics as $statistic)
                        <div class="col-sm-five col-xs-6">
                            <div class="property-developer-statistic-item">
                                <div class="property-developer-statistic-wrapper">
                                    <div class="property-developer-statistic-number">
                                        {{ $statistic->number }}
                                    </div>
                                    <div class="property-developer-statistic-text">
                                        {{ $statistic->text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if(!$developer->features->isEmpty())
        <div class="container">
            <div class="property-developer-features">
                <h2>Особенности застройщика</h2>

                <div class="row">
                    @foreach ($developer->features as $feature)

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="property-developer-featuries-item">
                                <div class="property-developer-featuries-number">
                                    <h3>{{ $feature->title }}
                                        <span>{{ ($feature->subtitle) ? $feature->subtitle : "&nbsp;" }}</span></h3>
                                </div>
                                <div class="property-developer-featuries-text">
                                    {{ $feature->text }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <section id="residentials">
        <div class="container">

            {{--FILTERS--}}

            <div class="property-developer-search">
                <div class="row">
                    <div class="col-md-9">
                        <div class="property-developer-search-filters">
                            <div class="property-developer-search-filters-rooms">
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="1">
                                        <label for="1">Все</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="property-developer-search-filters-sliders">
                                <div class="col-md-6">
                                    слайдер 1
                                </div>
                                <div class="col-md-6">
                                    слайдер 2
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="property-developer-search-result">
                            <div class="property-developer-search-result-head">
                                результаты поиска
                            </div>
                            <div class="property-developer-search-result-value">
                                <span class="property-developer-search-result-value-number">
                                    254
                                </span>
                                <span class="property-developer-search-result-value-description">
                                    квартир подходящих под Ваш запрос
                                </span>
                            </div>
                            <div class="property-developer-search-result-button">
                                <div class="property-developer-search-result-button-left">
                                    <button>Показать</button>
                                </div>
                                <div class="property-developer-search-result-button-right">
                                    <button type="reset"><i></i><i></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--RESIDENTIALS--}}

            <div class="property-developer-rc">
                <div class="property-developer-rc-block">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="property-developer-rc-left">
                                <div class="property-developer-rc-left-content">
                                    <div class="property-developer-rc-title">
                                        <h3>Аврора</h3>
                                        <div class="property-developer-rc-info">
                                            <div class="property-developer-rc-info-item">
                                                <img src="/img/developer/icon-map.png">
                                                <div class="property-developer-rc-info-item-text">
                                                    <div class="property-developer-rc-info-item-title">
                                                        Район
                                                    </div>
                                                    <div class="property-developer-rc-info-item-description">
                                                        Кировский
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property-developer-rc-info-item">
                                                <img src="/img/developer/icon-calendar.png">
                                                <div class="property-developer-rc-info-item-text">
                                                    <div class="property-developer-rc-info-item-title">
                                                        Срок сдачи от
                                                    </div>
                                                    <div class="property-developer-rc-info-item-description">
                                                        4 квартал 2018
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="property-developer-rc-actions">
                                        <a>Способы оплаты</a>
                                        <a>Посмотреть на карте</a>
                                        <a>Подробнее о ЖК</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="property-developer-rc-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--        --}}{{--@foreach($developer->residentials as $residential)--}}{{--
            @include('residentials.card', ['residentials' => $developer->residentials])
            --}}{{--@endforeach--}}
    </div>
    </div>
    </div>
@endsection