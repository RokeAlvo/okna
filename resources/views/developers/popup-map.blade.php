<div class="popup-wrapper" data-popup-window="map-2gis" v-if="map.show" style="display: block" v-cloak>
    <div class="popup" @click.self="{ map.show = false }">
        <div class="container">
            <div class="popup-block">
                <div id="map" style="width: 100%; height: 600px"></div>
            </div>
            <img class="developer-close-popup" src="/img/developer/icon-close.png" @click="{ map.show = false }">
        </div>
    </div>
</div>