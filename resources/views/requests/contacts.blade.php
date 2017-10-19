@extends('templates.main')

@section('head-scripts')
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>
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
                            center: {{ SITE_CONTACTS['geo_coords'] }},
                            zoom: 15,
                            boxZoom: false,
                            closePopupOnClick: false,
                            doubleClickZoom: false,
                            fullscreenControl: false
                            //scrollWheelZoom: false,
                            //zoomControl: false
                        });
                        DG.marker({{ SITE_CONTACTS['geo_coords'] }}).addTo(map);
                    });
                </script>
            </div>

            <div class="contacts">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Контактная информация</h3>

                        <div class="contact-info">
                            <ul>
                                <li><i class="fa fa-circle"></i> {{ SITE_CONTACTS['address'] }}</li>
                                <li><i class="fa fa-circle"></i> {{ SITE_CONTACTS['phone'] }}</li>
                                <li><i class="fa fa-circle"></i> ПН - ПТ с 9:00 до 18:00 | СБ, ВС выходной</li>
                                <li><i class="fa fa-circle"></i> {{ SITE_CONTACTS['email'] }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Форма обратной связи</h3>
                        <form id="contact-form" class="custom-form" action="/contacts" method="post">
                            <input type="hidden" name="_csrf-frontend"
                                   value="OXlISHhaMWNIGCMjOgtAJgAUOx8OOGcTUSMODkgcZxldLD0/LyxmPA==">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group field-contactform-name required">

                                        <input type="text" id="contactform-name" class="form-control"
                                               name="ContactForm[name]" placeholder="Ваше имя"
                                               aria-required="true">

                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group field-contactform-phone required">

                                        <input type="text" id="contactform-phone" class="form-control"
                                               name="ContactForm[phone]"
                                               placeholder="Контактный телефон" aria-required="true">

                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group field-contactform-comment required">
                            <textarea id="contactform-comment" class="form-control" name="ContactForm[comment]" rows="6"
                                      placeholder="Ваше сообщение"
                                      aria-required="true"></textarea>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-lg btn-custom-lg btn-green"
                                        name="contact-button">Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection