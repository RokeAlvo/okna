<div class="rooms-plan-box-dev-wrapper" v-for="(layout, index) in {{ $layoutsData }}" @click="selectLayout(layout, index)">
    <div class="rooms-plan-box-dev">
        <div class="rooms-wrapper-dev">
            <div class="rooms-plan-box-title-wrapper">
                <div class="rooms-plan-box-title">ЖК @{{ residentials[0].title }}</div>
                <div class="rooms-plan-box-title-was-passed">@{{ residentials[0].completion_date }}</div>
            </div>
           
        </div>
        <div class="rooms-plan-img-dev">
                <img :src="layout.thumbnail">
        </div> 
        <div class="rooms-area-box-dev">
            <div class="col-md-6 col-xs-6 col-lg-6 rooms-info-dev-number">@{{layout.room_label}}</div>
            <div class="col-md-6 col-xs-6 col-lg-6 rooms-info-dev-square">@{{layout.area}} м<sup>2</sup></div>
        </div>       
    </div>
</div>
