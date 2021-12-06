import {createStore} from 'vuex'

export default createStore({
    state: {},
    mutations: {
        SET_LANG(state, payload) {
            console.log(payload);
        }
    },
    actions: {
        setLang({commit}, payload) {
            commit('SET_LANG', payload)
        }
    },
    modules: {}
})
