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
            <div class="property-developer-search">
                <div class="row">
                    <div class="col-md-9">
                        <div class="property-developer-search-filters">
                            <div class="property-developer-search-filters-rooms">
                                <div class="property-developer-search-filters-rooms-item">
                                    <input type="checkbox">
                                    <lable>Все</lable>
                                </div>
                                <div class="property-developer-search-filters-rooms-item">
                                    <input type="checkbox">
                                    <lable>1-ком.</lable>
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
                                <span></span>
                                <span></span>
                            </div>
                            <div class="property-developer-search-result-button">
                                <button>Показать</button>
                                <span></span>
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