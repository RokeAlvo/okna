@extends('templates.main')

@section('head-scripts')
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
@endsection

@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="{{ url('js/residentials/pagination.js') }}"></script>
    <script src="{{ url('js/residentials/show.js') }}"></script>
    <script src="{{ url('js/popup.js') }}"></script>
@endsection

@section('title', 'Все о наиболее популярных новостройках города Новосибирска')

@section('content')
    <h1>{{ $residential->title }}</h1>
    <div class="real-estate-complex-bg" style="background-image: url({{ $residential->bg_image_original }});">
        <div class="rc-main-block-position">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-9">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="rc-main-block">
                                    <h1>{{ !empty(BUILDING_TYPES[$residential->building_type]) ? BUILDING_TYPES[$residential->building_type] : '' }}
                                        <span>&laquo;{{ $residential->title }}&raquo;</span></h1>

                                    <p>{{ $residential->description }}</p>

                                    <ul class="list-unstyled list-params mb10">
                                        <li>Застройщик:<span>{{ $residential->developer->name }}</span></li>
                                        <li>Район:
                                            <span>{{ ($residential->district) ? $residential->district->name : "Не указано" }}</span>
                                        </li>
                                        <li>Срок сдачи
                                            от:<span>{{ $residential->getHousesCompletionDatesRange() }}</span>
                                        </li>
                                        <li>Класс
                                            жилья:<span>{{ COMFORT_CLASSES[$residential->comfort_class] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                @if (!empty($residential->price_meter_from))
                                    <div class="rc-feature">
                                        <img src="{{ url('/img/price-icon.png') }}">
                                        <p>Цена от</p>
                                        <p class="rc-feature-big-number"><?= number_format($residential->price_meter_from, 0, ',', ' ') ?></p>
                                        <p>руб/м<sup>2</sup></p>
                                    </div>
                                @endif

                                @if (!empty($residential->minutes_to_metro))
                                    <div class="rc-feature">
                                        <img src="{{ url('/img/metro-icon.png') }}">
                                        <p class="rc-feature-big-number">{{ $residential->minutes_to_metro }} мин</p>
                                        <p>до станции</p>
                                        <p>метро</p>
                                    </div>
                                @endif

                                @if (!empty($residential->kilometers_to_center))
                                    <div class="rc-feature">
                                        <img src="{{ url('/img/road-with-broken-line.png') }}">
                                        <p class="rc-feature-big-number">{{ $residential->kilometers_to_center }} км</p>
                                        <p>до</p>
                                        <p>центра</p>
                                    </div>
                                @endif

                                @if (empty($residential->price_meter_from) || empty($residential->minutes_to_metro) || empty($residential->kilometers_to_center))
                                    <div class="rc-feature">
                                        <img src="/img/bus-station.png">
                                        <p class="rc-feature-big-number">{{$residential->minutes_to_bus}} мин</p>
                                        <p>до</p>
                                        <p>остановки</p>
                                    </div>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    {{--DESCRIPTION--}}

    @include('residentials.description')

    {{--APARTMENTS--}}

    @include('residentials.apartments')

    {{--FEATURES--}}

    @if (!empty($residential->features))
        @include('residentials.features')
    @endif

    {{--GALLERY--}}

    @include('residentials.gallery')

    {{--MAP--}}

    @if(\Illuminate\Support\Facades\App::environment() == 'production')
        @if (!empty($residential->latitude) && !empty($residential->longitude))
            @include('layouts.map')
        @endif
    @endif

    {{--OTHER-RC-COMPLEXES--}}
    @include('residentials.card')
@endsection