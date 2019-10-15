<div class="footer">
    <div class="footer-action-block">
        <div class="container">
            <p class="text-center">По любым вопросам можете связаться с нами по телефону: <span>{!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}</span></p>
        </div>
    </div>
    <div class="footer-menu-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="footer-logo">
                                <a href="{{ url(getUrlPathFirstPart() . '/') }}">
                                    <img src="{{ url('/img/top-logo.png') }}" alt="{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            {{--@if(getUrlPathFirstPart() !== 'krasnoyarsk')--}}
                                <div class="footer-social">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <a href="{{-- SITE_CONTACTS[getUrlPathFirstPart()]['vk'] --}}" target="_blank" title="{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }} в VK">
                                                <span class="fa-stack fa-2x">
                                                    <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                    <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                            <a href="{{-- SITE_CONTACTS[getUrlPathFirstPart()]['facebook'] --}}" target="_blank"
                                            title="{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }} в Facebook">
                                                <span class="fa-stack fa-2x">
                                                    <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <a href="{{-- SITE_CONTACTS[getUrlPathFirstPart()]['ok'] --}}" target="_blank" title="{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }} в OK">
                                                <span class="fa-stack fa-2x">
                                                    <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                    <i class="fa fa-odnoklassniki fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                            <a href="{{ SITE_CONTACTS[getUrlPathFirstPart()]['instagram'] }}" target="_blank"
                                            title="{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }} в Instagram">
                                                <span class="fa-stack fa-2x">
                                                    <i class="fa fa-circle-thin fa-stack-2x fa-inverse"></i>
                                                    <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            {{--@endif--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <ul class="footer-menu">
                                <li><a href="{{ route('residentials.spa') }}">Новостройки</a></li>
                                <li><a href="{{ route('developers.index') }}">Застройщики</a></li>
                                <li class="active"><a href="{{ route('ipoteka.spa') }}">Ипотека</a></li>
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
                    <p>&copy; <a href="/oferta.pdf" class="footer-oferta" target="_blank">Политика конфиденциальности сайта</a> | {{ SITE_CONTACTS[getUrlPathFirstPart()]['legal_company_name'] }}
                        | {{ date('Y') }} г.</p>
                </div>
                <div class="col-md-6 footer-adress">
                    <p>{{ SITE_CONTACTS[getUrlPathFirstPart()]['address'] }}</p>
                </div>
            </div>
        </div>
    </div>
@php
    $mangoWidget = getMangoWidgetId();
@endphp

@if(app()->environment('production'))

    <!-- Oneretarget container -->
        <script type="text/javascript">
            (function (w, d) {
                var ts = d.createElement("script");
                ts.type = "text/javascript";
                ts.async = true;
                var domain = window.location.hostname;
                ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//tag.oneretarget.com/8524_" + domain + ".js";
                var f = function () {
                    var s = d.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(ts, s);
                };
                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                }
            })(window, document);
        </script>

        @if(!is_null($mangoWidget))
            <script>
                (function (w, d, u, i, o, s, p) {
                    if (d.getElementById(i)) {
                        return;
                    }
                    w['MangoObject'] = o;
                    w[o] = w[o] || function () {
                        (w[o].q = w[o].q || []).push(arguments)
                    };
                    w[o].u = u;
                    w[o].t = 1 * new Date();
                    s = d.createElement('script');
                    s.async = 1;
                    s.id = i;
                    s.src = u;
                    p = d.getElementsByTagName('script')[0];
                    p.parentNode.insertBefore(s, p);
                }(window, document, '//widgets.mango-office.ru/widgets/mango.js', 'mango-js', 'mgo'));
                mgo({calltracking: {id: {{ $mangoWidget }}, elements: [{"selector": ".mgo-number-{{ $mangoWidget }}"}]}});
            </script>
        @endif
    @endif
</div>