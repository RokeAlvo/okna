import Vue from 'vue';
import App from './components/App';
import VueRouter from 'vue-router';

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';
import vSelect from 'vue-select';

import vSlider from 'vue-slider-component';
// import VModal from 'vue-js-modal';
import VShowSlide from 'v-show-slide';
import VueLazyload from 'vue-lazyload';
import { ContentLoader } from 'vue-content-loader'
window.$ = window.jQuery = require('jquery');
Vue.component('content-loader', ContentLoader);


// import phoneInput from 'vue-inputmask';
// import vNumeric from 'vue-numeric'; //delete
// import { Money } from 'v-money';
// Vue.component('v-phone', phoneInput);
// Vue.component('v-money', Money);z



const VueInputMask = require('vue-inputmask').default;

Vue.use(VShowSlide);
Vue.use(VueInputMask);
Vue.use(VueIziToast);
// Vue.use(VModal);
Vue.use(VueLazyload, {
  lazyComponent: true
});
Vue.component('v-select', vSelect);

Vue.component('v-slider', vSlider);



import router from './routers/routers.js';
import { store } from './store/store.js';

import Selection from './components/selection/index.vue';
import Star from './components/selection/icons/iconStar.vue';
import Whatsup from './components/selection/icons/whatsup.vue';
import Viber from './components/selection/icons/viber.vue';
import Telegram from './components/selection/icons/telegram.vue';
import Vk from './components/selection/icons/vk.vue';
import Icons from './components/selection/icons/icons-share.vue';
Vue.component('icon-star', Star);
Vue.component('icon-whatsup', Whatsup);
Vue.component('icon-viber', Viber);
Vue.component('icon-telegram', Telegram);
Vue.component('icons-share', Icons);

import Button from '@/components/home/Button'
import Footer from '@/components/home/Footer'
import Logo from '@/components/home/Logo'
import ModalAdaptive from '@/components/home/Modal-adaptive'

Vue.component('Button', Button)
Vue.component('Footer', Footer)
Vue.component('Logo', Logo)
Vue.component('ModalAdaptive', ModalAdaptive)

import VModal from 'vue-js-modal/dist/ssr.index'
import 'vue-js-modal/dist/styles.css'

Vue.use(VModal)



// import VueYandexMetrika from '@bchteam/vue-yandex-metrika';
import VueYandexMetrika from 'vue-yandex-metrika'
var dataBackend = document.getElementById('js-backend-parameters');
// console.log('dataBackend: ', dataBackend);  
if (dataBackend) {
  var yandexMetrixId = +dataBackend.getAttribute('data-yandex-metrika');
}
// console.log('yandexMetrixId: ', yandexMetrixId);
Vue.use(VueYandexMetrika, {
  id: dataBackend ? yandexMetrixId : 99999,
  router: router,
  webvisor: true,
  // env: process.env.NODE_ENV,
  env: 'production'
});

export const whatsAppTel = "79537615339";


new Vue({
  el: '#app',
  render: h => h(App),
  store,
  router
});