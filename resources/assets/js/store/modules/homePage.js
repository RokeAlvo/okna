import {
  SET_NUMBER_OF_APARTMENTS,
  SET_NUMBER_OF_RESIDENTIALS,
  GET_ACTIVE_CITY
} from "./home.constants";
export default {
  namespaced: true,
  state: {
    numberOfResidentials: null,
    numberOfApartments: null
  },
  mutations: {
    [SET_NUMBER_OF_RESIDENTIALS](state, payload) {
      state.numberOfResidentials = payload;
    },
    [SET_NUMBER_OF_APARTMENTS](state, payload) {
      state.numberOfApartments = payload;
    }
  },
  actions: {
    init({ commit, getters }, payload) {
      console.log('city:   ', getters[GET_ACTIVE_CITY])
      commit(SET_NUMBER_OF_APARTMENTS, 123555);
      commit(SET_NUMBER_OF_RESIDENTIALS, 666)
    }
  },
  getters: {
    [GET_ACTIVE_CITY](state, getters, rootState, rootGetters) {
      return rootState.activeCity
    }
  }
}