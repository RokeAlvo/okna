@extends('templates.main')

@section('content')
    <div class="container">
        <h1>Ипотека на квартиры в Новостройках</h1>
        <div class="mortgage block-shadow">
            <div class="row">
                <div class="col-md-6 no-pright">
                    <div class="mortgage-bg"></div>
                </div>
                <div class="col-md-6 no-pleft">
                    <div class="mortgage-info-block">
                        <div class="mortgage-features">
                            <div class="row">
                                <div class="col-md-4">
                                    <sup>от</sup> <span>0%</span>
                                    <p>первоначальный взнос</p>
                                </div>
                                <div class="col-md-4">
                                    <sup>от</sup> <span>9%</span>
                                    <p>ежегодная <br>ставка</p>
                                </div>
                                <div class="col-md-4">
                                    <sup>до</sup> <span>30</span>
                                    <p>лет, срок кредитования</p>
                                </div>
                            </div>
                        </div>
                        <div class="mortgage-description">
                            <ol>
                                <li>Вы сами решаете в каком банке хотите кредитоваться.</li>
                                <li>Минимальный пакет документов.</li>
                                <li>Положительный решение можно получить за 1 день.</li>
                                <li>Помощь со сбором и оформленим всех документов.</li>
                            </ol>
                            <form id="form-request" class="custom-form" action="" method="post">
                                {{csrf_field()}}

                                <input type="hidden" id="actionform-form_name" class="form-control" name="type"
                                       value="3">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group field-actionform-user_phone required">

                                            <input type="text" id="actionform-user_phone" class="form-control"
                                                   name="client_phone"
                                                   placeholder="Ваш номер телефона" aria-required="true"
                                                   data-plugin-inputmask="inputmask_0ffde171">

                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit"
                                                class="btn btn-block btn-lg btn-yellow btn-custom-lg btn-round"><i
                                                    class="fa fa-mobile fa-lg mr15" aria-hidden="true"></i>Заявка на
                                            ипотеку
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="mortgage-info-privacy">
                            <i class="fa fa-lock"></i> Ваши данные строго конфиденциальны и не будут переданы третьим
                            лицам
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection