<div class="rooms-plan-box d-none d-md-block" v-for="(layout, index) in {{ $layoutsData }}" @click="selectLayout(layout, index)">
    <div class="rooms-wrapper">
    {{-- <div class="rooms-wrapper-dev" v-if="typeof residential !== 'undefined'">
            <div class="rooms-plan-box-title-wrapper">
                <div class="rooms-plan-box-title">ЖК @{{ residential.title }}</div>
                <div class="rooms-plan-box-title-was-passed">@{{ residential.completion_date }}</div>
            </div> 
        </div>--}}
        <div class="rooms-plan-img">
            <img :src="layout.thumbnail">
        </div>
        <div class="rooms-area-box">
            <div class="col-md-6 col-xs-6 col-lg-6 rooms-number">@{{layout.room_label}}</div>
            <div class="col-md-6 col-xs-6 col-lg-6 rooms-area"> @{{layout.area}} м<sup>2</sup></div>
        </div>
    </div>
</div>


   {{--  <div class="fetching fetching-mob" v-if="fetching">
        <div class="sk-fading-circle" style="height: @{{ layoutsHeight }}">
            <div class="sk-circle1 sk-circle"></div>
            <div class="sk-circle2 sk-circle"></div>
            <div class="sk-circle3 sk-circle"></div>
            <div class="sk-circle4 sk-circle"></div>
            <div class="sk-circle5 sk-circle"></div>
            <div class="sk-circle6 sk-circle"></div>
            <div class="sk-circle7 sk-circle"></div>
            <div class="sk-circle8 sk-circle"></div>
            <div class="sk-circle9 sk-circle"></div>
            <div class="sk-circle10 sk-circle"></div>
            <div class="sk-circle11 sk-circle"></div>
            <div class="sk-circle12 sk-circle"></div>
        </div>
    </div> --}}
    <div class="rooms-wrapper-dev-m" v-for="(layout, index) in {{ $layoutsData }}" @click="selectLayout(layout, index)">
        <div class="rooms-plan-img-m">
            <img :src="layout.thumbnail">
        </div>
        <div class="rooms-info-box-m">
            <div class="rooms-number-area-wrapper">
                <div class="rooms-number-area-m">
                    <div class="number-title">Комнаты</div>
                    <div class="info-data">@{{layout.room_label}}</div>
                </div>
                <div class="rooms-number-area-m">
                    <div class="number-title">Площадь</div>
                    <div class="info-data">@{{layout.area}} м<sup>2</sup></div>
                </div>
            </div>
            <div class="popup-more">Подробнее</div>
        </div>
    </div>
