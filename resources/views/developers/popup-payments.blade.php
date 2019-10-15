<div class="popup-wrapper" v-if="payments.show" style="display: block" v-cloak>
    <div class="popup" @click.self="payments.show = !payments.show">
        <div v-if="isMobile" class="developer-payment-mobile">
            <div class="developer-payment-mobile-close-wrapper">
                <div class="developer-payment-mobile-close" @click="payments.show = !payments.show">
                    Закрыть
                </div>
            </div>
            <div class="developer-payment-mobile-item">
                <div class="developer-payment-mobile-item-img">
                    <img src="/img/developer/icon-money-gray.png">
                </div>
                <div class="developer-payment-mobile-item-content">
                    <div class="developer-payment-mobile-item-title">
                        Наличные
                    </div>
                    <div class="developer-payment-mobile-item-description">
                        Простой способ купить квартиру
                    </div>
                </div>
            </div>
            <div class="developer-payment-mobile-item">
                <div class="developer-payment-mobile-item-img">
                    <img src="/img/developer/icon-mortgage-gray.png">
                </div>
                <div class="developer-payment-mobile-item-content">
                    <div class="developer-payment-mobile-item-title">
                        Ипотека <span>от @{{ payments.residential.minMortgagePercent }}% годовых</span>
                    </div>
                </div>
            </div>
            <div class="developer-payment-mobile-item">
                <div class="developer-payment-mobile-item-img">
                    <img src="/img/developer/icon-piggy-bank-gray.png">
                </div>
                <div class="developer-payment-mobile-item-content" v-if="payments.residential.installment">
                    <div class="developer-payment-mobile-item-title">
                        Рассрочка
                    </div>
                    <div class="developer-payment-mobile-item-description">
                        <span v-if="payments.residential.installment.percent <= 0">без переплаты</span>
                        <span v-else>@{{ payments.residential.installment.percent }}% годовых</span>
                        <span v-if="payments.residential.installment.credit_to_building_house">до сдачи дома</span>
                        <span v-else>@{{ payments.residential.installment.credit_period_range }}</span>
                    </div>
                </div>
            </div>
            <div class="developer-payment-mobile-item">
                <div class="developer-payment-mobile-item-img">
                    <img src="/img/developer/icon-trade-in-gray.png">
                </div>
                <div class="developer-payment-mobile-item-content" v-if="payments.residential.trade_in">
                    <div class="developer-payment-mobile-item-title">
                        Trade-in
                    </div>
                    <div class="developer-payment-mobile-item-description">
                        Поменяйте квартиру без лишних затрат
                    </div>
                </div>
            </div>
            <div class="developer-payment-mobile-item">
                <div class="developer-payment-mobile-item-img">
                    <img src="/img/developer/icon-mortgage-0-gray.png">
                </div>
                <div class="developer-payment-mobile-item-content" v-if="payments.residential.mortgage_w_i_f">
                    <div class="developer-payment-mobile-item-title">
                        Ипотека <span>без первоначального взноса</span>
                    </div>
                </div>
            </div>
            <div class="developer-payment-mobile-cta">
                <div class="developer-payment-mobile-cta-title">
                    Подробнее о способах покупки
                </div>
                <div class="developer-payment-mobile-cta-subtitle">
                    узнавайте у менеджера в отделе продаж
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input
                                type="text"
                                placeholder="+7 (___) ___-__-__"
                                id="client-phone"
                                onclick="addInputMask(this)"
                        >
                    </div>
                    <div class="col-xs-6">
                        <div class="developer-payment-mobile-form-button">
                            Перезвоните мне
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="developer-payment-container-wrapper">
            <div class="developer-payment-container" data-popup-block="true">
                <div class="developer-payment-block block-content">
                    <div class="developer-payment-block-title">
                        Наличные
                    </div>
                    <div class="developer-payment-block-description">
                        Простой способ<br>купить квартиру
                    </div>
                    <img src="/img/developer/icon-money.png">
                </div>
                <div class="developer-payment-block block-content">
                    <div class="developer-payment-block-title">
                        Ипотека
                    </div>
                    <div class="developer-payment-block-description">
                        Процентная ставка<br><b style="font-size: 26px">от @{{ payments.residential.minMortgagePercent }}%</b>
                    </div>
                    <img src="/img/developer/icon-mortgage.png">
                </div>
                <div class="developer-payment-block block-content" v-if="payments.residential.installment">
                    <div class="developer-payment-block-title">
                        Рассрочка
                    </div>
                    <div class="developer-payment-block-description">
                        <span v-if="payments.residential.installment.percent <= 0">без переплаты</span><span v-else>@{{ payments.residential.installment.percent }}% годовых</span></br>
                        <b v-if="payments.residential.installment.credit_to_building_house">до сдачи дома</b>
                        <b v-else>@{{ payments.residential.installment.credit_period_range }}</b>
                    </div>
                    <img src="/img/developer/icon-piggy-bank.png">
                </div>
                <div class="developer-payment-block block-content" v-if="payments.residential.trade_in">
                    <div class="developer-payment-block-title">
                        trade-in
                    </div>
                    <div class="developer-payment-block-description">
                        Поменяйте квартиру</br><b>без лишних затрат</b>
                    </div>
                    <img src="/img/developer/icon-trade-in.png">
                </div>
                <div class="developer-payment-block block-content" v-if="payments.residential.mortgage_w_i_f">
                    <div class="developer-payment-block-title" style="font-size: 24px;">
                        Ипотека <b style="color: #4EBB00">без первоначального взноса</b>
                    </div>
                    <img src="/img/developer/icon-mortgage-0.png">
                </div>
                <div class="developer-payment-cta block-content">
                    <div class="developer-payment-cta-title">
                        Подробнее о способах покупки
                    </div>
                    <div class="developer-payment-cta-description">
                        Узнавайте у менеджера отдела продаж
                    </div>
                    <img src="/img/developer/manager.png">
                    <div v-if="!requestSend">
                        <input
                                type="text"
                               placeholder="+7 (___) ___-__-__"
                               id="client-phone"
                               onclick="addInputMask(this)"
                        >
                        <div
                                class="developer-payment-cta-call"
                                data-tooltip-button="payments"
                                @click="storePaymentsRequest('{{ getUrlPathFirstPart() }}')"
                        >
                            Перезвоните мне
                        </div>
                        <div class="developer-payment-cta-phone" data-tooltip="payments">
                            Отдел продаж: {!! SITE_CONTACTS[getUrlPathFirstPart()]['phone'] !!}
                        </div>
                    </div>
                    <div class="developer-payment-cta-description" v-else>
                        <b>Спасибо за обращение!</b><br>C вами свяжутся в течение 5 минут.
                    </div>
                </div>
            </div>
            <img class="developer-close-popup" src="/img/developer/icon-close.png" @click="payments.show = !payments.show">
        </div>
    </div>
</div>