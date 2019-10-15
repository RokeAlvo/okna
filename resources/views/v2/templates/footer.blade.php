<div class="footer">
    <div class="container">
        <div class="footer-box">
            <div class="logo-confid">
                <div class="logo-footer-wrapper"><a class="logo-footer" href="{{ url(getUrlPathFirstPart() . '/') }}">ОКНА<sup>. io</sup></a></div>
                <div class="confid"><a class="links-footer" href="/oferta.pdf">Политика конфиденциальности</a></div>
            </div>
            <div class="links-footer">
                <div class="footer-menu-list"><a class="links-footer" href="#about-rc">О новостройке</a></div>
                <div class="footer-menu-list"><a class="links-footer" href="#gallery">Фото@if(!empty($residential) && $residential->video) и видео@endif</a></div>
                <div class="footer-menu-list"><a class="links-footer" href="#map-rc-new">Месторасположение</a></div>
                <div class="footer-menu-list"><a class="links-footer" href="#apartments">Квартиры</a></div>
                @if(!empty($residential->project_declaration))
                    <div class="footer-menu-list"><a class="links-footer" href="{{$residential->project_declaration}}" target="_blank">Проектная декларация</a></div>
                @endif
            </div>
            <div class="tel-box links-footer-right">
                @if ((isset($developer) && !$developer->slowpoke) || (isset($residential) && !$residential->developer->slowpoke))
                    <div class="tel-text">Телефон отдела продаж:</div> 
                @endif
                <div class="tel-number">{!!  SITE_CONTACTS[getUrlPathFirstPart()]['phone']  !!}</div>
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