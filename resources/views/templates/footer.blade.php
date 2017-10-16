<div class="footer">
    <div class="footer-action-block">
        <div class="container">
            <p class="text-center">По любым вопросам можете связаться с нами по телефону: <span>{{ SITE_CONTACTS['phone'] }}</span></p>
        </div>
    </div>
    <div class="footer-menu-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="footer-logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ url('/img/top-logo.png') }}" alt="{{ SITE_CONTACTS['company_name'] }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="footer-social">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a href="{{ SITE_CONTACTS['vk'] }}" target="_blank" title="{{ SITE_CONTACTS['company_name'] }} в VK">
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a href="{{ SITE_CONTACTS['facebook'] }}" target="_blank"
                                           title="{{ SITE_CONTACTS['company_name'] }} в Facebook">
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a href="{{ SITE_CONTACTS['ok'] }}" target="_blank" title="{{ SITE_CONTACTS['company_name'] }} в OK">
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                <i class="fa fa-odnoklassniki fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a href="{{ SITE_CONTACTS['instagram'] }}" target="_blank"
                                           title="{{ SITE_CONTACTS['company_name'] }} в Instagram">
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <ul class="footer-menu">
                                <li><a href="{{ route('residentials.index') }}">Новостройки</a></li>
                                <li><a href="{{ route('developers.index') }}">Застройщики</a></li>
                                <li class="active"><a href="{{ route('requests.mortgage') }}">Ипотека</a></li>
                                <li><a href="{{ route('requests.contacts') }}">Контакты</a></li>
                            </ul>
                        </div>
                        {{--<div class="col-md-6 col-sm-12">
                            <ul class="footer-menu">
                                <li><a href="/coming-soon">Сотрудничество с нами</a></li>
                                <li><a href="/coming-soon">Полезные статьи</a></li>
                                <li><a href="/coming-soon">Типовые документы</a></li>
                                <li><a href="/coming-soon">О компании</a></li>
                                <li><a href="/coming-soon">Новости</a></li>
                            </ul>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; Все права защищены | {{ SITE_CONTACTS['legal_company_name'] }} | {{ date('Y') }} г.</p>
                </div>
                <div class="col-md-6 footer-adress">
                    <p>{{ SITE_CONTACTS['address'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>