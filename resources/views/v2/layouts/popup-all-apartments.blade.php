@section('styles')
    <link href="{{ url('/v2/css/popup/all-apartments.css') }}" rel="stylesheet">
@endsection

<div :class="[canShowPopup ? 'visible-block' : '']" style="display: none;">  <!--style="display: none;"-->
    <transition id="apartment-popup-transition" appear name="fade" v-cloak> <!-- -->
        <div class="popup-wrapper z-index-max" v-if="oneRoomLayouts.length" data-popup-window="apartment">
            <div class="popup popup-right" @click.self="closeOneRoomLayouts">
                <div class="popup-body">
                    <div class="close-popup-m d-block d-md-none pos-left" @click="closeOneRoomLayouts"><img src="/img/sign-x.png" class="sign-x"> закрыть</div>

                  
                        <div class="m-wrapper-numbers-all">

                            <div class="img-all-popup-wrapper" @click="closeOneRoomLayouts"><img src="/img/arrow-left-gray.png"></div>
                            <div class="m-rooms-number">@{{ oneRoomLayouts[0].room_label_full }}</div>
                        </div>
                 
                    
                            <div class="all-rooms-all-popup">
                            
                                <div class="rooms-plan-box" v-for="(layout, key) in oneRoomLayouts" @click="selectLayout(layout, key)">
                                        <div class="rooms-wrapper">
                                            <div class="rooms-plan-img">
                                                <img :src="layout.thumbnail">
                                            </div>
                                            <div class="rooms-area-box">
                                                <div class="col-md-6 col-xs-6 col-lg-6 rooms-number-all-popup">@{{layout.room_label}}</div>
                                                <div class="col-md-6 col-xs-6 col-lg-6 rooms-area-all-popup"> @{{layout.area}} м<sup>2</sup></div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            
                </div>
            </div>
        </div>
    </transition>
</div>