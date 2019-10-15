import Vue from 'vue';
import VueRouter from 'vue-router';

//Steps for yes
import StepOneMain from "@/components/Main/Step-1-Main.vue";
import OneOnePriceApartaments from "@/components/Ipoteka_Steps/Steps--1/Step-1-1-PriceApart.vue";
import OneTwoCalc from "@/components/Ipoteka_Steps/Steps--1/Step-1-2-Calc.vue";
import OneTwoOneCome from "@/components/Ipoteka_Steps/Steps--1/Step-1-2-1-Come.vue";
import OneTwoTwoNoDeposit from "@/components/Ipoteka_Steps/Steps--1/Step-1-2-2-NoDeposit.vue";
import Welcome from "@/components/Ipoteka_Steps/Step--welcome/Ipoteka_welcome.vue";
//Steps for No
import TwoOneMonthPay from "@/components/Ipoteka_Steps/Steps--2/Step-2-1-MontPay.vue";
import TwoTwoMontCalc from "@/components/Ipoteka_Steps/Steps--2/Step-2-2-MonthCalc.vue";
import TwoThreeChangRoom from "@/components/Ipoteka_Steps/Steps--2/Step-2-3-ChangeRoom.vue";


// mapSearch
import MapSearch from '@/components/mapSearch/index.vue'

//404
import NotFound from '@/components/not-found/index.vue'

// Page JK
import pageJK from '@/components/pageJK/index.vue';
// const  pageJK = () => import('@/components/pageJK/index.vue')

//Test select
import Test from '@/components/selection/index.vue';

import RouterStart from '@/components/routerStart.vue';
import ipotekaApp from '@/components/ipotekaApp.vue';
Vue.use(VueRouter)

const city = window.location.pathname.split('/')[1];

export default new VueRouter({
  mode: 'history',

  routes: [
    {
      path: '/' + city +'/novostroyki', name: 'mapSearch', component: MapSearch
    },
    {
      path: '/' +city +'/ipoteka',
      name: 'ipotekaSteps',
      component: ipotekaApp,
      children: [

        { path: 'main', name: "main", component: StepOneMain },
        { path: '1', name: "oneOne", component: OneOnePriceApartaments },
        { path: '2', name: "oneTwo", component: OneTwoCalc },
        { path: '3', name: "oneTwoOne", component: OneTwoOneCome },
        { path: '4', name: "oneTwoTwo", component: OneTwoTwoNoDeposit },
        { path: '5', name: "welcome", component: Welcome },
        { path: '6', name: "twoOne", component: TwoOneMonthPay },
        { path: '7', name: "twoTwo", component: TwoTwoMontCalc },
        { path: '8', name: "twoThree", component: TwoThreeChangRoom }

      ]
    },
    { path: '/' + city + '/novostroyki/:alias', name: 'pageJk', component: pageJK },
    { path: '/' + city + '/spa/test', name: 'test', component: Test },
    
    { path: '/' + city + '/not', name: 'not', component: NotFound }



  ]
})

// console.log(window.location.pathname.split('/')[1]);