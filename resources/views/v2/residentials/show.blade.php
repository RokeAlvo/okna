@extends('v2.templates.main') 
@section('head-scripts')
<script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full&lazy=true"></script>

{{--
<script src="{{ url('/v2/js/owl.carousel.min.js')}}"></script> --}} {{--
<script>
    $(document).ready(function(){
            
                $('ul.tabs li').click(function(){
                    var tab_id = $(this).attr('data-tab');
            
                    $('ul.tabs li').removeClass('current');
                    $('.tab-content').removeClass('current');
            
                    $(this).addClass('current');
                    $("#"+tab_id).addClass('current');
                });
            
            });

</script> --}}
@endsection
 
@section('footer-scripts')

<script src="{{ url('/v2/js/vue.js') }}"></script>
<script src="{{ url('/v2/js/vue-resource.js') }}"></script>
<script src="{{ url('/v2/js/residentials/jquery.mask.min.js') }}"></script>
<script src="{{ url('/v2/js/residentials/pagination.js') }}"></script>
<script src="{{ url('/v2/js/popup.js') }}"></script>
<script src="{{ url('/v2/js/validateInput.js') }}"></script>
<script src="{{ url('/v2/js/showInputPhone.js') }}"></script>
<script src="{{ url('/v2/js/closeDiscount.js') }}"></script>
<script src="{{ url('/v2/js/showDiscount.js') }}"></script>
<script src="{{ url('/v2/js/showWelcome.js') }}"></script>
<script src="{{ url('/v2/js/showSaleText.js') }}"></script>
<script src="{{ url('/v2/js/residentials/apartment-tooltip.js') }}"></script>
<script src="{{ url('/v2/js/mobileAndTabletCheck.js') }}"></script>
<script src="{{ url('/v2/js/addInputMask.js') }}"></script>
<script src="{{ url('/v2/js/residentials/sticky-menu.js') }}"></script>
<script src="{{ url('/v2/js/accordion.js')}}"></script>
<script src="{{ url('/v2/js/jquery.collapser.min.js')}}"></script>
<script src="{{ url('/v2/js/inputMaskNoSPA.js')}}"></script>





<script type="text/x-template" id="tab-one">
    <div>
        <div class="tab-content" id="tab-1-content">
            <div class="tab-phone"><a class="main-phone" href="tel:+70000000000">+7 (000) 000-XX-XX</a></div>

            <div class="tab-phone-button" ref="tabPhoneButton" @click="showWorkTime">Показать номер</div>
            <div class="work-time-wrapper">
                <div class="work-time-icon">
                    <img src="/img/clock-gray.png">
                </div>
                <div class="work-time">
                    <div class="work-time-title">Режим работы:</div>
                    <div class="work-time-data">Ежедневно с 9:00 до 20:00</div>
                </div>
            </div>

        </div>
    </div>
</script>

<script type="text/x-template" id="tab-two">
    <div>
        <div class="price-number-wrapper">

            <div class="number-send" v-if="!requestSend">
                <div class="number-placeholder">
                    <input type="text" name="client_phone" id="client-phone" onclick="addInputMask(this)" placeholder="+7 (XXX) XXX-XX-XX">
                </div>
                <div class="number-button" @click.prevent="callbackStoreRequest('{{ getUrlPathFirstPart() }}')">
                    Отправить
                </div>
            </div>
            <div class="popup-apartment-form-success" v-else>
                <span>Спасибо за обращение!</span> с Вами свяжутся в течении 5 минут.
            </div>
            <div class="popup-apartment-specifications-title confidential-policy d-none d-md-block">
                Нажимая на кнопку "Отправить" Вы соглашаетесь с<br>
                <a href="/oferta.pdf" target="_blank">политикой конфиденциальности</a>
            </div>
        </div>

    </div>
</script>


<script>
    var elements = document.getElementsByClassName('mask-phone');
for (var i = 0; i < elements.length; i++) {
  new IMask(elements[i], {
    mask: '+{7}(000)000-00-00',
  });
}

</script>


