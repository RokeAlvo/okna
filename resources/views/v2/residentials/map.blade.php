<section id="map-rc-new">
    <div class="container">
        <h2 class="title-about-description pad-left-right">Выгодное расположение</h2>
        <div class="new-map block-shadow">


            @if($residential->infrastructures->count() >= 2)
            <div class="location-wrapper d-none d-md-block">

                <div class="location-notice-box">
                    <div class="location-notice">!</div>
                    <h3 class="location-text-title">Всего в 10 мин. ходьбы</h3>
                </div>
                <div class="location-item-box">
                    <ul class="location-list">
                        @foreach($residential->infrastructures as $infrastructure)
                        <li class="location-item"><img class="item-image" src="/img/ok.png">{{ $infrastructure->name }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

            {{-- for MOBILE --}}
            <div id="m-infrastructure" class="wrapper-location-m d-block d-md-none">
                <div class="box-shadow-border">
                    <div class="location-m accordion">Инфраструктура</div>

                    <div class="m-location-wrapper panel">
                        <ul class="m-location-list">
                            @foreach($residential->infrastructures as $infrastructure)
                            <li class="location-item"><img class="item-image" src="/img/ok.png">{{ $infrastructure->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif


            <div class="row d-none d-md-block">
                <div class="col-md-12">
                    <div class="map" id="map" style="height:690px;"></div>
                </div>
            </div>

            <div class="row d-block d-md-none">
                <div class="col-md-12">
                    <div class="map" id="mobmap"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var coords = [{{$residential->latitude}}, {{$residential->longitude}}];
    var mapOptions = {
        center: coords,
        boxZoom: false,
        closePopupOnClick: false,
        doubleClickZoom: false,
        fullscreenControl: false,
        scrollWheelZoom: false,
        zoom: 15,
        zoomControl: false,
        // dragging: false
    };
    var imageBounds = [
        [{{$residential->latitude}}+0.00351, {{$residential->longitude}}+0.007],
        [{{$residential->latitude}}-0.00351, {{$residential->longitude}}-0.007]
    ];
    var rcIcon = {
        className: '',
        html: '<div class="div-icon-rc"><img src="/img/baloon-shadow.png"></div>',
        iconAnchor: [21.5, 50]
    };
    var imageUrl = (src = "/img/baloon-n.png");


    var mobmap;
    DG.then(function () {
        mobmap = DG.map('mobmap', mapOptions);
        DG.marker(coords, {icon: DG.divIcon(rcIcon)}).addTo(mobmap);
        DG.control.zoom({position: 'topright'}).addTo(mobmap);
        DG.imageOverlay(imageUrl, imageBounds, {crossOrigin: true}).addTo(mobmap);
    });

    var mapOptionsMobile = {};
    for (var key in mapOptions) {
        mapOptionsMobile[key] = mapOptions[key];
    }
    mapOptionsMobile.center = [mapOptions.center[0], mapOptions.center[1] + 0.008];
    var map;
    DG.then(function () {
        map = DG.map('map', mapOptionsMobile);
        DG.marker(coords, {icon: DG.divIcon(rcIcon)}).addTo(map);
        DG.control.zoom({position: 'topright'}).addTo(map);
        DG.imageOverlay(imageUrl, imageBounds, {crossOrigin: true}).addTo(map);
    });

    /*$('.map').click(function () {
        if (!$(this).is(":focus")) {
            return false;
        }
    });*/

</script>