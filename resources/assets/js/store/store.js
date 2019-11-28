import { HTTP, Routes } from "@/components/server/API.js";
import Vue from 'vue';
import Vuex from 'vuex';
import mapSearch from './modules/mapSearch'
import homePage from './modules/homePage'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        mapSearch,
        homePage
    },
    state: {
        cityList: null,
        siteContacts: null,
        activeCity: null,

        menuList: null,

        minPriceState: null,

        currentPrice: null,
        currentPriceState: null,


        currentSum: null,
        currentSumState: null,

        countJK: null,

        currentUnitSumm: null,

        idRooms: null,

        currentJK: null,

        dataStateJK: {
            address: null,
            apartments_price_min: null,
            completion_date_full: null,
            count_parking: null,
            count_underground_parking: null,
            description: null,
            discount_finish: null,
            discount_start: null,
            discount_title: null,
            features: null,
            floor_max: null,
            id: null,
            images: null,
            infrastructures: null,
            installment: null,
            latitude: null,
            longitude: null,
            materials: null,
            metro_station: null,
            minutes_to_metro: null,
            ranges_formatted: null,
            title: null,
            trade_in: null,
        }
    },
    actions: {
        getMenuList(context) {
            return new Promise((resolve, reject) => {
                HTTP.post(Routes.getMenuList, {})
                    .then(({ data }) => {
                        context.commit('setMenuList', data)
                        resolve(data);
                    })
                    .catch(error => {
                        console.log('error: ', error);
                        reject();
                    })
            })
        },
        initialCityList({ commit }, payload) {
            commit('setSiteContacts', payload.siteContacts)
            const cityList = Object.keys(payload.siteContacts)
            commit('setCityList', cityList)
            const cityFromUrl = payload.cityFromUrl
            const activeCity = cityList.indexOf(cityFromUrl) === -1 ? 
                'novosibirsk' : cityFromUrl
            commit('setActiveCity', activeCity)
        }
    },
    mutations: {
        setMenuList(state, menu) {
            state.menuList = menu;
        },
        addStateDate(state, dataStateJK) {
            state.dataStateJK = dataStateJK;
        },
        addCurrentPrice(state, currentPrice) {
            state.currentPrice = currentPrice
        },

        setMinPriceState(state, minPriceState) {
            state.minPriceState = minPriceState
        },

        setCurrentPriceState(state, currentPriceState) {
            state.currentPriceState = currentPriceState
        },

        setCurrentSum(state, currentSum) {
            state.currentSum = currentSum
        },

        setCurrentSumState(state, currentSumState) {
            state.currentSumState = currentSumState
        },

        setCountJK(state, countJK) {
            state.countJK = countJK
        },

        setcurrentUnitSumm(state, currentUnitSumm) {
            state.currentUnitSumm = currentUnitSumm
        },

        setIdRooms(state, idRooms) {
            state.idRooms = idRooms
        },
        setCurrentJk(state, currentJK) {
            state.currentJK = currentJK
        },
        setCityList(state, payload){
            state.cityList = payload
        },
        setSiteContacts(state, payload){
            state.siteContacts = payload
        },
        setActiveCity(state, payload){
            state.activeCity = payload
        }
    },
    // getters: {
    //     cityList() {}
    // },
    strict: process.env.NODE_ENV !== 'production'
})