<script>
    var TabPhone = {
            template: '#tab-one',
            methods: {
                showWorkTime: function () {
                    $(this.$refs.tabPhoneButton).css('display', 'none');
                    $('.work-time-wrapper').css('display', 'flex');
                    $('.tab-phone .main-phone').html($('.tab-phone .main-phone').attr('data-tel'));
                }
            }
        };
        var TabCallback = {
            template: '#tab-two',
            props: ['requestSend'],
            methods: {
                callbackStoreRequest: function (city) {
                    //this.$parent.$options.methods.storeRequest(city);
                    this.$parent.$emit('store-request', city);
                }
            }
        };


        new Vue({
            el: '#layouts-vue',
            data: {
                canShowPopup: false,
                fetching: false,
                fetchingMobile: false,
                oneRoomLayouts: [],
                room: 0,
                selectedLayoutIndex: -1,
                selectedLayout: {},
                <?php echo 'selectedLayoutResidential: '.$residential->toJson().','; ?>
                selectedLayoutImageHeight: 0,
                selectedLayoutImageResize: false,
                selectedLayoutImageUpsized: false,
                selectedLayoutImage: {},
                layouts: [],
                totalLayouts: 0,
                perPage: 15,
                currentPage: 0,
                rooms: [],
                requestSend: false,
                accordionActive: false,
                layoutsHeight: 0,
                tabs: [['phone', 'Отдел продаж'], ['callback', 'Заказать обратный звонок']],
                currentTab: ['phone', 'Отдел продаж'],
                roomLabels: []
            },
            components: {
                'tab-phone': TabPhone,
                'tab-callback': TabCallback
            },
            computed: {
                allRoomCheckbox: function () {
                    return this.rooms.length === 0
                },
                currentTabComponent: function () {
                    return 'tab-' + this.currentTab[0].toLowerCase();
                }
            },
            methods: {
                yaMetrics: function () {
                    $(".contact-phone-wrapper").click(function () {
                        @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                        setTimeout(function () {
                            yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('click-phone-no-rooms');
                        }, 10000);
                        @endif
                    });
                },
                fetchLayouts: function (page) {
                    if (page > 0) {
                        var url = this.$route;
                        var options = {
                            params: {
                                page: page,
                                per_page: this.perPage,
                                rooms: this.rooms
                            }
                        };
                        
                        this.fetching = true;
                        this.$http
                            .get(url, options)
                            .then(function (response) {
                                this.layouts = response.data;
                                
                                if(this.rooms.length) {

                                    var obj = {};
                                    for (var key in this.layouts) {
                                        obj[this.layouts[key].room_label_short] = this.layouts[key].rooms;
                                    }
                                    this.roomLabels = Object.keys(obj).sort(function(a,b){return obj[a]-obj[b]});
                                    // this.roomLabels = Array.from(new Set(this.layouts.map(function(item,index) { return item.room_label_short; })));
                                } else {
                                    this.roomLabels = [];
                                }
                                this.totalLayouts = parseInt(response.headers.get('x-total-layouts'));
                                this.currentPage = page;
                                this.fetching = false;
                            }, console.log)
                            .catch(function () {
                                setTimeout(this.fetchLayouts, 900, page);
                            });
                    }
                },
                checkAllRooms: function () {
                    if (!this.allRoomCheckbox) {
                        this.rooms = [];
                        this.fetchLayouts(1);
                        return;
                    }
                    this.rooms = [];
                },
                fetchOneRoomLayouts: function (room) {
                    this.canShowPopup = true;
                    var url = this.$route;
                    var options = {
                        params: {
                            room: room
                        }
                    };
                    this.oneRoomLayouts = [];
                    this.room = room;
                    this.fetchingMobile = true;
                    this.$http
                        .get(url, options)
                        .then(function (response) {
                            this.oneRoomLayouts = response.data;
                            this.fetchingMobile = false;
                            $('body').css('overflow', 'hidden');
                        }, console.log)
                        .catch(function () {
                            setTimeout(this.fetchOneRoomLayouts, 900, room);
                        });
                    this.accordionActive = true;
                },
                selectLayout: function (layout, index) {
                    this.canShowPopup = true;
                    this.selectedLayout = layout;
                    this.selectedLayoutIndex = index;
                    $('body').css('overflow', 'hidden');

                    var gaLabel = $('#apartments').data('ga-popup-open-label');
                    @if (app()->environment('production'))
                    ga('send', 'event', 'popup', 'open', gaLabel);
                    ga('send', 'event', 'popup', 'open', 'all-popup');
                    @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                    yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal(gaLabel);
                    @endif
                    @endif
                    //reachGoal(gaLabel);

                    setTimeout(function () {
                        this.selectedLayoutImageHeight = $('.plan-image-box .main-popup-img').prop('naturalHeight');
                        if (this.selectedLayoutImageHeight >= (35 / 100) * $(window).height()) {
                            // $('.plan-image-box .main-popup-img').height('35vh');
                            this.selectedLayoutImageResize = true;
                            this.selectedLayoutImageUpsized = false;
                        }

                        accordion($(".popup .accordion"));
                    }.bind(this), 400);
                },
                increasePopupImage: function () {
                    $('.plan-image-box .main-popup-img').css('max-height', '100%').css('max-width', '100%').height(this.selectedLayoutImageHeight).height(this.selectedLayoutImageWidth);
                    this.selectedLayoutImageUpsized = true;
                },
                decreasePopupImage: function () {
                    $('.plan-image-box .main-popup-img').css('max-height', '100%').height('35vh');
                    this.selectedLayoutImageUpsized = false;
                },


                closePopup: function () {
                    this.selectedLayoutIndex = -1;
                    this.selectedLayoutImageHeight = 0;
                    this.selectedLayoutImageResize = false;
                    this.selectedLayoutImageUpsized = false;
                    if (!this.oneRoomLayouts.length) {
                        $('body').css('overflow', 'auto');
                    }
                },
                closeDiscountPopup: function(){
                    $('body').css('overflow', 'unset');
                    $('.discount-overlay-off').removeClass('discount-overlay-on');
                     $('.discount__close').css("display", "none");
                }
                ,
                closeOneRoomLayouts: function () {
                    this.oneRoomLayouts = [];
                    $('body').css('overflow', 'auto');
                },
                storeRequest: function (city) {
                    // Check input 
                    if ($('#client-phone').val().length != 0 && $('#client-phone').val().length > 15) {
                        
                        $('#client-phone').removeClass('input__back-phone--error'); 
                        var url = window.location.protocol + '//' + window.location.hostname + '/' + city + '/requests';
                        var options = {
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            },
                            params: {
                                layout_id: this.selectedLayout.id,
                                client_phone: $('#client-phone').val(),
                                type: 1,
                                _token: window.Laravel.csrfToken
                            }
                        };
                        this.$http
                            .post(url, options['params'], options['headers'])
                            .then(function (response) {
                                if (response.data) {
                                    this.requestSend = true;
                                    setTimeout(this.toggleRequestSend, 10000);
                                } else {
                                    this.requestSend = false;
                                }
                            }, console.log)
                            .catch(function (error) {
                                console.log(error);
                                setTimeout(this.storeRequest, 1000);
                            });
                        var gaGoalLabel = $('#apartments').data('ga-popup-goal-label');
                        var gaGoalPhoneLabel = $('#apartments').data('ga-popup-goal-phone-label');
                        @if (app()->environment('production'))
                        ga('send', 'event', 'popup', 'price-info', gaGoalLabel);
                        ga('send', 'event', 'popup', 'price-info', 'all-popup');
                        @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal(gaGoalLabel);
                        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal(gaGoalPhoneLabel);
                        @endif
                        @endif
                        //reachGoal(gaGoalLabel);
                    } else {
                        $('#client-phone').addClass('input__back-phone--error');
                    }
                },
                toggleRequestSend: function () {
                    this.requestSend = !this.requestSend;
                },
                toggleAccordionActive: function () {
                    this.accordionActive = !this.accordionActive;
                },
                phoneChange: function () {
                    var phone = $('.phone-number .main-phone').first().text();
                    var tel = $('.phone-number .main-phone').first().text().replace(/[^0-9]/gi, '');
                    $.fn.hasAttr = function(name) {
                        return this.attr(name) !== undefined;
                    };
                    $('.phone-number .main-phone').attr("href", 'tel:+' + tel);
                    if ($('.popup-phone-box .main-phone').length) {
                        $('.popup-phone-box .main-phone').html(phone);
                        $('.popup-phone-box .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.rooms-box .main-phone').length) {
                        // $('.rooms-box .main-phone').html(phone)
                        $('.rooms-box .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.popup-apartment-phone .main-phone').length) {
                        $('.popup-apartment-phone .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.tab-phone .main-phone').length) {
                        if ($(this.$refs.tabPhoneButton).length) {
                            $('.tab-phone .main-phone').html(phone.substr(0, 13) + 'XX-XX');
                        }
                        $('.tab-phone .main-phone').attr("href", 'tel:+' + tel);
                        $('.tab-phone .main-phone').attr("data-tel", phone);
                    }
                    if ($('.call-self .main-phone').length) {
                        $('.call-self .main-phone').html(phone);
                        $('.call-self .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.m-call-button .main-phone').length) {
                        $('.m-call-button .main-phone').attr("href", 'tel:+' + tel);
                    }
                    if ($('.change-phone').length) {
                        $('.change-phone').html(phone);
                        if($('.change-phone').hasAttr('href')){
                          $('.change-phone').attr("href", 'tel:+' + tel);  
                        }       
                    }
                },
                showCallBack: function (show) {
                    if (show) {
                        $(this.$refs.mobileSalePhone).css('display', 'none');
                        $(this.$refs.mobileCallBack).css('display', 'block');
                    } else {
                        $(this.$refs.mobileSalePhone).css('display', 'block');
                        $(this.$refs.mobileCallBack).css('display', 'none');
                    }
                    ;
                },
                showMoreMenu: function (showMenu) {
                    if (show) {
                        $(this.$refs.mobShow).css('display', 'none');
                        $(this.$refs.mobHide).css('display', 'block');
                    } else {
                        $(this.$refs.mobShow).css('display', 'block');
                        $(this.$refs.mobHide).css('display', 'none');
                    }
                    ;
                },
                addMask(){
                  var elements = document.getElementsByClassName('mask-phone');
                  for (var i = 0; i < elements.length; i++) {
                    new IMask(elements[i], {
                      mask: '+{7}(000)000-00-00',
                    });
                  }
                }
            },
            created: function () {
                console.log(this.roomLabels);

            setTimeout(this.fetchLayouts(1), 700);

                @if(!empty(SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']))
                    setTimeout(function () {
                        yaCounter{{ SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika'] }}.reachGoal('new-design');
                    }, 10000);
                @endif
                //reachGoal('new-design');
            },
            mounted: function () {
                this.$on('store-request', function (city) {
                    this.storeRequest(city);
                    
                });
                console.log(this.selectedLayoutResidential);
            },
            updated: function () {
                setTimeout(this.phoneChange(), 3000);
                this.addMask();
                
            }
        });

</script>
<script>
    function animateScroll(element, time) {
            time = time || 1000;
            $("html,body").animate({scrollTop: $(element).offset().top - 100}, time);
        }

        function goToElement(element, time) {
            animateScroll(element, time);
        }

        $('[href^="#"]').click(function () {
            goToElement($(this).attr('href'), 500);
            return false;
        });

        //$(document).ready(function(){
        $('.tab-link').click(function (event) {
            var tab_id = $(event.target).attr('data-tab');

            $('.tab-link').removeClass('current');
            $('.tab-content').removeClass('current');

            $(event.target).addClass('current');
            $("#" + tab_id).addClass('current');
        });
        //});

</script>
@endsection
 
@section('title', "Жилой комплекс " . $residential->title . " - Купить квартиру от застройщика в Новосибирске")

@section('description', "Купить квартиру в жилом комплексе " . $residential->title . ". Район: " . $residential->district->name
. ". Срок сдачи: " . $residential->completion_date_description . ". Запишитесь на экскурсию.") 
@section('keywords', mb_strtolower($residential->title)
. ", купить квартиру в жк " . mb_strtolower($residential->title) . ", новостройка, планировки жк " . mb_strtolower($residential->title)
. ", цены жк " . mb_strtolower($residential->title)) 
@section('content') {{--RC-MAIN-BLOCK--}}
    @include('v2.residentials.rc-main-block')
{{--DESCRIPTION and FEATURES--}}
    @include('v2.residentials.description') {{--APARTMENTS--}}
    @include('v2.residentials.apartments')
{{--GALLERY--}} @if (!$residential->images->isEmpty())
    @include('v2.residentials.gallery') @endif {{--MAP--}} {{-- @if(\Illuminate\Support\Facades\App::environment()
== 'production') --}} @if (!empty($residential->latitude) && !empty($residential->longitude))
    @include('v2.residentials.map')
@endif {{-- @endif --}}
@endsection