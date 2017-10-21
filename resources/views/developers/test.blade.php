@extends('templates.main')

@section('title', 'Все о наиболее популярных застройщиках города Новосибирска')

@section('content')
    <div class="container">
        <h1>{{ $developer->name }} ТЕСТ</h1>
        <div class="developer-detail-box">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-developer-detail">
                        <div class="mb30">
                            <img src="{{ $developer->logo }}" alt="{{ $developer->name }}">
                        </div>
                        {{ $developer->text }}
                    </div>
                </div>
            </div>

            <div class="property-developer-statistic">
                <div class="row">
                    @foreach ($developer->statistics as $statistic)
                        <div class="col-sm-five col-xs-6">
                            <div class="property-developer-statistic-item">
                                <div class="property-developer-statistic-wrapper">
                                    <div class="property-developer-statistic-number">
                                        {{ $statistic->number }}
                                    </div>
                                    <div class="property-developer-statistic-text">
                                        {{ $statistic->text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if(!$developer->features->isEmpty())
        <div class="container">
            <div class="property-developer-features">
                <h2>Особенности застройщика</h2>

                <div class="row">
                    @foreach ($developer->features as $feature)

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="property-developer-featuries-item">
                                <div class="property-developer-featuries-number">
                                    <h3>{{ $feature->title }}
                                        <span>{{ ($feature->subtitle) ? $feature->subtitle : "&nbsp;" }}</span></h3>
                                </div>
                                <div class="property-developer-featuries-text">
                                    {{ $feature->text }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <section id="residentials">
        <div class="container">

            {{--FILTERS--}}

            <div class="property-developer-search">
                <div class="row">
                    <div class="col-md-9">
                        <div class="property-developer-search-filters">
                            <div class="property-developer-search-filters-rooms">
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="1">
                                        <label for="1">Все</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                                <div class="property-developer-search-filters-rooms-item-wrapper">
                                    <div class="property-developer-search-filters-rooms-item">
                                        <input type="checkbox" id="2">
                                        <label for="2">1-ком.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="property-developer-search-filters-sliders">
                                <div class="col-md-6">
                                    слайдер 1
                                </div>
                                <div class="col-md-6">
                                    слайдер 2
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="property-developer-search-result">
                            <div class="property-developer-search-result-head">
                                результаты поиска
                            </div>
                            <div class="property-developer-search-result-value">
                                <span class="property-developer-search-result-value-number">
                                    254
                                </span>
                                <span class="property-developer-search-result-value-description">
                                    квартир подходящих под Ваш запрос
                                </span>
                            </div>
                            <div class="property-developer-search-result-button">
                                <div class="property-developer-search-result-button-left">
                                    <button>Показать</button>
                                </div>
                                <div class="property-developer-search-result-button-right">
                                    <button type="reset"><i></i><i></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--RESIDENTIALS--}}

            <div class="property-developer-rc">
                <div class="property-developer-rc-block">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="property-developer-rc-left"
                                 style="background-image: url('https://novosibirsk.okna-novostroyki.com/uploads/residentials/3/HgfDTvnjwXeB7bCN.jpg')">
                                <div class="property-developer-rc-left-content">
                                    <div class="property-developer-rc-title">
                                        <h3>Аврора</h3>
                                        <div class="property-developer-rc-info">
                                            <div class="property-developer-rc-info-item">
                                                <img src="/img/developer/icon-map.png">
                                                <div class="property-developer-rc-info-item-text">
                                                    <div class="property-developer-rc-info-item-title">
                                                        Район
                                                    </div>
                                                    <div class="property-developer-rc-info-item-description">
                                                        Кировский
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property-developer-rc-info-item">
                                                <img src="/img/developer/icon-calendar.png">
                                                <div class="property-developer-rc-info-item-text">
                                                    <div class="property-developer-rc-info-item-title">
                                                        Срок сдачи от
                                                    </div>
                                                    <div class="property-developer-rc-info-item-description">
                                                        4 квартал 2018
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="property-developer-rc-actions">
                                        <a>Способы оплаты</a>
                                        <a>Посмотреть на карте</a>
                                        <a>Подробнее о ЖК</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="property-developer-rc-right">
                                <div class="property-developer-rc-apartments">
                                    <div class="property-developer-rc-apartments-amount">
                                        276
                                    </div>
                                    <div class="property-developer-rc-apartments-description">
                                        вариантов</br>квартир
                                    </div>
                                </div>
                                <table>
                                    <thead>
                                    <tr>
                                        <td>Комнаты</td>
                                        <td>Цена от</td>
                                        <td>Кол-во</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1-ком.</td>
                                        <td>2 232 856</td>
                                        <td>24</td>
                                    </tr>
                                    <tr>
                                        <td>1-ком.</td>
                                        <td>2 232 856</td>
                                        <td>24</td>
                                    </tr>
                                    <tr>
                                        <td>1-ком.</td>
                                        <td>2 232 856</td>
                                        <td>24</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="property-developer-rc-right-button">Покзать квартиры</div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="property-developer-rc-apartments">
                        <div id="search-new-layout-flats" class="list-view">
                            <div class="row">
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54767">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54767" data-floors-list="3,4,6,19,21"
                                         data-url="/apartment/quick-view?id=54767&amp;floors=3%2C4%2C6%2C19%2C21&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/34/2HjO4DjN20hd4zoe.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>24.8м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            3,4 и др. этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54765">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54765" data-floors-list="8,21 этажи"
                                         data-url="/apartment/quick-view?id=54765&amp;floors=8%2C21+%D1%8D%D1%82%D0%B0%D0%B6%D0%B8&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/35/nzaqjVOw0fA1esPO.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>27.3м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            8,21 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54704">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54704" data-floors-list="2-4,6-21"
                                         data-url="/apartment/quick-view?id=54704&amp;floors=2-4%2C6-21&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/22/WjQiiXDwrAjHz8mK.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>28.6м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            2-4,6-21 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54713">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54713" data-floors-list="5,7,9,11"
                                         data-url="/apartment/quick-view?id=54713&amp;floors=5%2C7%2C9%2C11&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/23/5PjFSuwpdI6JPdnv.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>28.9м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            5,7 и др. этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54722">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54722" data-floors-list="4,5,12,13,15,19-21"
                                         data-url="/apartment/quick-view?id=54722&amp;floors=4%2C5%2C12%2C13%2C15%2C19-21&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/25/ftycgu5M7FObdzw5.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>29м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            4,5 и др. этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54737">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54737" data-floors-list="2 этаж"
                                         data-url="/apartment/quick-view?id=54737&amp;floors=2+%D1%8D%D1%82%D0%B0%D0%B6&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/26/iHdTCzoQpv5K6Vbu.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>30м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            2 этаж
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54640">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54640" data-floors-list="16-22"
                                         data-url="/apartment/quick-view?id=54640&amp;floors=16-22&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/7/jxpbR52drwxmePzd.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>30.8м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            16-22 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54647">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54647" data-floors-list="3,4,8"
                                         data-url="/apartment/quick-view?id=54647&amp;floors=3%2C4%2C8&amp;pricemin=1755000&amp;pricemax=2225000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/8/7C40Hp1d5ExjRzZT.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            Студия | <strong>31м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            3,4,8 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54688">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54688" data-floors-list="2,12-15,18,19,21"
                                         data-url="/apartment/quick-view?id=54688&amp;floors=2%2C12-15%2C18%2C19%2C21&amp;pricemin=2300000&amp;pricemax=2740000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/19/oBqipzRrRAIQjmHL.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            1-ком. | <strong>33.9м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            2,12-15 и др. этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54758">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54758" data-floors-list="16,19-21"
                                         data-url="/apartment/quick-view?id=54758&amp;floors=16%2C19-21&amp;pricemin=2300000&amp;pricemax=2740000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/32/7cqJx9sMmsUPOvmx.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            1-ком. | <strong>35.1м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            16,19-21 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54623">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54623" data-floors-list="13,18,20,21"
                                         data-url="/apartment/quick-view?id=54623&amp;floors=13%2C18%2C20%2C21&amp;pricemin=2300000&amp;pricemax=2740000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/1/EZ9um3EYuU1QXwPy.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            1-ком. | <strong>36.7м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            13,18 и др. этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54636">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54636" data-floors-list="6,11,13"
                                         data-url="/apartment/quick-view?id=54636&amp;floors=6%2C11%2C13&amp;pricemin=2300000&amp;pricemax=2740000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/5/BgIVPXsDk6H5ouWc.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            1-ком. | <strong>38.3м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            6,11,13 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54637">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54637" data-floors-list="3,6,8"
                                         data-url="/apartment/quick-view?id=54637&amp;floors=3%2C6%2C8&amp;pricemin=2300000&amp;pricemax=2740000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/6/0Ei1vpOhMGLwolbQ.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            1-ком. | <strong>38.6м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            3,6,8 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54650">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54650" data-floors-list="18,20 этажи"
                                         data-url="/apartment/quick-view?id=54650&amp;floors=18%2C20+%D1%8D%D1%82%D0%B0%D0%B6%D0%B8&amp;pricemin=2300000&amp;pricemax=2740000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/9/2X4atsig8OzWfOxa.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            1-ком. | <strong>38.7м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            18,20 этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-five col-md-3 col-sm-4 col-xs-6 search-new-layout-flat-item" data-key="54692">
                                <div class="preview-apartment-element block-shadow">
                                    <div class="quick-view" data-apartment-id="54692" data-floors-list="9,12,15,20,21"
                                         data-url="/apartment/quick-view?id=54692&amp;floors=9%2C12%2C15%2C20%2C21&amp;pricemin=2960000&amp;pricemax=4055000">

                                        <div class="preview-apartment-thumbimage">
                                            <div class="preview-apartment-thumbimage-wrapper">
                                                <img class="img-responsive" src="/uploads/layouts/415/ftQW1Vzvu0JVrVnI.jpg" alt=""></div>
                                        </div>
                                        <div class="preview-apartment-typearea">
                                            2-ком. | <strong>44.4м<sup>2</sup></strong>
                                        </div>
                                        <!--
                                        <div class="preview-apartment-price-valueonly">
                                             <i class="fa fa-rub"></i>
                                        </div>-->
                                        <div class="preview-apartment-floor-list">
                                            9,12 и др. этажи
                                        </div>
                                        <div class="preview-apartment-moreinfo">
                                            Подробнее
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="property-developer-rc-hide"><div class="property-developer-rc-hide-wrapper"><span>Скрыть квартиры</span></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--        --}}{{--@foreach($developer->residentials as $residential)--}}{{--
            @include('residentials.card', ['residentials' => $developer->residentials])
            --}}{{--@endforeach--}}
    </div>
    </div>
    </div>
@endsection