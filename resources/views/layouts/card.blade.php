<div v-for="(layout, index) in {{ $layoutsData }}" class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item">
    <div class="preview-apartment-element block-shadow" @click="selectLayout(index)">
        <div class="quick-view">
            <div class="preview-apartment-thumbimage">
                <div class="preview-apartment-thumbimage-wrapper">
                    <img class="img-responsive" :src="layout.thumbnail">
                </div>
            </div>
            <div class="preview-apartment-typearea">
                @{{layout.room_label}} | <strong>@{{layout.area}} м<sup>2</sup></strong>
            </div>
            <div class="preview-apartment-floor-list">
                @{{layout.floor_range}}
            </div>
            <div class="preview-apartment-moreinfo">
                Подробнее
            </div>
        </div>
    </div>
</div>