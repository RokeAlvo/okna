{{-- Google Analytics --}}
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-86186445-3', 'auto');
    ga('send', 'pageview');
</script>

{{-- Google Remarketing --}}
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt=""
             src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/875956403/?guid=ON&amp;script=0"/>
    </div>
</noscript>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 875956403;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 829808782;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/829808782/?guid=ON&amp;script=0"/>
    </div>
</noscript>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                    @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]))
                        w.yaCounter{{SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']}} = new Ya.Metrika2({
                            id:{{SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']}},
                            clickmap: true,
                            trackLinks: true,
                            accurateTrackBounce: true,
                            webvisor: true
                        });
                    @endif
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }

    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript>
    <div>
            @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]))
                <img src="https://mc.yandex.ru/watch/@php echo SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'];@endphp" style="position:absolute; left:-9999px;" alt=""/>
            @endif
    </div>
</noscript>
<!-- /Yandex.Metrika counter -->