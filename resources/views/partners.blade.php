@extends('templates.main')

@section('head-scripts')
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
@endsection

@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="{{ url('js/mobileAndTabletCheck.js') }}"></script>
    <script src="{{ url('js/validateInput.js') }}"></script>
    <script src="{{ url('js/showSaleText.js') }}"></script>
    <script src="{{ url('js/addInputMask.js') }}"></script>
@endsection

@section('content')
    <div class="content">
      <div class="container mortgage block-shadow partners">

      </div>
    </div>
@endsection