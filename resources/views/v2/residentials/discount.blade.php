@section('styles') @parent
<link href="{{ url('/v2/css/discount/discount.css') }}" rel="stylesheet">
@endsection
@if($isActiveDiscount)
<div class="discount-overlay-off" @click="closeDiscountPopup">

    <div class="discount-wrapper">
        <div class="discount__close" onclick="closeDiscount()"></div>
        <div class="discount__title-wrapper">
            <div class="discount__title">акция</div>
        </div>
        <div class="discount__img">
            <img src="/img/discount-img.png" alt="">
        </div>
        <div class="discount__content">
            {{$residential->discount_title}}
        </div>
        <div class="discount__detail">Подробности акции уточняйте в <span class="sale-departes discount-sale-departes">отделе продаж</span></div>
        <div class="discount__phone">
            <a href="" class="change-phone discount__phone-link">+7 (383) 388-4896</a>
        </div>
    </div>

</div>
@endif