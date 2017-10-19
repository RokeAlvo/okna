@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города Новосибирска')

@section('content')
    <div class="container">
        <h1>Застройщики Новосибирска</h1>
        <div id="property-developer" class="row">
            @foreach($developers as $developer)
                <div class="col-sm-6 col-md-6 col-lg-4" data-key="{{ $developer->id }}">
                    <div class="property-developer-item">
                        <div class="property-developer-item-logo">
                            <img src="{{ $developer->logo }}" alt="{{ $developer->name }}"></div>

                        <div class="property-developer-item-info">
                            <ul class="list-unstyled list-params">
                                <li>Название:<span>{{ $developer->name }}</span></li>
                                @foreach($developer->statistics->take(3) as $statistic)
                                    <li>{{ $statistic->text }}<span>{{ $statistic->number }}</span></li>
                                @endforeach
                            </ul>
                            <div class="text-center">
                                <a class="btn btn-lg btn-round btn-green btn-more"
                                   href="{{ route('developers.show', [$developer->alias]) }}">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection