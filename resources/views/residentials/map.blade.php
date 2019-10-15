<section id="map-rc-new">
    <div class="container">
        <h2>Месторасположение на карте</h2>
        <div class="new-map block-shadow">
            <div class="row">
                <div class="col-md-8">
                    <div id="map" style="height:530px;"></div>
                </div>
                <div class="col-md-4">
                    <div class="new-map-info">
                        <div class="new-map-info-block">
                            <div class="new-map-info-element">
                                <img src="/img/map-developer.png">
                                <div class="new-map-info-element-value">
                                    <div class="new-map-info-element-value-title">
                                        Застройщик:
                                    </div>
                                    <div class="new-map-info-element-value-description">
                                        {{ $residential->developer->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="new-map-info-element">
                                <img src="/img/map-residentail-complex.png">
                                <div class="new-map-info-element-value">
                                    <div class="new-map-info-element-value-title">
                                        Жилой комплекс:
                                    </div>
                                    <div class="new-map-info-element-value-description">
                                        "{{ $residential->title }}"
                                    </div>
                                </div>
                            </div>
                            <div class="new-map-info-element">
                                <img src="/img/map-placeholder.png">
                                <div class="new-map-info-element-value">
                                    <div class="new-map-info-element-value-title">
                                        Адрес:
                                    </div>
                                    <div class="new-map-info-element-value-description">
                                        {{ $residential->address }}
                                    </div>
                                </div>
                            </div>

                            @if (!$residential->isSpecific())
                                <div class="new-map-info-element">
                                    <img src="/img/map-clock.png">
                                    <div class="new-map-info-element-value">
                                        <div class="new-map-info-element-value-title">
                                            Часы работы:
                                        </div>
                                        <div class="new-map-info-element-value-description">
                                            Пн-Пт, 09:00 - 18:00
                                        </div>
                                    </div>
                                </div>
                                <div class="new-map-info-element">
                                    <img src="/img/map-telephone.png">
                                    <div class="new-map-info-element-value">
                                        <div class="new-map-info-element-value-title">
                                            Отдел продаж:
                                        </div>
                                        <div class="new-map-info-element-value-description">
                                            {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="new-map-info-element">
                                <!-- <img src="/img/map-developer.png"> -->
                                <div class="new-map-info-element-value">
                                    <div class="new-map-info-element-value-title">
                                        <!-- Застройщик: -->
                                    </div>
                                    <div class="new-map-info-element-value-description project-declaration">
                                        Ссылка на <a href="{{ $residential->project_declaration }}" target="_blank">проектную декларацию</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var map;
    DG.then(function () {
        map = DG.map('map', {
            center: [{{$residential->latitude}}, {{$residential->longitude}}],
            boxZoom: false,
            closePopupOnClick: false,
            doubleClickZoom: false,
            fullscreenControl: false,
            scrollWheelZoom: false,
            zoom: 14,
            zoomControl: false
        });

        DG.marker([{{$residential->latitude}}, {{$residential->longitude}}]).addTo(map);
        DG.control.zoom({position: 'topright'}).addTo(map);
    });
</script>