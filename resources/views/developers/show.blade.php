@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города Новосибирска')

@section('content')
    <h1>{{ $developer->name }}</h1>

    <div class="developer-detail-box">
        <div class="row">
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

            <div class="property-developer-features">
                <h2>Особенности застройщика</h2>

                <div class="row">
                    @foreach ($developer->features as $feature)

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="property-developer-featuries-item">
                                <div class="property-developer-featuries-number">
                                    <h3>{{ $feature->title }} <span>{{ ($feature->subtitle) ? $feature->subtitle : "&nbsp;" }}</span></h3>
                                </div>
                                <div class="property-developer-featuries-text">
                                    {{ $feature->text }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            @if($developer->residentials->count())
                <div class="property-developer-residential-complex">
                    <h2>Новостройки от застройщика</h2>
                    <div class="row">
                        @foreach($developer->residentials as $residential)
                            @include('residentials.card')
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection