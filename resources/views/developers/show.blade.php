@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города Новосибирска')

@section('content')
    <div class="container">
        <h1>{{ $developer->name }}</h1>
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
        {{--@foreach($developer->residentials as $residential)--}}
        @include('residentials.card', ['residentials' => $developer->residentials])
        {{--@endforeach--}}
        </div>
        </div>
        </div>
@endsection