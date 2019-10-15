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
    <div class="container">
        <h1>Контакты</h1>
        <div class="block-shadow">
            <div id="contact-map">
                <script>
                    var map;
                    DG.then(function () {
                        map = DG.map('contact-map', {
                            center: {{ SITE_CONTACTS[getUrlPathFirstPart()]['geo_coords'] }},
                            zoom: 15,
                            boxZoom: false,
                            closePopupOnClick: false,
                            doubleClickZoom: false,
                            fullscreenControl: false
                            //scrollWheelZoom: false,
                            //zoomControl: false
                        });
                        DG.marker({{ SITE_CONTACTS[getUrlPathFirstPart()]['geo_coords'] }}).addTo(map);
                    });
                </script>
            </div>

            <div class="contacts">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Контактная информация</h3>

                        <div class="contact-info">
                            <ul>
                                <li><i class="fa fa-circle"></i> {{ SITE_CONTACTS[getUrlPathFirstPart()]['address'] }}</li>
                                <li><i class="fa fa-circle"></i> {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</li>
                                <li><i class="fa fa-circle"></i> ПН - ПТ с 9:00 до 20:00 | СБ, ВС выходной</li>
                                <li><i class="fa fa-circle"></i> {{ SITE_CONTACTS[getUrlPathFirstPart()]['email'] }}</li>
                            </ul>
                        </div>
                    </div>
                    {{--<div class="col-md-6">
                        <h3>Форма обратной связи</h3>
                        <form id="contact-form" class="custom-form" action="{{ getRequestStoreRoute() }}" method="post">
                            {{csrf_field()}}
                            <input type="hidden"  class="form-control" name="type" value="3">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group field-contactform-name required">
                                        <input type="text" id="contactform-name" class="form-control" name="client_name" placeholder="Ваше имя" aria-required="true">
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group field-contactform-phone required">
                                        <input type="tel" id="client_phone" class="form-control" name="client_phone" placeholder="Контактный телефон" onclick="addInputMask(this)" aria-required="true">
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group field-contactform-comment required">
                                <textarea id="contactform-comment" class="form-control" name="comment" rows="6" placeholder="Ваше сообщение" aria-required="true"></textarea>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-lg btn-custom-lg btn-green" name="contact-button" type="submit">Отправить</button>
                            </div>
                            <div class="form-group oferta">
                                Нажимая на кнопку "Отправить", Вы соглашаетесь с <a href="/oferta.pdf" target="_blank">политикой конфиденциальности</a>
                            </div>
                        </form>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection