@extends('templates.main')

@section('title', '«Окна - новостройки» портал о недвижимости в ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][5])
@section('description', 'Вся информация о наиболее выгодных предложениях по продаже новостроек в городе ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][0] . '. Портал предлагает полный список предложений для будущих жильцов.')
@section('keywords', 'новостройки, ' . SITE_CONTACTS[getUrlPathFirstPart()]['cityNameForms'][0] . ', портал')

@section('content')
    <div class="container">
        <div class="company-features">
            <div class="row">
                <div class="col-md-4">
                    <div class="company-features-wrapper">
                        <div class="company-features-item">
                            <p class="features-item-title">
                                Ипотека или<br> рассрочка
                            </p>
                            <p class="features-item-text">
                                Мы поможем вам получить рассрочку от застройщика или ипотеку на лучших условиях от наших
                                банков-партнеров.
                            </p>
                            <div class="company-features-icon features-icon-payment-bg">
                                <div class="company-features-icon-payment"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="company-features-wrapper">
                        <div class="company-features-item">
                            <p class="features-item-title">
                                Никакой<br> комиссии
                            </p>
                            <p class="features-item-text">
                                Мы не зарабатываем на своих клиентах! Все квартиры продаются по ценам
                                компаний-застройщиков!
                            </p>

                            <div class="company-features-icon features-icon-price-bg">
                                <div class="company-features-icon-price"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="company-features-wrapper">
                        <div class="company-features-item">
                            <p class="features-item-title">
                                Скидки и<br> акции
                            </p>
                            <p class="features-item-text">
                                Покупать квартиры на нашем портале не только надежно, но и выгодно! Для вас постоянные
                                акции и скидки!
                            </p>

                            <div class="company-features-icon features-icon-discount-bg">
                                <div class="company-features-icon-discount"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-company">
            <div class="row">
                <div class="col-md-3">
                    <div class="about-company-title">
                        <div class="about-company-title-cstm">
                            Коротко о <span>портале</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="about-company-text">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Портал «ОКНА-Новостройки» – новое имя на российском рынке недвижимости. Штат
                                    сотрудников «ОКНА-Новостройки» состоит
                                    исключительно из квалифицированных и опытных специалистов, отдавших отрасли уже ни
                                    один десяток лет.</p>
                                <p>Можно справедливо заметить, что подобных агентств на отечественном рынке уже
                                    достаточно. Так почему же стоит искать
                                    квартиру именно здесь? Дело в том, что у портала «ОКНА-Новостройки» совершенно новый
                                    подход к покупке жилья. А именно,
                                    это первое агентство, делающее упор не на классическую работу в офисах, а на
                                    деятельность в сети Интернет.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="about-company-img">
                                    <img src="{{ url('/img/about_company_home.png') }}"
                                         alt="<{{ SITE_CONTACTS[getUrlPathFirstPart()]['company_name'] }}">
                                </div>
                            </div>
                        </div>
                        <p>И действительно, зачем тратить время на просмотры печатных каталогов, поиск номеров телефонов
                            в справочниках, выслушивание
                            рекомендаций заботливых знакомых? Ведь всю самую полную и актуальную информацию можно найти
                            на одном единственном сайте.
                            Именно в этом и заключается основная миссия портала «ОКНА-Новостройки» – сбор информации обо
                            всех надежных застройщиках страны
                            и их предложениях.</p>
                        <p>Все собрано на одном портале, где каждый посетитель может узнать о любом застройщике, о любом
                            жилом комплексе и о любой
                            квартире. И это не просто информация «для галочки», а плод труда опытных риелторов,
                            работающих в тесном контакте с
                            застройщиками.</p>
                        <p>Обратите внимание, что портал не зарабатывает на покупателях жилья, а продает квартиры
                            исключительно по ценам застройщиков.</p>
                        <p>Давайте подытожим! Здесь работают опытные риелторы в связке с лучшими Интернет-маркетологами,
                            все застройщики и жилые комплексы
                            находятся в одном месте, информация полна и многообразна. Этого мало, чтобы поискать
                            квартиру на портале «ОКНА-Новостройки»?
                            Тогда дополняем!</p>
                        <ol>
                            <li>«ОКНА-Новостройки» сотрудничает с крупнейшими банками Российской Федерации, а значит,
                                может предложить улучшенные условия
                                ипотеки.
                            </li>
                            <li>Сотрудники портала помогут получить беспроцентную рассрочку от застройщика на желаемый
                                срок.
                            </li>
                            <li>Юристы бесплатно проконсультируют по любому вопросу и обеспечат сопровождение сделки на
                                всех этапах.
                            </li>
                            <li>Специалисты устроят экскурсию по интересующему объекту и ответят на любые вопросы.</li>
                            <li>И главное, покупатель не платит порталу «ОКНА-Новостройки» ни за что, – все услуги и
                                консультации абсолютно бесплатны и
                                никак не влияют на изначальную стоимость жилья от застройщика.
                            </li>
                        </ol>
                        <p>Портал «ОКНА-Новостройки» изменит мнение граждан о покупке жилья и докажет, что это крайне
                            легкий, удобный, быстрый и
                            безопасный процесс.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection