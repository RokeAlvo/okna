<div class="maxsize-wrapper" v-if="selectedLayoutImageResize && !selectedLayoutImageUpsized" @click="increasePopupImage">
    <div class="maxsize-img"><img src="/img/loupe-plus.svg"></div>
</div>
<div class="minsize-wrapper" v-else-if="selectedLayoutImageResize && selectedLayoutImageUpsized" @click="decreasePopupImage">
    <div class="minsize-img"><img src="/img/loupe-minus.svg"></div>
</div>