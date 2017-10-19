<section id="other-rc">
    <div class="container">
        <h2>Новостройки от застройщика</h2>
        <div class="row">
            @foreach($residentials as $residential)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="property-developer-residential-complex-item block-shadow">
                        <a href="{{ route('residentials.show', [$residential->alias]) }}">
                            <img class="img-responsive" src="{{ $residential->thumbnail }}"
                                 {{-- width="264px"--}} alt="{{ $residential->title }}">
                        </a>
                        <div class="property-developer-residential-complex-info">
                            <div class="property-developer-residential-complex-title">
                                <a href="/residential-complex/elbrus">{{ $residential->title }}</a></div>
                            <ul class="list-unstyled list-params">
                                <li>Район:
                                    <span>{{ !empty($residential->district) ? $residential->district->name : '' }}</span>
                                </li>
                                <li>Срок
                                    сдачи:<span>{{ !empty(QUARTERS['full'][$residential->completion_decade]) ? QUARTERS['full'][$residential->completion_decade] : '' }} {{ $residential->completion_year }}</span>
                                </li>
                                <li>Класс
                                    жилья:<span>{{ !empty(COMFORT_CLASSES[$residential->comfort_class]) ? COMFORT_CLASSES[$residential->comfort_class] : '-' }}</span>
                                </li>
                                @if(!empty($residential->price_meter_from))
                                    <li>Цена от:<span>{{ number_format($residential->price_meter_from, 0, '.', ' ') }}
                                            руб/м<sup>2</sup></span>
                                    </li>
                                @endif
                            </ul>
                            <div class="text-center">
                                <a class="btn  btn-lg btn-round btn-green btn-custom-lg btn-more"
                                   href="{{ route('residentials.show', [$residential->alias]) }}">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>