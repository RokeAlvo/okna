@extends('templates.without-sidebar')

@section('content')
    <div class="container">
        <div class="text-center">
            <h1>«Окна - новостройки»</h1>
            <h2>Выберите город для начала:</h2>
            @foreach(SITE_CONTACTS as $key => $contact)
                <h3><a href="{{ Request::url() }}/{{$key}}/">{{$loop->index + 1 . '. ' . $contact['cityNameForms'][0]}}</a></h3>
            @endforeach
        </div>
    </div>
@endsection
