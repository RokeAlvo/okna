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
    <script src="{{ url('js/residentials/apartment-tooltip.js') }}"></script>
@endsection

@section('title', 'Все о наиболее популярных новостройках города Новосибирска')

@section('content')

    {{--RC-MAIN-BLOCK--}}

    @include('residentials.rc-main-block')


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
    @if(!$residential->developer->residentials->isEmpty())
    @include('residentials.card', ['residentials' => $residential->developer->residentials])
    @endif
@endsection